@extends('layouts.admin')

@section('title', 'Data Kartu Keluarga')

@section('content')
<div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 mb-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <!-- Pencarian & RT Filter -->
        <form action="{{ route('kartu-keluarga.index') }}" method="GET" class="flex-1 flex flex-wrap gap-2">
            <div class="relative flex-1 min-w-[200px]">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" name="search" value="{{ request('search') }}"
                       class="w-full pl-11 pr-4 py-2.5 rounded-xl border border-slate-200 text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition"
                       placeholder="Cari No. KK atau Kepala Keluarga...">
            </div>
            
            <select name="rt" class="px-3 py-2 rounded-xl border border-slate-200 text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                <option value="">Semua RT</option>
                @foreach(['001', '002', '003', '004', '005'] as $rt)
                    <option value="{{ $rt }}" {{ request('rt') == $rt ? 'selected' : '' }}>RT {{ $rt }}</option>
                @endforeach
            </select>
            
            <button type="submit" class="px-5 py-2.5 bg-emerald-700 hover:bg-emerald-600 text-white rounded-xl text-sm font-semibold transition shadow-lg shadow-emerald-700/10">
                Cari
            </button>
            <a href="{{ route('kartu-keluarga.index') }}" class="px-3 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-sm font-semibold transition text-center flex items-center justify-center">
                Reset
            </a>
        </form>

        <!-- Tambah KK -->
        <a href="{{ route('kartu-keluarga.create') }}" class="px-5 py-2.5 bg-green-700 hover:bg-green-600 text-white rounded-xl text-sm font-semibold transition flex items-center justify-center gap-2 shadow-lg shadow-green-700/10">
            <i class="fa-solid fa-folder-plus"></i> Tambah KK
        </a>
    </div>
</div>

<!-- Table KK -->
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100 text-slate-400 text-xs uppercase font-bold">
                    <th class="py-4 px-6">Nomor Kartu Keluarga</th>
                    <th class="py-4 px-6">Kepala Keluarga</th>
                    <th class="py-4 px-6">RT / RW</th>
                    <th class="py-4 px-6">Alamat KK</th>
                    <th class="py-4 px-6 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                @forelse($kartuKeluarga as $kk)
                    <tr class="hover:bg-slate-50/50 transition duration-150">
                        <td class="py-4 px-6 font-bold text-slate-800">
                            {{ $kk->nomor_kk }}
                        </td>
                        <td class="py-4 px-6 font-semibold">
                            {{ $kk->kepala_keluarga }}
                        </td>
                        <td class="py-4 px-6 font-medium text-slate-500">
                            RT {{ $kk->rt }} / RW {{ $kk->rw }}
                        </td>
                        <td class="py-4 px-6 text-slate-500 max-w-xs truncate">
                            {{ $kk->alamat }}
                        </td>
                        <td class="py-4 px-6 text-right">
                            <div class="inline-flex rounded-lg shadow-sm">
                                <a href="{{ route('kartu-keluarga.show', $kk->id) }}" class="px-3 py-1.5 bg-slate-50 hover:bg-slate-100 text-slate-600 rounded-l-lg border border-slate-200 text-xs font-semibold transition">
                                    <i class="fa-solid fa-eye"></i> Detail / Anggota
                                </a>
                                <a href="{{ route('kartu-keluarga.edit', $kk->id) }}" class="px-3 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 border-y border-r border-slate-200 text-xs font-semibold transition">
                                    <i class="fa-solid fa-pen"></i> Edit
                                </a>
                                <form action="{{ route('kartu-keluarga.destroy', $kk->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data KK ini?')">
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
                        <td colspan="5" class="py-12 text-center text-slate-400">
                            <i class="fa-solid fa-address-book text-4xl mb-3"></i>
                            <p class="text-sm">Tidak ada data Kartu Keluarga ditemukan.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="px-6 py-4 border-t border-slate-100">
        {{ $kartuKeluarga->links() }}
    </div>
</div>
@endsection
