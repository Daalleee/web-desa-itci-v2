<?php

namespace App\Http\Controllers;

use App\Models\Family;
use Illuminate\Http\Request;

class FamilyController extends Controller
{
    public function index(Request $request)
    {
        $query = Family::query();

        if ($request->filled('search')) {
            $query->where('family_card_number', 'like', "%{$request->search}%")
                  ->orWhere('head_of_family', 'like', "%{$request->search}%");
        }

        $families = $query->paginate(10);
        return view('families.index', compact('families'));
    }

    public function create()
    {
        return view('families.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'family_card_number' => 'required|size:16|unique:families,family_card_number',
            'head_of_family' => 'required|string|max:255',
            'address' => 'required|string',
            'rt' => 'required|string|max:3',
            'rw' => 'required|string|max:3',
        ]);

        Family::create($validated);
        return redirect()->route('families.index')->with('success', 'Data KK berhasil ditambahkan');
    }

    public function show(Family $family)
    {
        $family->load('citizens'); // Menampilkan anggota keluarga
        return view('families.show', compact('family'));
    }

    public function edit(Family $family)
    {
        return view('families.edit', compact('family'));
    }

    public function update(Request $request, Family $family)
    {
        $validated = $request->validate([
            'family_card_number' => 'required|size:16|unique:families,family_card_number,' . $family->id,
            'head_of_family' => 'required|string|max:255',
            'address' => 'required|string',
            'rt' => 'required|string|max:3',
            'rw' => 'required|string|max:3',
        ]);

        $family->update($validated);
        return redirect()->route('families.index')->with('success', 'Data KK berhasil diperbarui');
    }

    public function destroy(Family $family)
    {
        $family->delete();
        return redirect()->route('families.index')->with('success', 'Data KK berhasil dihapus');
    }
}