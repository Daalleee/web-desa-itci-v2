@extends('layouts.admin')

@section('title', 'Detail Kartu Keluarga')

@section('content')
<div class="max-w-5xl mx-auto space-y-8">
    
    <!-- Header KK Info -->
    <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <span class="text-xs uppercase font-extrabold text-slate-400 tracking-wider">Nomor Kartu Keluarga (KK)</span>
            <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ $kartuKeluarga->nomor_kk }}</h3>
            <p class="text-sm text-slate-500 mt-2">
                <i class="fa-solid fa-user-tie text-emerald-600 mr-1.5"></i> Kepala Keluarga: <strong>{{ $kartuKeluarga->kepala_keluarga }}</strong>
            </p>
            <p class="text-xs text-slate-400 mt-1">
                RT {{ $kartuKeluarga->rt }} / RW {{ $kartuKeluarga->rw }} • {{ $kartuKeluarga->alamat }}
            </p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('kartu-keluarga.edit', $kartuKeluarga->id) }}" class="px-4 py-2.5 bg-emerald-700 hover:bg-emerald-600 text-white rounded-xl text-xs font-semibold transition flex items-center gap-2">
                <i class="fa-solid fa-pen"></i> Edit KK
            </a>
            <a href="{{ route('kartu-keluarga.index') }}" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-semibold transition">
                Kembali
            </a>
        </div>
    </div>

    <!-- Family Members Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center">
            <h4 class="text-xs uppercase font-extrabold text-emerald-700 tracking-wider flex items-center">
                <i class="fa-solid fa-users mr-2 text-sm"></i> Daftar Anggota Keluarga ({{ $kartuKeluarga->warga->count() }} Orang)
            </h4>
            <!-- Tambah warga langsung berelasi ke KK ini -->
            <a href="{{ route('warga.create', ['kartu_keluarga_id' => $kartuKeluarga->id]) }}" class="px-3 py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 rounded-lg text-xs font-bold transition flex items-center gap-1.5">
                <i class="fa-solid fa-plus"></i> Tambah Anggota
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-slate-400 text-xs uppercase font-bold">
                        <th class="py-4 px-6">NIK</th>
                        <th class="py-4 px-6">Nama Lengkap</th>
                        <th class="py-4 px-6">Jenis Kelamin</th>
                        <th class="py-4 px-6">Hubungan Keluarga</th>
                        <th class="py-4 px-6">Pendidikan</th>
                        <th class="py-4 px-6">Pekerjaan</th>
                        <th class="py-4 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                    @forelse($kartuKeluarga->warga as $w)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-4 px-6 font-mono text-slate-500">
                                {{ $w->nik }}
                            </td>
                            <td class="py-4 px-6 font-bold text-slate-800">
                                {{ $w->nama_lengkap }}
                            </td>
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $w->jenis_kelamin == 'Laki-laki' ? 'bg-blue-50 text-blue-700' : 'bg-pink-50 text-pink-700' }}">
                                    {{ $w->jenis_kelamin }}
                                </span>
                            </td>
                            <td class="py-4 px-6 font-semibold text-slate-600">
                                {{ $w->hubungan_keluarga }}
                            </td>
                            <td class="py-4 px-6 text-slate-500">
                                {{ $w->pendidikan }}
                            </td>
                            <td class="py-4 px-6 text-slate-500">
                                {{ $w->pekerjaan }}
                            </td>
                            <td class="py-4 px-6 text-right">
                                <a href="{{ route('warga.show', $w->id) }}" class="px-2.5 py-1.5 bg-slate-50 hover:bg-slate-100 text-slate-600 rounded-lg text-xs font-semibold transition border border-slate-200">
                                    <i class="fa-solid fa-eye"></i> Profil Warga
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400">
                                <i class="fa-solid fa-users-slash text-4xl mb-3"></i>
                                <p class="text-sm">Belum ada anggota keluarga yang didaftarkan pada KK ini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
