<?php

namespace App\Http\Controllers;

use App\Models\ArsipDokumen;
use App\Models\Warga;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $query = ArsipDokumen::with('warga');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhereHas('warga', fn($qw) => $qw->where('nama_lengkap', 'like', "%{$search}%"));
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $dokumen = $query->latest()->paginate(12)->withQueryString();
        $wargaList = Warga::where('status_warga', 'Aktif')->get();

        return view('dokumen.index', compact('dokumen', 'wargaList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'warga_id' => 'required|exists:warga,id',
            'judul' => 'required|string|max:255',
            'kategori' => 'required|in:KTP,KK,Akta Lahir,Lainnya',
            'berkas' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'keterangan' => 'nullable|string',
        ]);

        if ($request->hasFile('berkas')) {
            $path = $request->file('berkas')->store('arsip', 'public');
            
            $dokumen = ArsipDokumen::create([
                'warga_id' => $request->warga_id,
                'judul' => $request->judul,
                'kategori' => $request->kategori,
                'jalur_file' => $path,
                'keterangan' => $request->keterangan,
            ]);

            $warga = Warga::find($request->warga_id);
            LogAktivitas::catat("Mengunggah arsip dokumen ({$request->kategori}): {$request->judul} untuk {$warga->nama_lengkap}");

            return back()->with('success', 'Dokumen berhasil diarsipkan.');
        }

        return back()->with('error', 'Gagal mengunggah berkas.');
    }

    public function destroy($id)
    {
        $dokumen = ArsipDokumen::findOrFail($id);
        
        // Hapus file fisik
        if ($dokumen->jalur_file) {
            Storage::disk('public')->delete($dokumen->jalur_file);
        }

        LogAktivitas::catat("Menghapus arsip dokumen: {$dokumen->judul}");
        $dokumen->delete();

        return back()->with('success', 'Dokumen berhasil dihapus.');
    }
}
