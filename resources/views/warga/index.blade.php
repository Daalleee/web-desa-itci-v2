@extends('layouts.admin')

@section('title', 'Data Warga')

@section('content')
<div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 mb-8" x-data="{ filterOpen: false }">
    <!-- Header panel -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <!-- Pencarian & Tombol Filter -->
        <form action="{{ route('warga.index') }}" method="GET" class="flex-1 flex gap-2">
            <div class="relative flex-1">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" name="search" value="{{ request('search') }}"
                       class="w-full pl-11 pr-4 py-2.5 rounded-xl border border-slate-200 text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition"
                       placeholder="Cari NIK atau Nama Lengkap...">
            </div>
            
            <button type="button" @click="filterOpen = !filterOpen"
                    class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-sm font-semibold transition flex items-center gap-2">
                <i class="fa-solid fa-sliders"></i> Filter
            </button>
            
            <button type="submit" class="px-5 py-2.5 bg-emerald-700 hover:bg-emerald-600 text-white rounded-xl text-sm font-semibold transition shadow-lg shadow-emerald-700/10">
                Cari
            </button>
        </form>

        <!-- Tambah Warga -->
        <a href="{{ route('warga.create') }}" class="px-5 py-2.5 bg-emerald-800 hover:bg-emerald-700 text-white rounded-xl text-sm font-semibold transition flex items-center justify-center gap-2 shadow-lg shadow-emerald-800/10">
            <i class="fa-solid fa-user-plus"></i> Tambah Warga
        </a>
    </div>

    <!-- Filter panel (Collapsible) -->
    <div x-show="filterOpen" x-transition class="border-t border-slate-100 pt-6 mt-6">
        <form action="{{ route('warga.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            <!-- Simpan query pencarian jika ada -->
            @if(request('search'))
                <input type="hidden" name="search" value="{{ request('search') }}">
            @endif

            <!-- Filter RT -->
            <div>
                <label class="block text-xs uppercase font-bold text-slate-500 mb-2">RT</label>
                <select name="rt" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <option value="">Semua RT</option>
                    @foreach(['001', '002', '003', '004', '005'] as $rt)
                        <option value="{{ $rt }}" {{ request('rt') == $rt ? 'selected' : '' }}>RT {{ $rt }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Status -->
            <div>
                <label class="block text-xs uppercase font-bold text-slate-500 mb-2">Status Warga</label>
                <select name="status_warga" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <option value="">Semua Status</option>
                    <option value="Aktif" {{ request('status_warga') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="Pendatang" {{ request('status_warga') == 'Pendatang' ? 'selected' : '' }}>Pendatang</option>
                    <option value="Pindah" {{ request('status_warga') == 'Pindah' ? 'selected' : '' }}>Pindah</option>
                    <option value="Meninggal" {{ request('status_warga') == 'Meninggal' ? 'selected' : '' }}>Meninggal</option>
                </select>
            </div>

            <!-- Filter Agama -->
            <div>
                <label class="block text-xs uppercase font-bold text-slate-500 mb-2">Agama</label>
                <select name="agama" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <option value="">Semua Agama</option>
                    @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'] as $agama)
                        <option value="{{ $agama }}" {{ request('agama') == $agama ? 'selected' : '' }}>{{ $agama }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Tombol Filter Apply -->
            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 py-2 bg-emerald-800 hover:bg-emerald-700 text-white rounded-xl text-sm font-semibold transition">
                    Terapkan
                </button>
                <a href="{{ route('warga.index') }}" class="py-2 px-4 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-sm font-semibold transition text-center">
                    Reset
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Table Container -->
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100 text-slate-400 text-xs uppercase font-bold">
                    <th class="py-4 px-6">Foto</th>
                    <th class="py-4 px-6">NIK / Nama Lengkap</th>
                    <th class="py-4 px-6">No. KK</th>
                    <th class="py-4 px-6">Jenis Kelamin</th>
                    <th class="py-4 px-6">RT/RW</th>
                    <th class="py-4 px-6">Status Warga</th>
                    <th class="py-4 px-6 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                @forelse($warga as $w)
                    <tr class="hover:bg-slate-50/50 transition duration-150">
                        <td class="py-4 px-6">
                            @if($w->foto)
                                <img src="{{ asset('storage/' . $w->foto) }}" class="w-10 h-10 rounded-full object-cover ring-2 ring-slate-100 shadow" alt="Foto">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($w->nama_lengkap) }}&background=f1f5f9&color=64748b" class="w-10 h-10 rounded-full" alt="Avatar">
                            @endif
                        </td>
                        <td class="py-4 px-6">
                            <span class="font-bold text-slate-800 block">{{ $w->nama_lengkap }}</span>
                            <span class="text-xs text-slate-400">{{ $w->nik }}</span>
                        </td>
                        <td class="py-4 px-6">
                            @if($w->kartuKeluarga)
                                <a href="{{ route('kartu-keluarga.show', $w->kartu_keluarga_id) }}" class="text-emerald-700 font-semibold hover:underline block">
                                    {{ $w->kartuKeluarga->nomor_kk }}
                                </a>
                                <span class="text-xs text-slate-400">{{ $w->hubungan_keluarga }}</span>
                            @else
                                <span class="text-slate-400 text-xs">Tidak ada KK</span>
                            @endif
                        </td>
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $w->jenis_kelamin == 'Laki-laki' ? 'bg-blue-50 text-blue-700' : 'bg-pink-50 text-pink-700' }}">
                                {{ $w->jenis_kelamin }}
                            </span>
                        </td>
                        <td class="py-4 px-6 font-medium">
                            RT {{ $w->kartuKeluarga ? $w->kartuKeluarga->rt : '-' }} / RW {{ $w->kartuKeluarga ? $w->kartuKeluarga->rw : '-' }}
                        </td>
                        <td class="py-4 px-6">
                            @php
                                $statusColors = [
                                    'Aktif' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                    'Pendatang' => 'bg-cyan-50 text-cyan-700 border-cyan-200',
                                    'Pindah' => 'bg-amber-50 text-amber-700 border-amber-200',
                                    'Meninggal' => 'bg-rose-50 text-rose-700 border-rose-200'
                                ];
                                $color = $statusColors[$w->status_warga] ?? 'bg-slate-50 text-slate-700';
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold border {{ $color }}">
                                {{ $w->status_warga }}
                            </span>
                        </td>
                        <td class="py-4 px-6 text-right space-x-1">
                            <div class="inline-flex rounded-lg shadow-sm">
                                <a href="{{ route('warga.show', $w->id) }}" class="px-3 py-1.5 bg-slate-50 hover:bg-slate-100 text-slate-600 rounded-l-lg border border-slate-200 text-xs font-semibold transition" title="Detail">
                                    <i class="fa-solid fa-eye"></i> Detail
                                </a>
                                <a href="{{ route('warga.edit', $w->id) }}" class="px-3 py-1.5 bg-white hover:bg-slate-50 text-emerald-700 border-y border-r border-slate-200 text-xs font-semibold transition" title="Edit">
                                    <i class="fa-solid fa-pen"></i> Edit
                                </a>
                                <form action="{{ route('warga.destroy', $w->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data warga ini (Soft Delete)?')">
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
                        <td colspan="7" class="py-12 text-center text-slate-400">
                            <i class="fa-solid fa-users-slash text-4xl mb-3"></i>
                            <p class="text-sm">Tidak ada data warga ditemukan.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="px-6 py-4 border-t border-slate-100">
        {{ $warga->links() }}
    </div>
</div>
@endsection
