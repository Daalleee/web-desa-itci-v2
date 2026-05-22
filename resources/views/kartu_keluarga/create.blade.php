@extends('layouts.admin')

@section('title', 'Tambah Kartu Keluarga')

@section('content')
<div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-slate-100 max-w-2xl mx-auto">
    <div class="flex items-center gap-3 mb-6 pb-6 border-b border-slate-100">
        <a href="{{ route('kartu-keluarga.index') }}" class="text-slate-400 hover:text-slate-600 transition">
            <i class="fa-solid fa-arrow-left text-lg"></i>
        </a>
        <h3 class="text-lg font-bold text-slate-800">Formulir Tambah Kartu Keluarga</h3>
    </div>

    @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-800 text-sm rounded-r-lg">
            <ul class="list-disc pl-4 space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('kartu-keluarga.store') }}" method="POST" class="space-y-6">
        @csrf
        
        <!-- Nomor KK -->
        <div>
            <label class="block text-xs uppercase font-bold text-slate-500 mb-2">Nomor Kartu Keluarga (KK) <span class="text-red-500">*</span></label>
            <input type="text" name="nomor_kk" value="{{ old('nomor_kk') }}" required maxlength="16" minlength="16"
                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition"
                   placeholder="Masukkan 16 digit Nomor KK">
        </div>

        <!-- Kepala Keluarga -->
        <div>
            <label class="block text-xs uppercase font-bold text-slate-500 mb-2">Nama Kepala Keluarga <span class="text-red-500">*</span></label>
            <input type="text" name="kepala_keluarga" value="{{ old('kepala_keluarga') }}" required
                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition"
                   placeholder="Masukkan nama lengkap kepala keluarga">
        </div>

        <!-- RT & RW -->
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-xs uppercase font-bold text-slate-500 mb-2">RT <span class="text-red-500">*</span></label>
                <input type="text" name="rt" value="{{ old('rt') }}" required maxlength="3"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition"
                       placeholder="Contoh: 001">
            </div>
            <div>
                <label class="block text-xs uppercase font-bold text-slate-500 mb-2">RW <span class="text-red-500">*</span></label>
                <input type="text" name="rw" value="{{ old('rw') }}" required maxlength="3"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition"
                       placeholder="Contoh: 001">
            </div>
        </div>

        <!-- Alamat -->
        <div>
            <label class="block text-xs uppercase font-bold text-slate-500 mb-2">Alamat Kartu Keluarga <span class="text-red-500">*</span></label>
            <textarea name="alamat" required rows="3"
                      class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition"
                      placeholder="Masukkan alamat KK lengkap">{{ old('alamat') }}</textarea>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end gap-3 pt-6 border-t border-slate-100">
            <a href="{{ route('kartu-keluarga.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-sm font-semibold transition">
                Batal
            </a>
            <button type="submit" class="px-6 py-2.5 bg-emerald-800 hover:bg-emerald-700 text-white rounded-xl text-sm font-semibold transition shadow-lg shadow-emerald-800/20">
                Simpan Kartu Keluarga
            </button>
        </div>
    </form>
</div>
@endsection
