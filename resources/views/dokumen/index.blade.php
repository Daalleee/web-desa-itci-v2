@extends('layouts.admin')

@section('title', 'Arsip Dokumen')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <!-- Kolom Kiri: Form Upload Dokumen -->
    <div class="lg:col-span-1">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <h3 class="text-md font-bold text-slate-800 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-cloud-arrow-up text-emerald-600"></i> Unggah Dokumen Baru
            </h3>

            <form action="{{ route('dokumen.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                
                <!-- Pemilik Dokumen -->
                <div>
                    <label for="warga_id" class="block text-xs uppercase font-bold text-slate-500 mb-2">Pemilik Dokumen <span class="text-red-500">*</span></label>
                    <select name="warga_id" id="warga_id" required class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        <option value="">-- Pilih Warga --</option>
                        @foreach($wargaList as $w)
                            <option value="{{ $w->id }}">{{ $w->nama_lengkap }} (NIK: {{ $w->nik }})</option>
                        @endforeach
                    </select>
                    @error('warga_id')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Judul Dokumen -->
                <div>
                    <label for="judul" class="block text-xs uppercase font-bold text-slate-500 mb-2">Judul Dokumen <span class="text-red-500">*</span></label>
                    <input type="text" name="judul" id="judul" required value="{{ old('judul') }}"
                           class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                           placeholder="Contoh: Akta Kelahiran Budi">
                    @error('judul')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kategori -->
                <div>
                    <label for="kategori" class="block text-xs uppercase font-bold text-slate-500 mb-2">Kategori <span class="text-red-500">*</span></label>
                    <select name="kategori" id="kategori" required class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        <option value="KTP">KTP</option>
                        <option value="KK">KK</option>
                        <option value="Akta Lahir">Akta Lahir</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                    @error('kategori')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Berkas -->
                <div>
                    <label for="berkas" class="block text-xs uppercase font-bold text-slate-500 mb-2">Pilih File Berkas <span class="text-red-500">*</span></label>
                    <input type="file" name="berkas" id="berkas" required
                           class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 border border-slate-200 rounded-xl p-1 bg-white">
                    <span class="text-[10px] text-slate-400 block mt-1">Format: PDF, JPG, JPEG, PNG (Maks: 2MB)</span>
                    @error('berkas')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Keterangan -->
                <div>
                    <label for="keterangan" class="block text-xs uppercase font-bold text-slate-500 mb-2">Keterangan Tambahan</label>
                    <textarea name="keterangan" id="keterangan" rows="3"
                              class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                              placeholder="Catatan mengenai berkas..."></textarea>
                    @error('keterangan')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full py-2.5 bg-green-700 hover:bg-green-600 text-white rounded-xl text-sm font-semibold transition shadow-lg shadow-green-700/10 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-file-arrow-up"></i> Unggah Dokumen
                </button>
            </form>
        </div>
    </div>

    <!-- Kolom Kanan: Daftar Dokumen Terarsip -->
    <div class="lg:col-span-2 space-y-6">
        
        <!-- Filter & Cari Dokumen -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <form action="{{ route('dokumen.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4">
                <div class="relative flex-1">
                    <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}"
                           class="w-full pl-11 pr-4 py-2.5 rounded-xl border border-slate-200 text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition"
                           placeholder="Cari judul dokumen atau nama warga...">
                </div>

                <div class="w-full sm:w-48">
                    <select name="kategori" onchange="this.form.submit()" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        <option value="">Semua Kategori</option>
                        <option value="KTP" {{ request('kategori') == 'KTP' ? 'selected' : '' }}>KTP</option>
                        <option value="KK" {{ request('kategori') == 'KK' ? 'selected' : '' }}>KK</option>
                        <option value="Akta Lahir" {{ request('kategori') == 'Akta Lahir' ? 'selected' : '' }}>Akta Lahir</option>
                        <option value="Lainnya" {{ request('kategori') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>

                <button type="submit" class="px-5 py-2.5 bg-emerald-700 hover:bg-emerald-600 text-white rounded-xl text-sm font-semibold transition shadow-lg shadow-emerald-700/10">
                    Cari
                </button>
            </form>
        </div>

        <!-- Grid Cards Dokumen -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            @forelse($dokumen as $doc)
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 flex flex-col justify-between hover:shadow-md transition duration-200">
                    <div>
                        <!-- Header Card Dokumen -->
                        <div class="flex items-center justify-between mb-4">
                            @php
                                $badgeColors = [
                                    'KTP' => 'bg-blue-50 text-blue-700 border-blue-200',
                                    'KK' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                    'Akta Lahir' => 'bg-purple-50 text-purple-700 border-purple-200',
                                    'Lainnya' => 'bg-slate-50 text-slate-700 border-slate-200'
                                ];
                                $badge = $badgeColors[$doc->kategori] ?? 'bg-slate-50 text-slate-700';
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold border {{ $badge }}">
                                {{ $doc->kategori }}
                            </span>
                            
                            <span class="text-[10px] text-slate-400 font-medium">
                                {{ $doc->created_at->diffForHumans() }}
                            </span>
                        </div>

                        <!-- Judul & Nama Warga -->
                        <h4 class="text-sm font-bold text-slate-800 mb-1 leading-snug line-clamp-1" title="{{ $doc->judul }}">{{ $doc->judul }}</h4>
                        <span class="text-xs text-slate-500 block mb-3 font-semibold">
                            <i class="fa-solid fa-user text-[10px] mr-1 text-slate-400"></i> {{ $doc->warga ? $doc->warga->nama_lengkap : 'Warga Dihapus' }}
                        </span>

                        <!-- Keterangan -->
                        <p class="text-xs text-slate-400 italic line-clamp-2 leading-relaxed mb-4">
                            {{ $doc->keterangan ?? 'Tidak ada keterangan.' }}
                        </p>
                    </div>

                    <!-- Footer / Tombol Aksi -->
                    <div class="flex items-center justify-between pt-3 border-t border-slate-50">
                        <a href="{{ asset('storage/' . $doc->jalur_file) }}" target="_blank"
                           class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-800 hover:text-emerald-600 transition">
                            <i class="fa-solid fa-up-right-from-square"></i> Lihat File
                        </a>

                        <form action="{{ route('dokumen.destroy', $doc->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus arsip dokumen ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 transition" title="Hapus">
                                <i class="fa-solid fa-trash-can text-sm"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 text-center text-slate-400 sm:col-span-2">
                    <i class="fa-solid fa-folder-open text-4xl mb-3"></i>
                    <p class="text-sm">Tidak ada berkas terarsip ditemukan.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div>
            {{ $dokumen->links() }}
        </div>

    </div>

</div>
@endsection
