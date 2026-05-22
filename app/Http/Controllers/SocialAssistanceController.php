<?php

namespace App\Http\Controllers;

use App\Models\BantuanSosial;
use App\Models\Warga;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;

class SocialAssistanceController extends Controller
{
    public function index(Request $request)
    {
        $query = BantuanSosial::withCount('warga');

        if ($request->filled('search')) {
            $query->where('nama_program', 'like', "%{$request->search}%");
        }

        $bantuan = $query->latest()->paginate(10)->withQueryString();

        return view('bantuan.index', compact('bantuan'));
    }

    public function create()
    {
        return view('bantuan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_program' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'nominal' => 'required|numeric|min:0',
            'tanggal_penyaluran' => 'required|date',
        ]);

        $bantuan = BantuanSosial::create($validated);

        LogAktivitas::catat("Membuat program bantuan sosial baru: {$bantuan->nama_program}");

        return redirect()->route('bantuan.index')->with('success', 'Program bantuan berhasil dibuat');
    }

    public function show(BantuanSosial $bantuan)
    {
        $bantuan->load('warga');
        // Ambil warga yang belum terdaftar di bantuan ini untuk opsi tambah penerima
        $penerimaIds = $bantuan->warga->pluck('id')->toArray();
        $wargaList = Warga::where('status_warga', 'Aktif')
            ->whereNotIn('id', $penerimaIds)
            ->get();

        return view('bantuan.show', compact('bantuan', 'wargaList'));
    }

    public function edit(BantuanSosial $bantuan)
    {
        return view('bantuan.edit', compact('bantuan'));
    }

    public function update(Request $request, BantuanSosial $bantuan)
    {
        $validated = $request->validate([
            'nama_program' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'nominal' => 'required|numeric|min:0',
            'tanggal_penyaluran' => 'required|date',
        ]);

        $bantuan->update($validated);

        LogAktivitas::catat("Memperbarui program bantuan sosial: {$bantuan->nama_program}");

        return redirect()->route('bantuan.index')->with('success', 'Program bantuan berhasil diperbarui');
    }

    public function destroy(BantuanSosial $bantuan)
    {
        LogAktivitas::catat("Menghapus program bantuan sosial: {$bantuan->nama_program}");
        $bantuan->delete();
        return redirect()->route('bantuan.index')->with('success', 'Program bantuan berhasil dihapus');
    }

    public function addRecipient(Request $request, BantuanSosial $bantuan)
    {
        $validated = $request->validate([
            'warga_id' => 'required|exists:warga,id',
            'tanggal_terima' => 'required|date',
        ]);

        // Cek jika sudah terdaftar
        if ($bantuan->warga()->where('warga_id', $request->warga_id)->exists()) {
            return back()->with('error', 'Warga tersebut sudah terdaftar sebagai penerima.');
        }

        $bantuan->warga()->attach($request->warga_id, ['tanggal_terima' => $request->tanggal_terima]);
        
        $warga = Warga::find($request->warga_id);
        LogAktivitas::catat("Menambahkan penerima bantuan {$bantuan->nama_program}: {$warga->nama_lengkap}");

        return back()->with('success', 'Penerima bantuan berhasil ditambahkan');
    }

    public function removeRecipient(BantuanSosial $bantuan, $wargaId)
    {
        $bantuan->warga()->detach($wargaId);
        
        $warga = Warga::find($wargaId);
        LogAktivitas::catat("Menghapus penerima bantuan {$bantuan->nama_program}: {$warga->nama_lengkap}");

        return back()->with('success', 'Penerima bantuan berhasil dihapus');
    }
}
