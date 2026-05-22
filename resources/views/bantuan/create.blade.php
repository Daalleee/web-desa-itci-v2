@extends('layouts.admin')

@section('title', 'Tambah Program Bantuan')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 md:p-8">
        <div class="flex items-center space-x-4 mb-6">
            <a href="{{ route('bantuan.index') }}" class="w-10 h-10 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl flex items-center justify-center transition">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h3 class="text-xl font-bold text-slate-800">Tambah Program Bantuan</h3>
                <p class="text-sm text-slate-500">Buat program bantuan sosial baru untuk disalurkan ke warga.</p>
            </div>
        </div>

        <form action="{{ route('bantuan.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Nama Program -->
            <div>
                <label for="nama_program" class="block text-xs uppercase font-bold text-slate-500 mb-2">Nama Program Bantuan <span class="text-red-500">*</span></label>
                <input type="text" name="nama_program" id="nama_program" value="{{ old('nama_program') }}" required
                       class="w-full px-4 py-2.5 rounded-xl border @error('nama_program') border-red-300 focus:ring-red-500 @else border-slate-200 focus:ring-emerald-500 @enderror text-slate-800 text-sm focus:outline-none focus:ring-2 focus:border-transparent transition"
                       placeholder="Contoh: BLT Dana Desa Tahap I">
                @error('nama_program')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nominal Bantuan -->
            <div>
                <label for="nominal" class="block text-xs uppercase font-bold text-slate-500 mb-2">Nominal per Penerima (Rp) <span class="text-red-500">*</span></label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm font-semibold">Rp</span>
                    <input type="number" name="nominal" id="nominal" value="{{ old('nominal') }}" required min="0"
                           class="w-full pl-12 pr-4 py-2.5 rounded-xl border @error('nominal') border-red-300 focus:ring-red-500 @else border-slate-200 focus:ring-emerald-500 @enderror text-slate-800 text-sm focus:outline-none focus:ring-2 focus:border-transparent transition"
                           placeholder="300000">
                </div>
                @error('nominal')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tanggal Penyaluran -->
            <div>
                <label for="tanggal_penyaluran" class="block text-xs uppercase font-bold text-slate-500 mb-2">Tanggal Penyaluran <span class="text-red-500">*</span></label>
                <input type="date" name="tanggal_penyaluran" id="tanggal_penyaluran" value="{{ old('tanggal_penyaluran') }}" required
                       class="w-full px-4 py-2.5 rounded-xl border @error('tanggal_penyaluran') border-red-300 focus:ring-red-500 @else border-slate-200 focus:ring-emerald-500 @enderror text-slate-800 text-sm focus:outline-none focus:ring-2 focus:border-transparent transition">
                @error('tanggal_penyaluran')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Keterangan -->
            <div>
                <label for="keterangan" class="block text-xs uppercase font-bold text-slate-500 mb-2">Keterangan / Kriteria Penerima</label>
                <textarea name="keterangan" id="keterangan" rows="4"
                          class="w-full px-4 py-2.5 rounded-xl border @error('keterangan') border-red-300 focus:ring-red-500 @else border-slate-200 focus:ring-emerald-500 @enderror text-slate-800 text-sm focus:outline-none focus:ring-2 focus:border-transparent transition"
                          placeholder="Kriteria wajib penerima atau keterangan tambahan mengenai bantuan ini...">{{ old('keterangan') }}</textarea>
                @error('keterangan')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end gap-3 border-t border-slate-100 pt-6">
                <a href="{{ route('bantuan.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-sm font-semibold transition">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 bg-emerald-800 hover:bg-emerald-700 text-white rounded-xl text-sm font-semibold transition shadow-lg shadow-emerald-800/10">
                    Simpan Program
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
