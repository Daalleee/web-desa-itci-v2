@extends('layouts.admin')

@section('title', 'Cetak Surat Keterangan')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Tombol Cetak (no-print) -->
    <div class="mb-6 flex justify-between items-center no-print bg-white p-4 rounded-xl shadow-sm border border-slate-100">
        <div class="text-xs text-slate-500">
            <i class="fa-solid fa-circle-info text-emerald-600 mr-1.5"></i> Gunakan ukuran kertas <strong>A4</strong> saat mencetak dokumen ini.
        </div>
        <div class="flex gap-2">
            <button onclick="window.print()" class="px-5 py-2.5 bg-emerald-800 hover:bg-emerald-700 text-white rounded-xl text-sm font-semibold transition flex items-center gap-2 shadow-lg shadow-emerald-800/10">
                <i class="fa-solid fa-print"></i> Cetak Surat
            </button>
            <a href="{{ route('surat.index') }}" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-sm font-semibold transition">
                Kembali
            </a>
        </div>
    </div>

    <!-- Tampilan Kertas Surat A4 -->
    <div class="bg-white p-12 md:p-16 shadow-lg rounded-2xl border border-slate-200 min-h-[1100px] text-black font-serif text-sm relative leading-relaxed">
        
        <!-- KOP SURAT -->
        <div class="flex items-center justify-between border-b-4 border-black pb-4 mb-6">
            <!-- Lambang Garuda/Pemerintah Mockup (SVG Premium) -->
            <div class="w-20 h-20 flex-shrink-0 flex items-center justify-center">
                <svg class="w-16 h-16 text-slate-800" viewBox="0 0 100 100" fill="currentColor">
                    <circle cx="50" cy="50" r="45" fill="none" stroke="currentColor" stroke-width="2"/>
                    <circle cx="50" cy="50" r="40" fill="none" stroke="currentColor" stroke-width="1"/>
                    <path d="M50 15 L60 40 L85 45 L65 60 L70 85 L50 70 L30 85 L35 60 L15 45 L40 40 Z"/>
                </svg>
            </div>
            
            <div class="flex-1 text-center font-bold font-sans">
                <h3 class="text-lg uppercase leading-tight tracking-wider">Pemerintah Kabupaten Penajam Paser Utara</h3>
                <h4 class="text-base uppercase leading-tight tracking-wider">Kecamatan Sepaku</h4>
                <h2 class="text-xl uppercase leading-normal tracking-widest font-black">Kantor Kepala Desa ITCI</h2>
                <p class="text-xs font-normal italic font-serif text-slate-500 mt-1">Alamat: Jl. Poros ITCI Kel. Sepaku, Penajam Paser Utara, Kaltim, Kode Pos 76118</p>
            </div>
            
            <!-- Spacer to center copy -->
            <div class="w-20"></div>
        </div>

        <!-- ISI SURAT -->
        <div class="space-y-6">
            <!-- Judul Surat -->
            <div class="text-center font-sans">
                <h3 class="text-base uppercase font-bold tracking-wider underline">SURAT KETERANGAN {{ strtoupper($surat->jenis_surat) }}</h3>
                <span class="text-xs">Nomor: {{ $surat->nomor_surat }}</span>
            </div>

            <!-- Paragraf Pembuka -->
            <p class="indent-12">
                Yang bertanda tangan di bawah ini Kepala Desa ITCI, Kecamatan Sepaku, Kabupaten Penajam Paser Utara, menerangkan dengan sebenarnya bahwa warga yang bersangkutan di bawah ini:
            </p>

            <!-- Biodata Warga -->
            <table class="w-[90%] mx-auto text-sm my-4 border-collapse space-y-2">
                <tr>
                    <td class="w-[30%] py-1 align-top">Nama Lengkap</td>
                    <td class="w-[5%] py-1 align-top">:</td>
                    <td class="w-[65%] py-1 font-bold text-base uppercase align-top">{{ $surat->warga ? $surat->warga->nama_lengkap : '-' }}</td>
                </tr>
                <tr>
                    <td class="py-1 align-top">NIK (Nomor Induk Kependudukan)</td>
                    <td class="py-1 align-top">:</td>
                    <td class="py-1 align-top">{{ $surat->warga ? $surat->warga->nik : '-' }}</td>
                </tr>
                <tr>
                    <td class="py-1 align-top">Tempat, Tanggal Lahir</td>
                    <td class="py-1 align-top">:</td>
                    <td class="py-1 align-top">{{ $surat->warga ? $surat->warga->tempat_lahir : '-' }}, {{ $surat->warga && $surat->warga->tanggal_lahir ? $surat->warga->tanggal_lahir->translatedFormat('d F Y') : '-' }}</td>
                </tr>
                <tr>
                    <td class="py-1 align-top">Jenis Kelamin</td>
                    <td class="py-1 align-top">:</td>
                    <td class="py-1 align-top">{{ $surat->warga ? $surat->warga->jenis_kelamin : '-' }}</td>
                </tr>
                <tr>
                    <td class="py-1 align-top">Pekerjaan Utama</td>
                    <td class="py-1 align-top">:</td>
                    <td class="py-1 align-top">{{ $surat->warga ? $surat->warga->pekerjaan : '-' }}</td>
                </tr>
                <tr>
                    <td class="py-1 align-top">Alamat Asal KTP</td>
                    <td class="py-1 align-top">:</td>
                    <td class="py-1 align-top leading-relaxed">{{ $surat->warga ? $surat->warga->alamat : '-' }}</td>
                </tr>

                <!-- Field tambahan dinamis berdasarkan jenis surat -->
                @if($surat->jenis_surat === 'Usaha' && isset($surat->informasi_tambahan['nama_usaha']))
                    <tr>
                        <td class="py-1 font-bold text-emerald-850 align-top">Nama Usaha</td>
                        <td class="py-1 align-top">:</td>
                        <td class="py-1 font-bold align-top">{{ $surat->informasi_tambahan['nama_usaha'] }}</td>
                    </tr>
                    <tr>
                        <td class="py-1 font-bold text-emerald-850 align-top">Alamat Usaha</td>
                        <td class="py-1 align-top">:</td>
                        <td class="py-1 align-top">{{ $surat->informasi_tambahan['alamat_usaha'] }}</td>
                    </tr>
                @endif

                @if($surat->jenis_surat === 'Pindah' && isset($surat->informasi_tambahan['pindah_ke']))
                    <tr>
                        <td class="py-1 font-bold text-blue-900 align-top">Tujuan Pindah</td>
                        <td class="py-1 align-top">:</td>
                        <td class="py-1 font-bold align-top leading-relaxed">{{ $surat->informasi_tambahan['pindah_ke'] }}</td>
                    </tr>
                @endif

                @if($surat->jenis_surat === 'Kematian' && isset($surat->informasi_tambahan['tanggal_kematian']))
                    <tr>
                        <td class="py-1 font-bold text-rose-900 align-top">Tanggal Wafat</td>
                        <td class="py-1 align-top">:</td>
                        <td class="py-1 font-bold align-top">{{ \Carbon\Carbon::parse($surat->informasi_tambahan['tanggal_kematian'])->translatedFormat('d F Y') }}</td>
                    </tr>
                @endif

                @if($surat->jenis_surat === 'Kelahiran' && isset($surat->informasi_tambahan['tanggal_kelahiran']))
                    <tr>
                        <td class="py-1 font-bold text-cyan-900 align-top">Tanggal Lahir Anak</td>
                        <td class="py-1 align-top">:</td>
                        <td class="py-1 font-bold align-top">{{ \Carbon\Carbon::parse($surat->informasi_tambahan['tanggal_kelahiran'])->translatedFormat('d F Y') }}</td>
                    </tr>
                @endif
            </table>

            <!-- Keperluan -->
            <p class="indent-12 leading-relaxed">
                Warga yang bersangkutan di atas benar merupakan warga Desa ITCI. Surat keterangan ini diberikan secara resmi untuk dipergunakan sebagai: <strong>"{{ $surat->keperluan }}"</strong>.
            </p>

            <!-- Paragraf Penutup -->
            <p class="indent-12 leading-relaxed">
                Demikian surat keterangan ini kami buat dengan penuh tanggung jawab untuk dipergunakan sebagaimana mestinya oleh pihak yang berkepentingan.
            </p>
        </div>

        <!-- TANDA TANGAN & QR CODE -->
        <div class="mt-16 flex justify-between items-end">
            <!-- QR Code Autentikasi (Cetak) -->
            <div class="text-center space-y-2 border border-slate-200 p-3 rounded-xl bg-slate-50">
                <p class="text-[9px] uppercase font-bold font-sans text-slate-500 tracking-wider">Validasi Digital</p>
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=90x90&data={{ urlencode($verificationUrl) }}" class="mx-auto w-24 h-24 bg-white p-1" alt="QR Validasi">
                <p class="text-[9px] font-sans text-slate-500 tracking-wide mt-1">Scan QR untuk verifikasi berkas</p>
            </div>

            <!-- Tanda Tangan Pejabat -->
            <div class="text-center w-64 space-y-20">
                <div>
                    <p>Desa ITCI, {{ $surat->created_at->translatedFormat('d F Y') }}</p>
                    <p class="font-bold font-sans mt-1 uppercase">{{ $surat->ditandatangani_oleh }}</p>
                </div>
                <div>
                    <span class="border-b-2 border-black pb-1 font-bold uppercase tracking-wider block font-sans">M. YUSUF WIJAYA</span>
                    <span class="text-xs text-slate-500 mt-1 block">NIP. 19820512 201012 1 002</span>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
