@extends('layouts.admin')

@section('title', 'Surat Keterangan Otomatis')

@section('content')
<div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 mb-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <!-- Pencarian & Tipe Filter -->
        <form action="{{ route('surat.index') }}" method="GET" class="flex-1 flex flex-wrap gap-2">
            <div class="relative flex-1 min-w-[200px]">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" name="search" value="{{ request('search') }}"
                       class="w-full pl-11 pr-4 py-2.5 rounded-xl border border-slate-200 text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition"
                       placeholder="Cari Nomor Surat atau Nama Warga...">
            </div>
            
            <select name="jenis_surat" class="px-3 py-2 rounded-xl border border-slate-200 text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                <option value="">Semua Jenis Surat</option>
                @foreach(['Domisili', 'Kelahiran', 'Kematian', 'Usaha', 'Tidak Mampu', 'Pindah'] as $jenis)
                    <option value="{{ $jenis }}" {{ request('jenis_surat') == $jenis ? 'selected' : '' }}>{{ $jenis }}</option>
                @endforeach
            </select>
            
            <button type="submit" class="px-5 py-2.5 bg-emerald-700 hover:bg-emerald-600 text-white rounded-xl text-sm font-semibold transition shadow-lg shadow-emerald-700/10">
                Cari
            </button>
            <a href="{{ route('surat.index') }}" class="px-3 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-sm font-semibold transition text-center flex items-center justify-center">
                Reset
            </a>
        </form>

        <!-- Buat Surat Baru -->
        <a href="{{ route('surat.create') }}" class="px-5 py-2.5 bg-emerald-800 hover:bg-emerald-700 text-white rounded-xl text-sm font-semibold transition flex items-center justify-center gap-2 shadow-lg shadow-emerald-800/10">
            <i class="fa-solid fa-file-signature"></i> Buat Surat Baru
        </a>
    </div>
</div>

<!-- Table Surat -->
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100 text-slate-400 text-xs uppercase font-bold">
                    <th class="py-4 px-6">Nomor Surat</th>
                    <th class="py-4 px-6">Nama Warga (NIK)</th>
                    <th class="py-4 px-6">Jenis Surat</th>
                    <th class="py-4 px-6">Operator Pembuat</th>
                    <th class="py-4 px-6">Tanggal Cetak</th>
                    <th class="py-4 px-6 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                @forelse($surat as $s)
                    <tr class="hover:bg-slate-50/50 transition duration-150">
                        <td class="py-4 px-6 font-bold text-slate-800">
                            {{ $s->nomor_surat }}
                        </td>
                        <td class="py-4 px-6 font-semibold">
                            @if($s->warga)
                                <a href="{{ route('warga.show', $s->warga_id) }}" class="text-emerald-700 hover:underline block">
                                    {{ $s->warga->nama_lengkap }}
                                </a>
                                <span class="text-xs text-slate-400">{{ $s->warga->nik }}</span>
                            @else
                                <span class="text-slate-400 text-xs">Warga dihapus</span>
                            @endif
                        </td>
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                {{ $s->jenis_surat }}
                            </span>
                        </td>
                        <td class="py-4 px-6 text-slate-500 font-medium">
                            {{ $s->dibuat_oleh }}
                        </td>
                        <td class="py-4 px-6 text-slate-500">
                            {{ $s->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="py-4 px-6 text-right">
                            <div class="inline-flex rounded-lg shadow-sm">
                                <a href="{{ route('surat.show', $s->id) }}" class="px-3 py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 rounded-l-lg border border-slate-200 text-xs font-semibold transition">
                                    <i class="fa-solid fa-print"></i> Cetak / QR
                                </a>
                                <form action="{{ route('surat.destroy', $s->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data surat ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 rounded-r-lg border-y border-r border-slate-200 text-xs font-semibold transition">
                                        <i class="fa-solid fa-trash-can"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center text-slate-400">
                            <i class="fa-solid fa-envelope-open-text text-4xl mb-3"></i>
                            <p class="text-sm">Belum ada surat yang pernah dibuat.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="px-6 py-4 border-t border-slate-100">
        {{ $surat->links() }}
    </div>
</div>
@endsection
