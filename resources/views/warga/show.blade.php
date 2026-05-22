@extends('layouts.admin')

@section('title', 'Detail Warga')

@section('content')
<div class="max-w-5xl mx-auto space-y-8">
    
    <!-- Header Card -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex flex-col sm:flex-row items-center gap-6">
        <div class="flex-shrink-0">
            @if($warga->foto)
                <img src="{{ asset('storage/' . $warga->foto) }}" class="w-24 h-24 rounded-2xl object-cover ring-4 ring-slate-100 shadow-md" alt="Foto">
            @else
                <img src="https://ui-avatars.com/api/?name={{ urlencode($warga->nama_lengkap) }}&background=f1f5f9&color=64748b&size=128" class="w-24 h-24 rounded-2xl ring-4 ring-slate-100 shadow-md" alt="Avatar">
            @endif
        </div>
        <div class="flex-1 text-center sm:text-left space-y-1">
            <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2">
                <h3 class="text-xl font-bold text-slate-800">{{ $warga->nama_lengkap }}</h3>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">
                    {{ $warga->status_warga }}
                </span>
            </div>
            <p class="text-sm font-semibold text-slate-400">NIK: {{ $warga->nik }}</p>
            <p class="text-xs text-slate-500">
                <i class="fa-solid fa-people-roof mr-1"></i> {{ $warga->hubungan_keluarga }} dari Kepala Keluarga: 
                <strong>{{ $warga->kartuKeluarga ? $warga->kartuKeluarga->kepala_keluarga : '-' }}</strong>
            </p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('warga.edit', $warga->id) }}" class="px-4 py-2 bg-emerald-700 hover:bg-emerald-600 text-white rounded-xl text-xs font-semibold transition flex items-center gap-2">
                <i class="fa-solid fa-pen"></i> Edit
            </a>
            <a href="{{ route('warga.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-semibold transition">
                Kembali
            </a>
        </div>
    </div>

    <!-- Info Tabs / Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        
        <!-- Kolom Data Warga (2 cols) -->
        <div class="md:col-span-2 space-y-8">
            <!-- Biodata Detail -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                <h4 class="text-xs uppercase font-extrabold text-emerald-700 tracking-wider mb-6 pb-2 border-b border-slate-100 flex items-center">
                    <i class="fa-solid fa-id-card mr-2 text-sm"></i> Biodata Lengkap Kependudukan
                </h4>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4 text-sm">
                    <div>
                        <span class="text-xs text-slate-400 block uppercase font-bold tracking-wider">No. Kartu Keluarga</span>
                        @if($warga->kartuKeluarga)
                            <a href="{{ route('kartu-keluarga.show', $warga->kartu_keluarga_id) }}" class="text-emerald-700 hover:underline font-semibold mt-0.5 block">
                                {{ $warga->kartuKeluarga->nomor_kk }}
                            </a>
                        @else
                            <span class="text-slate-500 mt-0.5 block">-</span>
                        @endif
                    </div>

                    <div>
                        <span class="text-xs text-slate-400 block uppercase font-bold tracking-wider">Jenis Kelamin</span>
                        <span class="text-slate-800 font-semibold mt-0.5 block">{{ $warga->jenis_kelamin }}</span>
                    </div>

                    <div>
                        <span class="text-xs text-slate-400 block uppercase font-bold tracking-wider">Tempat, Tanggal Lahir (Umur)</span>
                        <span class="text-slate-800 font-semibold mt-0.5 block">
                            {{ $warga->tempat_lahir }}, {{ $warga->tanggal_lahir ? $warga->tanggal_lahir->translatedFormat('d F Y') : '-' }} 
                            <span class="text-slate-500 font-medium">({{ $warga->tanggal_lahir ? $warga->tanggal_lahir->age . ' Tahun' : '-' }})</span>
                        </span>
                    </div>

                    <div>
                        <span class="text-xs text-slate-400 block uppercase font-bold tracking-wider">Agama</span>
                        <span class="text-slate-800 font-semibold mt-0.5 block">{{ $warga->agama }}</span>
                    </div>

                    <div>
                        <span class="text-xs text-slate-400 block uppercase font-bold tracking-wider">Pendidikan Terakhir</span>
                        <span class="text-slate-800 font-semibold mt-0.5 block">{{ $warga->pendidikan }}</span>
                    </div>

                    <div>
                        <span class="text-xs text-slate-400 block uppercase font-bold tracking-wider">Pekerjaan Utama</span>
                        <span class="text-slate-800 font-semibold mt-0.5 block">{{ $warga->pekerjaan }}</span>
                    </div>

                    <div>
                        <span class="text-xs text-slate-400 block uppercase font-bold tracking-wider">Status Perkawinan</span>
                        <span class="text-slate-800 font-semibold mt-0.5 block">{{ $warga->status_perkawinan }}</span>
                    </div>

                    <div>
                        <span class="text-xs text-slate-400 block uppercase font-bold tracking-wider">Nomor HP/Telepon</span>
                        <span class="text-slate-800 font-semibold mt-0.5 block">{{ $warga->nomor_telepon ?? '-' }}</span>
                    </div>
                </div>

                <div class="border-t border-slate-100 pt-4 mt-6">
                    <span class="text-xs text-slate-400 block uppercase font-bold tracking-wider mb-1">Alamat Lengkap</span>
                    <span class="text-slate-700 font-medium text-sm leading-relaxed block">{{ $warga->alamat }}</span>
                </div>
            </div>

            <!-- Riwayat Surat -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                <h4 class="text-xs uppercase font-extrabold text-emerald-700 tracking-wider mb-4 pb-2 border-b border-slate-100 flex items-center">
                    <i class="fa-solid fa-file-invoice mr-2 text-sm"></i> Riwayat Surat Keterangan Warga
                </h4>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-700 border-collapse">
                        <thead>
                            <tr class="text-slate-400 font-semibold text-xs border-b border-slate-100">
                                <th class="py-3 pr-4">No. Surat</th>
                                <th class="py-3 px-4">Jenis Surat</th>
                                <th class="py-3 px-4">Tanggal Buat</th>
                                <th class="py-3 pl-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($warga->surat as $s)
                                <tr>
                                    <td class="py-3 pr-4 font-semibold text-slate-800">{{ $s->nomor_surat }}</td>
                                    <td class="py-3 px-4">{{ $s->jenis_surat }}</td>
                                    <td class="py-3 px-4 text-slate-500">{{ $s->created_at->format('d/m/Y') }}</td>
                                    <td class="py-3 pl-4 text-right">
                                        <a href="{{ route('surat.show', $s->id) }}" class="text-emerald-700 font-bold hover:underline">
                                            Lihat/Cetak
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-6 text-center text-slate-400 text-xs">
                                        Belum ada riwayat pembuatan surat untuk warga ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Kolom Berkas & Bantuan (1 col) -->
        <div class="space-y-8">
            <!-- Arsip Berkas -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                <h4 class="text-xs uppercase font-extrabold text-emerald-700 tracking-wider mb-4 pb-2 border-b border-slate-100 flex items-center">
                    <i class="fa-solid fa-folder-closed mr-2 text-sm"></i> Dokumen Kependudukan
                </h4>
                
                <ul class="space-y-3">
                    <!-- KTP -->
                    <li class="flex items-center justify-between p-3 bg-slate-50 rounded-xl">
                        <div class="flex items-center">
                            <i class="fa-solid fa-file-pdf text-rose-500 text-lg mr-3"></i>
                            <div>
                                <span class="text-xs font-bold text-slate-700 block">Fotokopi KTP</span>
                                <span class="text-[10px] text-slate-400">Scan KTP Warga</span>
                            </div>
                        </div>
                        @if($warga->berkas_ktp)
                            <a href="{{ asset('storage/' . $warga->berkas_ktp) }}" target="_blank" class="px-2 py-1 bg-emerald-50 text-emerald-700 rounded-lg text-xs font-bold hover:bg-emerald-100">
                                Lihat
                            </a>
                        @else
                            <span class="text-[10px] text-slate-400">Belum ada</span>
                        @endif
                    </li>

                    <!-- KK -->
                    <li class="flex items-center justify-between p-3 bg-slate-50 rounded-xl">
                        <div class="flex items-center">
                            <i class="fa-solid fa-file-pdf text-emerald-600 text-lg mr-3"></i>
                            <div>
                                <span class="text-xs font-bold text-slate-700 block">Fotokopi KK</span>
                                <span class="text-[10px] text-slate-400">Scan Kartu Keluarga</span>
                            </div>
                        </div>
                        @if($warga->berkas_kk)
                            <a href="{{ asset('storage/' . $warga->berkas_kk) }}" target="_blank" class="px-2 py-1 bg-emerald-50 text-emerald-700 rounded-lg text-xs font-bold hover:bg-emerald-100">
                                Lihat
                            </a>
                        @else
                            <span class="text-[10px] text-slate-400">Belum ada</span>
                        @endif
                    </li>
                </ul>
            </div>

            <!-- Riwayat Bantuan Sosial -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                <h4 class="text-xs uppercase font-extrabold text-emerald-700 tracking-wider mb-4 pb-2 border-b border-slate-100 flex items-center">
                    <i class="fa-solid fa-hand-holding-heart mr-2 text-sm"></i> Penerima Bantuan Sosial
                </h4>
                
                <div class="space-y-3">
                    @forelse($warga->bantuanSosial as $b)
                        <div class="p-3 bg-purple-50/50 rounded-xl border border-purple-100">
                            <span class="text-xs font-bold text-purple-950 block">{{ $b->nama_program }}</span>
                            <div class="flex justify-between items-center mt-2 text-[10px] text-slate-400">
                                <span>Nominal: <strong>Rp {{ number_format($b->nominal) }}</strong></span>
                                <span>Diterima: {{ $b->pivot->tanggal_terima ? \Carbon\Carbon::parse($b->pivot->tanggal_terima)->format('d/m/Y') : '-' }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-6 text-slate-400 text-xs">
                            Warga ini belum terdaftar sebagai penerima program bantuan sosial apa pun.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
