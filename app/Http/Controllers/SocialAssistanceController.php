<?php

namespace App\Http\Controllers;

use App\Models\BantuanSosial;
use App\Models\Warga;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SocialAssistanceController extends Controller
{
    /**
     * Display a listing of the social assistance programs.
     */
    public function index()
    {
        $bantuan = BantuanSosial::withCount('warga')->latest()->paginate(12);
        return view('bantuan.index', compact('bantuan'));
    }

    /**
     * Show the form for creating a new program.
     */
    public function create()
    {
        return view('bantuan.create');
    }

    /**
     * Store a newly created program.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_program' => 'required|string|max:255|unique:bantuan_sosial,nama_program',
            'nominal' => 'required|numeric|min:0',
            'tanggal_penyaluran' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        $bantuan = BantuanSosial::create($validated);
        LogAktivitas::catat("Membuat program bantuan: {$bantuan->nama_program}");
        return redirect()->route('bantuan.index')->with('success', 'Program bantuan berhasil dibuat.');
    }

    /**
     * Display the specified program and its recipients.
     */
    public function show(BantuanSosial $bantuan)
    {
        // Load all citizens that are not already recipients
        $wargaList = Warga::whereDoesntHave('bantuanSosial', function ($q) use ($bantuan) {
            $q->where('bantuan_sosial_id', $bantuan->id);
        })->orderBy('nama_lengkap')->get();

        return view('bantuan.show', compact('bantuan', 'wargaList'));
    }

    /**
     * Show the form for editing the specified program.
     */
    public function edit(BantuanSosial $bantuan)
    {
        return view('bantuan.edit', compact('bantuan'));
    }

    /**
     * Update the specified program.
     */
    public function update(Request $request, BantuanSosial $bantuan)
    {
        $validated = $request->validate([
            'nama_program' => 'required|string|max:255|unique:bantuan_sosial,nama_program,' . $bantuan->id,
            'nominal' => 'required|numeric|min:0',
            'tanggal_penyaluran' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        $bantuan->update($validated);
        LogAktivitas::catat("Memperbarui program bantuan: {$bantuan->nama_program}");
        return redirect()->route('bantuan.index')->with('success', 'Program bantuan berhasil diperbarui.');
    }

    /**
     * Remove the specified program.
     */
    public function destroy(BantuanSosial $bantuan)
    {
        LogAktivitas::catat("Menghapus program bantuan: {$bantuan->nama_program}");
        $bantuan->delete();
        return redirect()->route('bantuan.index')->with('success', 'Program bantuan berhasil dihapus.');
    }

    /**
     * Add a recipient citizen to the program.
     */
    public function addRecipient(Request $request, $bantuanId)
    {
        $request->validate([
            'warga_id' => 'required|exists:warga,id',
            'tanggal_terima' => 'required|date',
        ]);

        $bantuan = BantuanSosial::findOrFail($bantuanId);
        $bantuan->warga()->attach($request->warga_id, ['tanggal_terima' => $request->tanggal_terima]);
        LogAktivitas::catat("Menambahkan warga ID {$request->warga_id} ke program {$bantuan->nama_program}");
        return back()->with('success', 'Penerima berhasil ditambahkan.');
    }

    /**
     * Remove a recipient from the program.
     */
    public function removeRecipient($bantuanId, $wargaId)
    {
        $bantuan = BantuanSosial::findOrFail($bantuanId);
        $bantuan->warga()->detach($wargaId);
        LogAktivitas::catat("Menghapus warga ID {$wargaId} dari program {$bantuan->nama_program}");
        return back()->with('success', 'Penerima berhasil dihapus.');
    }
}
