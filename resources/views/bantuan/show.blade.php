@extends('layouts.admin')

@section('title', 'Detail & Penerima Bantuan')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <!-- Kolom Kiri: Informasi Bantuan & Tambah Penerima -->
    <div class="space-y-8 lg:col-span-1">
        <!-- Rincian Program -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <div class="flex items-center space-x-3 mb-6">
                <a href="{{ route('bantuan.index') }}" class="w-8 h-8 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg flex items-center justify-center transition">
                    <i class="fa-solid fa-arrow-left text-xs"></i>
                </a>
                <h3 class="text-md font-bold text-slate-800">Informasi Program</h3>
            </div>

            <div class="space-y-4">
                <div>
                    <span class="text-xs uppercase font-bold text-slate-400 block">Nama Program</span>
                    <span class="text-base font-bold text-slate-800">{{ $bantuan->nama_program }}</span>
                </div>

                <div>
                    <span class="text-xs uppercase font-bold text-slate-400 block">Nominal per Warga</span>
                    <span class="text-lg font-extrabold text-emerald-800">Rp {{ number_format($bantuan->nominal, 0, ',', '.') }}</span>
                </div>

                <div>
                    <span class="text-xs uppercase font-bold text-slate-400 block">Tanggal Penyaluran</span>
                    <span class="text-sm font-semibold text-slate-700">{{ $bantuan->tanggal_penyaluran ? \Carbon\Carbon::parse($bantuan->tanggal_penyaluran)->translatedFormat('d F Y') : '-' }}</span>
                </div>

                <div>
                    <span class="text-xs uppercase font-bold text-slate-400 block">Keterangan / Kriteria</span>
                    <p class="text-sm text-slate-600 leading-relaxed">{{ $bantuan->keterangan ?? 'Tidak ada keterangan.' }}</p>
                </div>
            </div>
        </div>

        <!-- Tambah Penerima -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <h3 class="text-md font-bold text-slate-800 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-user-plus text-emerald-600"></i> Tambah Penerima Bantuan
            </h3>

            @if($wargaList->isEmpty())
                <p class="text-sm text-slate-500 bg-slate-50 p-4 rounded-xl text-center">
                    Semua warga aktif sudah terdaftar sebagai penerima program ini.
                </p>
            @else
                <form action="{{ route('bantuan.addRecipient', $bantuan->id) }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="warga_id" class="block text-xs uppercase font-bold text-slate-500 mb-2">Pilih Warga</label>
                        <select name="warga_id" id="warga_id" required class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                            <option value="">-- Pilih Warga Penerima --</option>
                            @foreach($wargaList as $w)
                                <option value="{{ $w->id }}">{{ $w->nama_lengkap }} (NIK: {{ $w->nik }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="tanggal_terima" class="block text-xs uppercase font-bold text-slate-500 mb-2">Tanggal Terima</label>
                        <input type="date" name="tanggal_terima" id="tanggal_terima" value="{{ date('Y-m-d') }}" required
                               class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>

                    <button type="submit" class="w-full py-2.5 bg-emerald-800 hover:bg-emerald-700 text-white rounded-xl text-sm font-semibold transition shadow-lg shadow-emerald-800/10 flex items-center justify-center gap-2">
                        <i class="fa-solid fa-plus"></i> Tambah Penerima
                    </button>
                </form>
            @endif
        </div>
    </div>

    <!-- Kolom Kanan: Daftar Penerima Bantuan -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="text-md font-bold text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-users text-emerald-600"></i> Daftar Penerima ({{ $bantuan->warga->count() }} orang)
                </h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/70 border-b border-slate-100 text-slate-400 text-xs uppercase font-bold">
                            <th class="py-4 px-6">Nama Warga / NIK</th>
                            <th class="py-4 px-6">Jenis Kelamin</th>
                            <th class="py-4 px-6">Hubungan Keluarga</th>
                            <th class="py-4 px-6">Tanggal Terima</th>
                            <th class="py-4 px-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                        @forelse($bantuan->warga as $w)
                            <tr class="hover:bg-slate-50/30 transition duration-150">
                                <td class="py-4 px-6">
                                    <span class="font-bold text-slate-800 block">{{ $w->nama_lengkap }}</span>
                                    <span class="text-xs text-slate-400">{{ $w->nik }}</span>
                                </td>
                                <td class="py-4 px-6">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $w->jenis_kelamin == 'Laki-laki' ? 'bg-blue-50 text-blue-700' : 'bg-pink-50 text-pink-700' }}">
                                        {{ $w->jenis_kelamin }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-xs font-semibold text-slate-500">
                                    {{ $w->hubungan_keluarga }}
                                </td>
                                <td class="py-4 px-6 font-medium text-slate-600">
                                    {{ $w->pivot->tanggal_terima ? \Carbon\Carbon::parse($w->pivot->tanggal_terima)->translatedFormat('d F Y') : '-' }}
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <form action="{{ route('bantuan.removeRecipient', [$bantuan->id, $w->id]) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus warga ini dari daftar penerima?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg border border-red-200 text-xs font-semibold transition" title="Hapus dari daftar">
                                            <i class="fa-solid fa-user-minus"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center text-slate-400">
                                    <i class="fa-solid fa-users-slash text-4xl mb-3"></i>
                                    <p class="text-sm">Belum ada penerima terdaftar untuk bantuan ini.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
