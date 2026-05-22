<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\Warga;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;

class LetterController extends Controller
{
    public function index(Request $request)
    {
        $query = Surat::with('warga');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nomor_surat', 'like', "%{$search}%")
                  ->orWhereHas('warga', fn($qw) => $qw->where('nama_lengkap', 'like', "%{$search}%"));
            });
        }

        if ($request->filled('jenis_surat')) {
            $query->where('jenis_surat', $request->jenis_surat);
        }

        $surat = $query->latest()->paginate(10)->withQueryString();

        return view('surat.index', compact('surat'));
    }

    public function create(Request $request)
    {
        $wargaList = Warga::where('status_warga', 'Aktif')->get();
        $selectedWarga = null;

        if ($request->filled('warga_id')) {
            $selectedWarga = Warga::find($request->warga_id);
        }

        return view('surat.create', compact('wargaList', 'selectedWarga'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'warga_id' => 'required|exists:warga,id',
            'jenis_surat' => 'required|in:Domisili,Kelahiran,Kematian,Usaha,Tidak Mampu,Pindah',
            'keperluan' => 'required|string',
            'ditandatangani_oleh' => 'required|string|max:255',
            // Field dinamis tambahan
            'nama_usaha' => 'nullable|string|required_if:jenis_surat,Usaha',
            'alamat_usaha' => 'nullable|string|required_if:jenis_surat,Usaha',
            'pindah_ke' => 'nullable|string|required_if:jenis_surat,Pindah',
            'tanggal_kematian' => 'nullable|date|required_if:jenis_surat,Kematian',
            'tanggal_kelahiran' => 'nullable|date|required_if:jenis_surat,Kelahiran',
        ]);

        // Auto Generate Nomor Surat: Contoh: 001/DS-ITCI/V/2026
        $count = Surat::whereYear('created_at', date('Y'))->count() + 1;
        $romanMonths = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
            7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
        ];
        $romanMonth = $romanMonths[date('n')];
        $year = date('Y');
        $nomorSurat = sprintf("%03d/DS-ITCI/%s/%s", $count, $romanMonth, $year);

        // Ekstrak informasi tambahan
        $informasiTambahan = [];
        if ($request->jenis_surat === 'Usaha') {
            $informasiTambahan['nama_usaha'] = $request->nama_usaha;
            $informasiTambahan['alamat_usaha'] = $request->alamat_usaha;
        } elseif ($request->jenis_surat === 'Pindah') {
            $informasiTambahan['pindah_ke'] = $request->pindah_ke;
        } elseif ($request->jenis_surat === 'Kematian') {
            $informasiTambahan['tanggal_kematian'] = $request->tanggal_kematian;
        } elseif ($request->jenis_surat === 'Kelahiran') {
            $informasiTambahan['tanggal_kelahiran'] = $request->tanggal_kelahiran;
        }

        $surat = Surat::create([
            'warga_id' => $request->warga_id,
            'nomor_surat' => $nomorSurat,
            'jenis_surat' => $request->jenis_surat,
            'keperluan' => $request->keperluan,
            'dibuat_oleh' => auth()->user()->name,
            'ditandatangani_oleh' => $request->ditandatangani_oleh,
            'status' => 'Disetujui',
            'informasi_tambahan' => $informasiTambahan,
        ]);

        LogAktivitas::catat("Membuat Surat {$request->jenis_surat} baru (No. Surat: {$nomorSurat})");

        return redirect()->route('surat.show', $surat->id)->with('success', 'Surat berhasil dibuat');
    }

    public function show($id)
    {
        $surat = Surat::with('warga.kartuKeluarga')->findOrFail($id);
        
        // Link verifikasi untuk QR Code
        $verificationUrl = route('surat.verify', $surat->id);
        
        return view('surat.show', compact('surat', 'verificationUrl'));
    }

    public function verify($id)
    {
        // Rute Publik untuk scan QR
        $surat = Surat::with('warga')->findOrFail($id);
        return view('surat.verify', compact('surat'));
    }

    public function destroy($id)
    {
        $surat = Surat::findOrFail($id);
        LogAktivitas::catat("Menghapus Surat (No. Surat: {$surat->nomor_surat})");
        $surat->delete();
        return redirect()->route('surat.index')->with('success', 'Surat berhasil dihapus');
    }
}
