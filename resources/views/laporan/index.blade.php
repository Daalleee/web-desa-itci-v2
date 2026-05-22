@extends('layouts.admin')

@section('title', 'Laporan & Ekspor/Impor')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    
    <!-- Bagian 1: Ekspor Data -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex flex-col justify-between">
        <div>
            <div class="flex items-center space-x-3 mb-6">
                <div class="w-10 h-10 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center text-xl">
                    <i class="fa-solid fa-file-csv"></i>
                </div>
                <div>
                    <h3 class="text-md font-bold text-slate-800">Ekspor Data Warga</h3>
                    <p class="text-xs text-slate-500">Unduh data warga dalam format CSV/Excel dengan filter.</p>
                </div>
            </div>

            <form action="{{ route('laporan.export') }}" method="GET" class="space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <!-- Filter RT -->
                    <div>
                        <label class="block text-xs uppercase font-bold text-slate-500 mb-2">RT</label>
                        <select name="rt" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                            <option value="">Semua RT</option>
                            @foreach(['001', '002', '003', '004', '005'] as $rt)
                                <option value="{{ $rt }}">RT {{ $rt }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filter RW -->
                    <div>
                        <label class="block text-xs uppercase font-bold text-slate-500 mb-2">RW</label>
                        <select name="rw" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                            <option value="">Semua RW</option>
                            @foreach(['001', '002', '003'] as $rw)
                                <option value="{{ $rw }}">RW {{ $rw }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Jenis Kelamin -->
                    <div>
                        <label class="block text-xs uppercase font-bold text-slate-500 mb-2">Gender</label>
                        <select name="jenis_kelamin" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                            <option value="">Semua</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full py-2.5 bg-emerald-800 hover:bg-emerald-700 text-white rounded-xl text-sm font-semibold transition flex items-center justify-center gap-2 shadow-lg shadow-emerald-800/10">
                        <i class="fa-solid fa-download"></i> Ekspor ke CSV
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bagian 2: Impor Data -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex flex-col justify-between">
        <div>
            <div class="flex items-center space-x-3 mb-6">
                <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center text-xl">
                    <i class="fa-solid fa-file-import"></i>
                </div>
                <div>
                    <h3 class="text-md font-bold text-slate-800">Impor Data Warga</h3>
                    <p class="text-xs text-slate-500">Unggah berkas CSV warga untuk dimasukkan secara massal.</p>
                </div>
            </div>

            <div class="bg-slate-50 p-4 rounded-xl border border-slate-100 mb-4 flex items-center justify-between">
                <div class="text-left">
                    <span class="text-xs font-semibold text-slate-600 block">Belum punya template impor?</span>
                    <span class="text-[10px] text-slate-400">Gunakan format kolom yang sesuai sistem.</span>
                </div>
                <a href="{{ route('laporan.template') }}" class="px-3 py-1.5 bg-white hover:bg-slate-100 text-emerald-800 border border-slate-200 rounded-lg text-xs font-bold transition">
                    <i class="fa-solid fa-download mr-1"></i> Unduh Template
                </a>
            </div>

            <form action="{{ route('laporan.preview') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label for="file_csv" class="block text-xs uppercase font-bold text-slate-500 mb-2">Pilih File CSV</label>
                    <input type="file" name="file_csv" id="file_csv" required
                           class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 border border-slate-200 rounded-xl p-1 bg-white">
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-2.5 bg-blue-700 hover:bg-blue-600 text-white rounded-xl text-sm font-semibold transition flex items-center justify-center gap-2 shadow-lg shadow-blue-700/10">
                        <i class="fa-solid fa-eye"></i> Unggah & Preview Impor
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

<!-- Bagian 3: Tabel Statistik RT -->
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="p-6 border-b border-slate-100 bg-slate-50/50">
        <h3 class="text-md font-bold text-slate-800 flex items-center gap-2">
            <i class="fa-solid fa-chart-column text-emerald-600"></i> Statistik Demografi per RT
        </h3>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/30 border-b border-slate-100 text-slate-400 text-xs uppercase font-bold">
                    <th class="py-4 px-6">RT</th>
                    <th class="py-4 px-6">Jumlah Warga</th>
                    <th class="py-4 px-6">Laki-laki</th>
                    <th class="py-4 px-6">Perempuan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                @forelse($rtStats as $stat)
                    <tr class="hover:bg-slate-50/30 transition duration-150">
                        <td class="py-4 px-6 font-bold text-slate-800">
                            RT {{ $stat->rt ?? '-' }}
                        </td>
                        <td class="py-4 px-6 font-semibold">
                            {{ $stat->total_warga }} Orang
                        </td>
                        <td class="py-4 px-6 text-blue-600">
                            {{ $stat->total_l }} Orang
                        </td>
                        <td class="py-4 px-6 text-pink-600">
                            {{ $stat->total_p }} Orang
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-12 text-center text-slate-400">
                            <i class="fa-solid fa-users-slash text-4xl mb-3"></i>
                            <p class="text-sm">Belum ada statistik wilayah tersedia.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
