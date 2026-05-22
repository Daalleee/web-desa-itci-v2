<?php

namespace App\Http\Controllers;

use App\Models\Citizen;
use App\Models\Family;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CitizenController extends Controller
{
    public function index(Request $request)
    {
        $query = Citizen::with('family');

        // Fitur Search Realtime (NIK/Nama)
        if ($request->has('search')) {
            $query->where('full_name', 'like', "%{$request->search}%")
                  ->orWhere('nik', 'like', "%{$request->search}%");
        }

        // Fitur Filter RT/RW
        if ($request->filled('rt')) {
            $query->whereHas('family', fn($q) => $q->where('rt', $request->rt));
        }

        $citizens = $query->paginate(10);
        return view('citizens.index', compact('citizens'));
    }

    public function create()
    {
        $families = Family::all();
        return view('citizens.create', compact('families'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'required|unique:citizens,nik|size:16',
            'full_name' => 'required|string|max:255',
            'family_id' => 'required|exists:families,id',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'birth_place' => 'required|string',
            'birth_date' => 'required|date',
            'religion' => 'required|string',
            'education' => 'required|string',
            'occupation' => 'required|string',
            'marital_status' => 'required|string',
            'family_relation' => 'required|string',
            'address' => 'required|string',
            'photo' => 'nullable|image|max:2048',
            'ktp_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'kk_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();

        // Handle Uploads
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('citizens/photos', 'public');
        }
        if ($request->hasFile('ktp_file')) {
            $data['ktp_file'] = $request->file('ktp_file')->store('citizens/ktp', 'public');
        }
        if ($request->hasFile('kk_file')) {
            $data['kk_file'] = $request->file('kk_file')->store('citizens/kk', 'public');
        }

        Citizen::create($data);
        return redirect()->route('citizens.index')->with('success', 'Data warga berhasil ditambahkan');
    }

    public function show(Citizen $citizen)
    {
        return view('citizens.show', compact('citizen'));
    }

    public function edit(Citizen $citizen)
    {
        $families = Family::all();
        return view('citizens.edit', compact('citizen', 'families'));
    }

    public function update(Request $request, Citizen $citizen)
    {
        $validated = $request->validate([
            'nik' => 'required|size:16|unique:citizens,nik,' . $citizen->id,
            'full_name' => 'required|string|max:255',
            'family_id' => 'required|exists:families,id',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'birth_place' => 'required|string',
            'birth_date' => 'required|date',
            'religion' => 'required|string',
            'education' => 'required|string',
            'occupation' => 'required|string',
            'marital_status' => 'required|string',
            'family_relation' => 'required|string',
            'address' => 'required|string',
            'photo' => 'nullable|image|max:2048',
            'ktp_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'kk_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();

        // Handle File Updates & Deletions
        foreach (['photo', 'ktp_file', 'kk_file'] as $fileField) {
            if ($request->hasFile($fileField)) {
                if ($citizen->$fileField) {
                    Storage::disk('public')->delete($citizen->$fileField);
                }
                $data[$fileField] = $request->file($fileField)->store("citizens/$fileField", 'public');
            }
        }

        $citizen->update($data);
        return redirect()->route('citizens.index')->with('success', 'Data warga berhasil diperbarui');
    }

    public function destroy(Citizen $citizen)
    {
        // Soft delete otomatis karena trait di Model
        $citizen->delete();
        return redirect()->route('citizens.index')->with('success', 'Data warga berhasil dihapus (Soft Delete)');
    }

    public function export()
    {
        // Placeholder untuk fitur export
        return response()->json(['message' => 'Fitur Export Excel akan segera hadir']);
    }
}