<?php

namespace App\Http\Controllers;

use App\Models\KartuKeluarga;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;

class KartuKeluargaController extends Controller
{
    public function index(Request $request)
    {
        $query = KartuKeluarga::query();

        // Ketua RT hanya bisa melihat KK dari RT miliknya
        if (auth()->user()->role === 'Ketua RT') {
            $query->where('rt', auth()->user()->rt_rw);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nomor_kk', 'like', "%{$search}%")
                  ->orWhere('kepala_keluarga', 'like', "%{$search}%");
            });
        }

        if ($request->filled('rt')) {
            $query->where('rt', $request->rt);
        }

        if ($request->filled('rw')) {
            $query->where('rw', $request->rw);
        }

        $kartuKeluarga = $query->latest()->paginate(10)->withQueryString();

        return view('kartu_keluarga.index', compact('kartuKeluarga'));
    }

    public function create()
    {
        if (!in_array(auth()->user()->role, ['Super Admin', 'Operator Desa'])) {
            abort(403, 'Anda tidak memiliki hak akses untuk menambah Kartu Keluarga.');
        }
        return view('kartu_keluarga.create');
    }

    public function store(Request $request)
    {
        if (!in_array(auth()->user()->role, ['Super Admin', 'Operator Desa'])) {
            abort(403, 'Anda tidak memiliki hak akses untuk menambah Kartu Keluarga.');
        }
        $validated = $request->validate([
            'nomor_kk' => 'required|digits:16|unique:kartu_keluarga,nomor_kk',
            'kepala_keluarga' => 'required|string|max:255',
            'alamat' => 'required|string',
            'rt' => 'required|string|max:3',
            'rw' => 'required|string|max:3',
        ]);

        $kk = KartuKeluarga::create($validated);

        LogAktivitas::catat("Menambahkan Kartu Keluarga baru: No. KK {$kk->nomor_kk} (Kepala: {$kk->kepala_keluarga})");

        return redirect()->route('kartu-keluarga.index')->with('success', 'Data KK berhasil ditambahkan');
    }

    public function show(KartuKeluarga $kartuKeluarga)
    {
        // Ketua RT hanya bisa melihat detail KK dari RT miliknya
        if (auth()->user()->role === 'Ketua RT' && $kartuKeluarga->rt !== auth()->user()->rt_rw) {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat Kartu Keluarga di luar RT Anda.');
        }
        $kartuKeluarga->load('warga');
        return view('kartu_keluarga.show', compact('kartuKeluarga'));
    }

    public function edit(KartuKeluarga $kartuKeluarga)
    {
        if (!in_array(auth()->user()->role, ['Super Admin', 'Operator Desa'])) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengedit Kartu Keluarga.');
        }
        return view('kartu_keluarga.edit', compact('kartuKeluarga'));
    }

    public function update(Request $request, KartuKeluarga $kartuKeluarga)
    {
        if (!in_array(auth()->user()->role, ['Super Admin', 'Operator Desa'])) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengedit Kartu Keluarga.');
        }
        $validated = $request->validate([
            'nomor_kk' => 'required|digits:16|unique:kartu_keluarga,nomor_kk,' . $kartuKeluarga->id,
            'kepala_keluarga' => 'required|string|max:255',
            'alamat' => 'required|string',
            'rt' => 'required|string|max:3',
            'rw' => 'required|string|max:3',
        ]);

        $kartuKeluarga->update($validated);

        LogAktivitas::catat("Memperbarui data Kartu Keluarga: No. KK {$kartuKeluarga->nomor_kk}");

        return redirect()->route('kartu-keluarga.index')->with('success', 'Data KK berhasil diperbarui');
    }

    public function destroy(KartuKeluarga $kartuKeluarga)
    {
        if (!in_array(auth()->user()->role, ['Super Admin', 'Operator Desa'])) {
            abort(403, 'Anda tidak memiliki hak akses untuk menghapus Kartu Keluarga.');
        }
        LogAktivitas::catat("Menghapus Kartu Keluarga (soft delete): No. KK {$kartuKeluarga->nomor_kk}");
        $kartuKeluarga->delete();
        return redirect()->route('kartu-keluarga.index')->with('success', 'Data KK berhasil dihapus');
    }
}
