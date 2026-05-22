@extends('layouts.admin')

@section('title', 'Tambah Warga Baru')

@section('content')
<div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-slate-100 max-w-4xl mx-auto">
    <div class="flex items-center gap-3 mb-6 pb-6 border-b border-slate-100">
        <a href="{{ route('warga.index') }}" class="text-slate-400 hover:text-slate-600 transition">
            <i class="fa-solid fa-arrow-left text-lg"></i>
        </a>
        <h3 class="text-lg font-bold text-slate-800">Formulir Tambah Data Warga</h3>
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

    <form action="{{ route('warga.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        
        <!-- Section 1: Data Pribadi -->
        <div>
            <h4 class="text-xs uppercase font-extrabold text-emerald-700 tracking-wider mb-4 border-b border-slate-100 pb-2">
                <i class="fa-solid fa-user mr-1.5"></i> Identitas Pribadi
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- NIK -->
                <div>
                    <label class="block text-xs uppercase font-bold text-slate-500 mb-2">NIK (Nomor Induk Kependudukan) <span class="text-red-500">*</span></label>
                    <input type="text" name="nik" value="{{ old('nik') }}" required maxlength="16" minlength="16"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition"
                           placeholder="Masukkan 16 digit NIK">
                </div>

                <!-- Nama Lengkap -->
                <div>
                    <label class="block text-xs uppercase font-bold text-slate-500 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition"
                           placeholder="Masukkan nama lengkap sesuai KTP">
                </div>

                <!-- Tempat Lahir -->
                <div>
                    <label class="block text-xs uppercase font-bold text-slate-500 mb-2">Tempat Lahir <span class="text-red-500">*</span></label>
                    <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition"
                           placeholder="Masukkan tempat lahir">
                </div>

                <!-- Tanggal Lahir -->
                <div>
                    <label class="block text-xs uppercase font-bold text-slate-500 mb-2">Tanggal Lahir <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition">
                </div>

                <!-- Jenis Kelamin -->
                <div>
                    <label class="block text-xs uppercase font-bold text-slate-500 mb-2">Jenis Kelamin <span class="text-red-500">*</span></label>
                    <div class="flex gap-4 mt-2">
                        <label class="inline-flex items-center">
                            <input type="radio" name="jenis_kelamin" value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'checked' : '' }} required class="w-4 h-4 text-emerald-600 border-slate-300 focus:ring-emerald-500">
                            <span class="ml-2 text-sm text-slate-700">Laki-laki</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="jenis_kelamin" value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'checked' : '' }} required class="w-4 h-4 text-emerald-600 border-slate-300 focus:ring-emerald-500">
                            <span class="ml-2 text-sm text-slate-700">Perempuan</span>
                        </label>
                    </div>
                </div>

                <!-- Agama -->
                <div>
                    <label class="block text-xs uppercase font-bold text-slate-500 mb-2">Agama <span class="text-red-500">*</span></label>
                    <select name="agama" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        <option value="">Pilih Agama</option>
                        @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'] as $agama)
                            <option value="{{ $agama }}" {{ old('agama') == $agama ? 'selected' : '' }}>{{ $agama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Section 2: Data Keluarga & Hubungan -->
        <div>
            <h4 class="text-xs uppercase font-extrabold text-emerald-700 tracking-wider mb-4 border-b border-slate-100 pb-2">
                <i class="fa-solid fa-people-roof mr-1.5"></i> Hubungan Keluarga & Sosial
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Kartu Keluarga -->
                <div>
                    <label class="block text-xs uppercase font-bold text-slate-500 mb-2">Kartu Keluarga (KK) <span class="text-red-500">*</span></label>
                    <select name="kartu_keluarga_id" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        <option value="">Pilih Kartu Keluarga</option>
                        @foreach($kartuKeluarga as $kk)
                            <option value="{{ $kk->id }}" {{ old('kartu_keluarga_id') == $kk->id ? 'selected' : '' }}>
                                {{ $kk->nomor_kk }} (Kepala: {{ $kk->kepala_keluarga }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Hubungan Keluarga -->
                <div>
                    <label class="block text-xs uppercase font-bold text-slate-500 mb-2">Hubungan Keluarga <span class="text-red-500">*</span></label>
                    <select name="hubungan_keluarga" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        <option value="">Pilih Hubungan</option>
                        @foreach(['Kepala Keluarga', 'Istri', 'Anak', 'Orang Tua', 'Mertua', 'Menantu', 'Cucu', 'Famili Lain'] as $hub)
                            <option value="{{ $hub }}" {{ old('hubungan_keluarga') == $hub ? 'selected' : '' }}>{{ $hub }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Pendidikan -->
                <div>
                    <label class="block text-xs uppercase font-bold text-slate-500 mb-2">Pendidikan Terakhir <span class="text-red-500">*</span></label>
                    <select name="pendidikan" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        <option value="">Pilih Pendidikan</option>
                        @foreach(['Tidak/Belum Sekolah', 'Belum Tamat SD', 'Tamat SD', 'SLTP/SMP', 'SLTA/SMA', 'Diploma I/II', 'Diploma III', 'Diploma IV/S1', 'S2', 'S3'] as $pend)
                            <option value="{{ $pend }}" {{ old('pendidikan') == $pend ? 'selected' : '' }}>{{ $pend }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Pekerjaan -->
                <div>
                    <label class="block text-xs uppercase font-bold text-slate-500 mb-2">Pekerjaan <span class="text-red-500">*</span></label>
                    <select name="pekerjaan" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        <option value="">Pilih Pekerjaan</option>
                        @foreach(['Belum/Tidak Bekerja', 'Mengurus Rumah Tangga', 'Pelajar/Mahasiswa', 'PNS', 'TNI', 'POLRI', 'Karyawan Swasta', 'Buruh Harian Lepas', 'Petani / Pekebun', 'Wiraswasta', 'Lainnya'] as $pek)
                            <option value="{{ $pek }}" {{ old('pekerjaan') == $pek ? 'selected' : '' }}>{{ $pek }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Perkawinan -->
                <div>
                    <label class="block text-xs uppercase font-bold text-slate-500 mb-2">Status Perkawinan <span class="text-red-500">*</span></label>
                    <select name="status_perkawinan" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        <option value="">Pilih Status</option>
                        @foreach(['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'] as $stat)
                            <option value="{{ $stat }}" {{ old('status_perkawinan') == $stat ? 'selected' : '' }}>{{ $stat }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Warga -->
                <div>
                    <label class="block text-xs uppercase font-bold text-slate-500 mb-2">Status Warga <span class="text-red-500">*</span></label>
                    <select name="status_warga" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        <option value="Aktif" {{ old('status_warga') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Pendatang" {{ old('status_warga') == 'Pendatang' ? 'selected' : '' }}>Pendatang</option>
                        <option value="Pindah" {{ old('status_warga') == 'Pindah' ? 'selected' : '' }}>Pindah</option>
                        <option value="Meninggal" {{ old('status_warga') == 'Meninggal' ? 'selected' : '' }}>Meninggal</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Section 3: Kontak & Alamat -->
        <div>
            <h4 class="text-xs uppercase font-extrabold text-emerald-700 tracking-wider mb-4 border-b border-slate-100 pb-2">
                <i class="fa-solid fa-address-book mr-1.5"></i> Kontak & Domisili
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nomor Telepon -->
                <div>
                    <label class="block text-xs uppercase font-bold text-slate-500 mb-2">Nomor Telepon / HP</label>
                    <input type="text" name="nomor_telepon" value="{{ old('nomor_telepon') }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition"
                           placeholder="Contoh: 081234567890">
                </div>

                <!-- Alamat Domisili -->
                <div>
                    <label class="block text-xs uppercase font-bold text-slate-500 mb-2">Alamat Domisili Lengkap <span class="text-red-500">*</span></label>
                    <textarea name="alamat" required rows="3"
                              class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition"
                              placeholder="Masukkan alamat lengkap warga saat ini">{{ old('alamat') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Section 4: Upload Berkas/Berkas -->
        <div>
            <h4 class="text-xs uppercase font-extrabold text-emerald-700 tracking-wider mb-4 border-b border-slate-100 pb-2">
                <i class="fa-solid fa-file-arrow-up mr-1.5"></i> Unggah Dokumen Pendukung (Maks 2MB)
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Foto Warga -->
                <div class="border border-dashed border-slate-200 p-4 rounded-xl text-center">
                    <label class="block text-xs uppercase font-bold text-slate-500 mb-2">Foto Profil Warga</label>
                    <input type="file" name="foto" accept="image/*" class="text-xs text-slate-500 file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:bg-slate-100 hover:file:bg-slate-200">
                    <p class="text-[10px] text-slate-400 mt-2">Format: JPG, JPEG, PNG</p>
                </div>

                <!-- Berkas KTP -->
                <div class="border border-dashed border-slate-200 p-4 rounded-xl text-center">
                    <label class="block text-xs uppercase font-bold text-slate-500 mb-2">Berkas KTP (PDF/Gambar)</label>
                    <input type="file" name="berkas_ktp" accept="application/pdf,image/*" class="text-xs text-slate-500 file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:bg-slate-100 hover:file:bg-slate-200">
                    <p class="text-[10px] text-slate-400 mt-2">Arsip otomatis di Dokumen</p>
                </div>

                <!-- Berkas KK -->
                <div class="border border-dashed border-slate-200 p-4 rounded-xl text-center">
                    <label class="block text-xs uppercase font-bold text-slate-500 mb-2">Berkas KK (PDF/Gambar)</label>
                    <input type="file" name="berkas_kk" accept="application/pdf,image/*" class="text-xs text-slate-500 file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:bg-slate-100 hover:file:bg-slate-200">
                    <p class="text-[10px] text-slate-400 mt-2">Arsip otomatis di Dokumen</p>
                </div>
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="flex justify-end gap-3 pt-6 border-t border-slate-100">
            <a href="{{ route('warga.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-sm font-semibold transition">
                Batal
            </a>
            <button type="submit" class="px-6 py-2.5 bg-emerald-800 hover:bg-emerald-700 text-white rounded-xl text-sm font-semibold transition shadow-lg shadow-emerald-800/20">
                Simpan Warga
            </button>
        </div>
    </form>
</div>
@endsection
