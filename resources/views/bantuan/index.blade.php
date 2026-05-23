@extends('layouts.admin')

@section('title', 'Bantuan Sosial')

@section('content')
<div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 mb-8">
    <!-- Header panel -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <!-- Pencarian -->
        <form action="{{ route('bantuan.index') }}" method="GET" class="flex-1 flex gap-2 max-w-lg">
            <div class="relative flex-1">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" name="search" value="{{ request('search') }}"
                       class="w-full pl-11 pr-4 py-2.5 rounded-xl border border-slate-200 text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition"
                       placeholder="Cari nama program bantuan...">
            </div>
            <button type="submit" class="px-5 py-2.5 bg-emerald-700 hover:bg-emerald-600 text-white rounded-xl text-sm font-semibold transition shadow-lg shadow-emerald-700/10">
                Cari
            </button>
        </form>

        <!-- Tambah Bantuan -->
        <a href="{{ route('bantuan.create') }}" class="px-5 py-2.5 bg-green-700 hover:bg-green-600 text-white rounded-xl text-sm font-semibold transition flex items-center justify-center gap-2 shadow-lg shadow-green-700/10">
            <i class="fa-solid fa-plus"></i> Tambah Program Bantuan
        </a>
    </div>
</div>

<!-- Table Container -->
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100 text-slate-400 text-xs uppercase font-bold">
                    <th class="py-4 px-6">Nama Program</th>
                    <th class="py-4 px-6">Keterangan</th>
                    <th class="py-4 px-6">Nominal / Penerima</th>
                    <th class="py-4 px-6">Tanggal Penyaluran</th>
                    <th class="py-4 px-6">Jumlah Penerima</th>
                    <th class="py-4 px-6 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                @forelse($bantuan as $b)
                    <tr class="hover:bg-slate-50/50 transition duration-150">
                        <td class="py-4 px-6">
                            <span class="font-bold text-slate-800 block">{{ $b->nama_program }}</span>
                        </td>
                        <td class="py-4 px-6 max-w-xs truncate">
                            {{ $b->keterangan ?? '-' }}
                        </td>
                        <td class="py-4 px-6 font-bold text-emerald-800">
                            Rp {{ number_format($b->nominal, 0, ',', '.') }}
                        </td>
                        <td class="py-4 px-6">
                            {{ $b->tanggal_penyaluran ? \Carbon\Carbon::parse($b->tanggal_penyaluran)->translatedFormat('d F Y') : '-' }}
                        </td>
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                <i class="fa-solid fa-users mr-1.5 text-xs"></i> {{ $b->warga_count }} Warga
                            </span>
                        </td>
                        <td class="py-4 px-6 text-right space-x-1">
                            <div class="inline-flex rounded-lg shadow-sm">
                                <a href="{{ route('bantuan.show', $b->id) }}" class="px-3 py-1.5 bg-slate-50 hover:bg-slate-100 text-slate-600 rounded-l-lg border border-slate-200 text-xs font-semibold transition" title="Penerima & Kelola">
                                    <i class="fa-solid fa-user-gear"></i> Penerima
                                </a>
                                <a href="{{ route('bantuan.edit', $b->id) }}" class="px-3 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 border-y border-r border-slate-200 text-xs font-semibold transition" title="Edit">
                                    <i class="fa-solid fa-pen"></i> Edit
                                </a>
                                <form action="{{ route('bantuan.destroy', $b->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus program bantuan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 rounded-r-lg border-y border-r border-slate-200 text-xs font-semibold transition" title="Hapus">
                                        <i class="fa-solid fa-trash-can"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center text-slate-400">
                            <i class="fa-solid fa-hand-holding-dollar text-4xl mb-3"></i>
                            <p class="text-sm">Tidak ada program bantuan sosial ditemukan.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="px-6 py-4 border-t border-slate-100">
        {{ $bantuan->links() }}
    </div>
</div>
@endsection
