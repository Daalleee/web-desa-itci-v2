<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use App\Models\KartuKeluarga;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WargaController extends Controller
{
    public function index(Request $request)
    {
        $query = Warga::with('kartuKeluarga');

        // Ketua RT hanya bisa melihat warga dari RT miliknya
        if (auth()->user()->role === 'Ketua RT') {
            $query->whereHas('kartuKeluarga', fn($q) => $q->where('rt', auth()->user()->rt_rw));
        }

        // Search Realtime (NIK/Nama)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        // Filter RT/RW
        if ($request->filled('rt')) {
            $query->whereHas('kartuKeluarga', fn($q) => $q->where('rt', $request->rt));
        }
        if ($request->filled('rw')) {
            $query->whereHas('kartuKeluarga', fn($q) => $q->where('rw', $request->rw));
        }

        // Filter Status Warga
        if ($request->filled('status_warga')) {
            $query->where('status_warga', $request->status_warga);
        }

        // Filter Agama
        if ($request->filled('agama')) {
            $query->where('agama', $request->agama);
        }

        // Filter Pendidikan
        if ($request->filled('pendidikan')) {
            $query->where('pendidikan', $request->pendidikan);
        }

        $warga = $query->latest()->paginate(10)->withQueryString();

        return view('warga.index', compact('warga'));
    }

    public function create()
    {
        if (!in_array(auth()->user()->role, ['Super Admin', 'Operator Desa'])) {
            abort(403, 'Anda tidak memiliki hak akses untuk menambah data warga.');
        }
        $kartuKeluarga = KartuKeluarga::all();
        return view('warga.create', compact('kartuKeluarga'));
    }

    public function store(Request $request)
    {
        if (!in_array(auth()->user()->role, ['Super Admin', 'Operator Desa'])) {
            abort(403, 'Anda tidak memiliki hak akses untuk menambah data warga.');
        }
        $validated = $request->validate([
            'nik' => 'required|digits:16|unique:warga,nik',
            'nama_lengkap' => 'required|string|max:255',
            'kartu_keluarga_id' => 'required|exists:kartu_keluarga,id',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|string|max:100',
            'pendidikan' => 'required|string|max:100',
            'pekerjaan' => 'required|string|max:100',
            'status_perkawinan' => 'required|string|max:100',
            'hubungan_keluarga' => 'required|string|max:100',
            'alamat' => 'required|string',
            'nomor_telepon' => 'nullable|string|max:20',
            'status_warga' => 'required|in:Aktif,Pendatang,Pindah,Meninggal',
            'foto' => 'nullable|image|max:2048',
            'berkas_ktp' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'berkas_kk' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $data = $validated;

        // Handle File Uploads
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('warga/foto', 'public');
        }
        if ($request->hasFile('berkas_ktp')) {
            $data['berkas_ktp'] = $request->file('berkas_ktp')->store('warga/ktp', 'public');
        }
        if ($request->hasFile('berkas_kk')) {
            $data['berkas_kk'] = $request->file('berkas_kk')->store('warga/kk', 'public');
        }

        $warga = Warga::create($data);

        // Catat log aktivitas
        LogAktivitas::catat("Menambahkan warga baru: {$warga->nama_lengkap} (NIK: {$warga->nik})");

        // Jika dia adalah berkas baru, catat di tabel arsip_dokumen secara otomatis jika file di-upload
        foreach (['berkas_ktp' => 'KTP', 'berkas_kk' => 'KK'] as $field => $kategori) {
            if (isset($data[$field])) {
                \App\Models\ArsipDokumen::create([
                    'warga_id' => $warga->id,
                    'judul' => "Dokumen {$kategori} - {$warga->nama_lengkap}",
                    'kategori' => $kategori,
                    'jalur_file' => $data[$field],
                    'keterangan' => 'Diunggah otomatis saat input warga'
                ]);
            }
        }

        return redirect()->route('warga.index')->with('success', 'Data warga berhasil ditambahkan');
    }

    public function show(Warga $warga)
    {
        // Ketua RT hanya bisa melihat detail warga dari RT miliknya
        if (auth()->user()->role === 'Ketua RT' && (!$warga->kartuKeluarga || $warga->kartuKeluarga->rt !== auth()->user()->rt_rw)) {
            abort(403, 'Anda tidak memiliki hak akses untuk data warga di luar RT Anda.');
        }
        $warga->load(['kartuKeluarga', 'surat', 'bantuanSosial', 'arsipDokumen']);
        return view('warga.show', compact('warga'));
    }

    public function edit(Warga $warga)
    {
        if (!in_array(auth()->user()->role, ['Super Admin', 'Operator Desa'])) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengedit data warga.');
        }
        $kartuKeluarga = KartuKeluarga::all();
        return view('warga.edit', compact('warga', 'kartuKeluarga'));
    }

    public function update(Request $request, Warga $warga)
    {
        if (!in_array(auth()->user()->role, ['Super Admin', 'Operator Desa'])) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengedit data warga.');
        }
        $validated = $request->validate([
            'nik' => 'required|digits:16|unique:warga,nik,' . $warga->id,
            'nama_lengkap' => 'required|string|max:255',
            'kartu_keluarga_id' => 'required|exists:kartu_keluarga,id',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|string|max:100',
            'pendidikan' => 'required|string|max:100',
            'pekerjaan' => 'required|string|max:100',
            'status_perkawinan' => 'required|string|max:100',
            'hubungan_keluarga' => 'required|string|max:100',
            'alamat' => 'required|string',
            'nomor_telepon' => 'nullable|string|max:20',
            'status_warga' => 'required|in:Aktif,Pendatang,Pindah,Meninggal',
            'foto' => 'nullable|image|max:2048',
            'berkas_ktp' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'berkas_kk' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $data = $validated;

        // Handle File Uploads and Delete old files if replaced
        foreach (['foto', 'berkas_ktp', 'berkas_kk'] as $field) {
            if ($request->hasFile($field)) {
                if ($warga->$field) {
                    Storage::disk('public')->delete($warga->$field);
                }
                $data[$field] = $request->file($field)->store("warga/{$field}", 'public');

                // Update/Create di arsip dokumen jika berkas_ktp / berkas_kk dirubah
                if ($field !== 'foto') {
                    $kategori = ($field === 'berkas_ktp') ? 'KTP' : 'KK';
                    \App\Models\ArsipDokumen::create([
                        'warga_id' => $warga->id,
                        'judul' => "Dokumen {$kategori} Terbaru - {$warga->nama_lengkap}",
                        'kategori' => $kategori,
                        'jalur_file' => $data[$field],
                        'keterangan' => 'Diperbarui saat edit warga'
                    ]);
                }
            }
        }

        $warga->update($data);

        // Catat log aktivitas
        LogAktivitas::catat("Memperbarui data warga: {$warga->nama_lengkap} (NIK: {$warga->nik})");

        return redirect()->route('warga.index')->with('success', 'Data warga berhasil diperbarui');
    }

    public function destroy(Warga $warga)
    {
        if (!in_array(auth()->user()->role, ['Super Admin', 'Operator Desa'])) {
            abort(403, 'Anda tidak memiliki hak akses untuk menghapus data warga.');
        }
        LogAktivitas::catat("Menghapus data warga (soft delete): {$warga->nama_lengkap} (NIK: {$warga->nik})");
        $warga->delete();
        return redirect()->route('warga.index')->with('success', 'Data warga berhasil dihapus (Soft Delete)');
    }
}
