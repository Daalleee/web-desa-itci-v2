@extends('layouts.admin')

@section('title', 'Buat Surat Keterangan Baru')

@section('content')
<div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-slate-100 max-w-2xl mx-auto">
    <div class="flex items-center gap-3 mb-6 pb-6 border-b border-slate-100">
        <a href="{{ route('surat.index') }}" class="text-slate-400 hover:text-slate-600 transition">
            <i class="fa-solid fa-arrow-left text-lg"></i>
        </a>
        <h3 class="text-lg font-bold text-slate-800">Pembuat Surat Otomatis</h3>
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

    <!-- Langkah 1: Pilih Warga -->
    <form action="{{ route('surat.create') }}" method="GET" class="mb-8 p-4 bg-slate-50 rounded-xl space-y-4">
        <div>
            <label class="block text-xs uppercase font-bold text-slate-500 mb-2">Langkah 1: Pilih Warga Penerima Surat <span class="text-red-500">*</span></label>
            <div class="flex gap-2">
                <select name="warga_id" required onchange="this.form.submit()" class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white">
                    <option value="">-- Pilih Warga Penerima Surat --</option>
                    @foreach($wargaList as $w)
                        <option value="{{ $w->id }}" {{ (request('warga_id') == $w->id || (isset($selectedWarga) && $selectedWarga->id == $w->id)) ? 'selected' : '' }}>
                            {{ $w->nama_lengkap }} (NIK: {{ $w->nik }})
                        </option>
                    @endforeach
                </select>
                <noscript>
                    <button type="submit" class="px-4 py-2 bg-emerald-850 hover:bg-emerald-700 text-white rounded-xl text-sm font-semibold transition">
                        Pilih
                    </button>
                </noscript>
            </div>
        </div>
    </form>

    <!-- Langkah 2: Lengkapi Detail Surat -->
    @if(isset($selectedWarga))
        <form action="{{ route('surat.store') }}" method="POST" class="space-y-6" x-data="{ jenisSurat: '{{ old('jenis_surat', 'Domisili') }}' }">
            @csrf
            <input type="hidden" name="warga_id" value="{{ $selectedWarga->id }}">

            <!-- Tipe Surat -->
            <div>
                <label class="block text-xs uppercase font-bold text-slate-500 mb-2">Langkah 2: Pilih Jenis Surat Keterangan <span class="text-red-500">*</span></label>
                <select name="jenis_surat" x-model="jenisSurat" required 
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <option value="Domisili">Surat Keterangan Domisili</option>
                    <option value="Kelahiran">Surat Keterangan Kelahiran</option>
                    <option value="Kematian">Surat Keterangan Kematian</option>
                    <option value="Usaha">Surat Keterangan Usaha (SKU)</option>
                    <option value="Tidak Mampu">Surat Keterangan Tidak Mampu (SKTM)</option>
                    <option value="Pindah">Surat Keterangan Pindah</option>
                </select>
            </div>

            <!-- Field Dinamis SKU -->
            <div x-show="jenisSurat === 'Usaha'" x-transition class="p-4 bg-emerald-50/50 border border-emerald-100 rounded-xl space-y-4">
                <h5 class="text-xs uppercase font-bold text-emerald-800">Detail Surat Keterangan Usaha</h5>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Nama Usaha / Toko <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_usaha" value="{{ old('nama_usaha') }}" :required="jenisSurat === 'Usaha'"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white"
                           placeholder="Contoh: Toko Sembako Makmur">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Alamat/Lokasi Usaha <span class="text-red-500">*</span></label>
                    <input type="text" name="alamat_usaha" value="{{ old('alamat_usaha') }}" :required="jenisSurat === 'Usaha'"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white"
                           placeholder="Contoh: Jl. Poros ITCI RT 002">
                </div>
            </div>

            <!-- Field Dinamis Pindah -->
            <div x-show="jenisSurat === 'Pindah'" x-transition class="p-4 bg-blue-50/50 border border-blue-100 rounded-xl space-y-4">
                <h5 class="text-xs uppercase font-bold text-blue-800">Detail Surat Keterangan Pindah</h5>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Alamat Tujuan Pindah Lengkap <span class="text-red-500">*</span></label>
                    <textarea name="pindah_ke" rows="2" :required="jenisSurat === 'Pindah'"
                              class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white"
                              placeholder="Masukkan alamat tujuan beserta kelurahan, kecamatan dan kota">{{ old('pindah_ke') }}</textarea>
                </div>
            </div>

            <!-- Field Dinamis Kematian -->
            <div x-show="jenisSurat === 'Kematian'" x-transition class="p-4 bg-rose-50/50 border border-rose-100 rounded-xl space-y-4">
                <h5 class="text-xs uppercase font-bold text-rose-800">Detail Surat Keterangan Kematian</h5>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Tanggal Meninggal Dunia <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_kematian" value="{{ old('tanggal_kematian') }}" :required="jenisSurat === 'Kematian'"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white">
                </div>
            </div>

            <!-- Field Dinamis Kelahiran -->
            <div x-show="jenisSurat === 'Kelahiran'" x-transition class="p-4 bg-cyan-50/50 border border-cyan-100 rounded-xl space-y-4">
                <h5 class="text-xs uppercase font-bold text-cyan-800">Detail Surat Keterangan Kelahiran</h5>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Tanggal Kelahiran Anak <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_kelahiran" value="{{ old('tanggal_kelahiran') }}" :required="jenisSurat === 'Kelahiran'"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white">
                </div>
            </div>

            <!-- Keperluan -->
            <div>
                <label class="block text-xs uppercase font-bold text-slate-500 mb-2">Keperluan Surat <span class="text-red-500">*</span></label>
                <textarea name="keperluan" required rows="3"
                          class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition"
                          placeholder="Contoh: Persyaratan melamar pekerjaan / pengajuan beasiswa kuliah">{{ old('keperluan') }}</textarea>
            </div>

            <!-- Penandatangan -->
            <div>
                <label class="block text-xs uppercase font-bold text-slate-500 mb-2">Ditandatangani Oleh <span class="text-red-500">*</span></label>
                <select name="ditandatangani_oleh" required 
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <option value="Kepala Desa ITCI">Kepala Desa ITCI</option>
                    <option value="Sekretaris Desa ITCI">Sekretaris Desa ITCI</option>
                </select>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end gap-3 pt-6 border-t border-slate-100">
                <a href="{{ route('surat.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-sm font-semibold transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-emerald-800 hover:bg-emerald-700 text-white rounded-xl text-sm font-semibold transition shadow-lg shadow-emerald-800/20">
                    Generate & Cetak Surat
                </button>
            </div>
        </form>
    @else
        <div class="text-center py-8 text-slate-400 border border-dashed border-slate-200 rounded-2xl">
            <i class="fa-solid fa-arrow-pointer text-3xl mb-2 text-slate-300"></i>
            <p class="text-sm">Silakan pilih warga di atas untuk mulai membuat surat.</p>
        </div>
    @endif
</div>
@endsection
