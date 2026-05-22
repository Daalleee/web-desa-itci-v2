@extends('layouts.admin')

@section('title', 'Tambah Pengguna')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
    <h2 class="text-2xl font-bold text-slate-800 mb-6">Form Tambah Pengguna</h2>

    @if($errors->any() || session('success'))
        <div x-data="{show:true}" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
             class="mb-6 p-4 rounded-r-lg transition-opacity duration-300 {{ $errors->any() ? 'bg-red-50 border-l-4 border-red-500 text-red-800' : 'bg-green-50 border-l-4 border-green-500 text-green-800' }}">
            @if($errors->any())
                <ul class="list-disc pl-4 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @elseif(session('success'))
                <p class="font-medium">{{ session('success') }}</p>
            @endif
        </div>
    @endif

    <form action="{{ route('users.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Nama -->
        <div>
            <label class="block text-xs uppercase font-bold text-slate-500 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
            <input type="text" name="name" value="{{ old('name') }}" required
                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
        </div>

        <!-- Username -->
        <div>
            <label class="block text-xs uppercase font-bold text-slate-500 mb-2">Username <span class="text-red-500">*</span></label>
            <input type="text" name="username" value="{{ old('username') }}" required
                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
        </div>

        <!-- Email -->
        <div>
            <label class="block text-xs uppercase font-bold text-slate-500 mb-2">Email <span class="text-red-500">*</span></label>
            <input type="email" name="email" value="{{ old('email') }}" required
                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
        </div>

        <!-- Password -->
        <div>
            <label class="block text-xs uppercase font-bold text-slate-500 mb-2">Password <span class="text-red-500">*</span></label>
            <input type="password" name="password" required
                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
        </div>
        <div>
            <label class="block text-xs uppercase font-bold text-slate-500 mb-2">Konfirmasi Password <span class="text-red-500">*</span></label>
            <input type="password" name="password_confirmation" required
                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
        </div>

        <!-- Role -->
        <div>
            <label class="block text-xs uppercase font-bold text-slate-500 mb-2">Peran <span class="text-red-500">*</span></label>
            <select name="role" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                <option value="">-- Pilih Peran --</option>
                <option value="Super Admin" {{ old('role') == 'Super Admin' ? 'selected' : '' }}>Super Admin</option>
                <option value="Operator Desa" {{ old('role') == 'Operator Desa' ? 'selected' : '' }}>Operator Desa</option>
                <option value="Kepala Desa" {{ old('role') == 'Kepala Desa' ? 'selected' : '' }}>Kepala Desa</option>
                <option value="Ketua RT" {{ old('role') == 'Ketua RT' ? 'selected' : '' }}>Ketua RT</option>
            </select>
        </div>

        <!-- RT/RW (optional, only for Ketua RT) -->
        <div>
            <label class="block text-xs uppercase font-bold text-slate-500 mb-2">RT / RW (hanya untuk Ketua RT)</label>
            <input type="text" name="rt_rw" value="{{ old('rt_rw') }}" maxlength="3"
                   placeholder="Contoh: 001" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
        </div>

        <div class="flex justify-end gap-3 pt-4">
            <a href="{{ route('users.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-sm font-semibold transition">
                Batal
            </a>
            <button type="submit" class="px-6 py-2.5 bg-emerald-800 hover:bg-emerald-700 text-white rounded-xl text-sm font-semibold transition shadow-lg shadow-emerald-800/20">
                Simpan Pengguna
            </button>
        </div>
    </form>
</div>
@endsection
