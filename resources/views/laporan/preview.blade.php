@extends('layouts.admin')

@section('title', 'Preview Impor Data Warga')

@section('content')
<div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 mb-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h3 class="text-lg font-bold text-slate-800">Verifikasi & Preview Data</h3>
            <p class="text-sm text-slate-500">Silakan periksa kembali data di bawah ini sebelum disimpan ke database.</p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('laporan.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-sm font-semibold transition text-center">
                Batal
            </a>

            @if($isValidAll)
                <form action="{{ route('laporan.import') }}" method="POST" class="inline-block">
                    @csrf
                    <button type="submit" class="px-5 py-2.5 bg-emerald-800 hover:bg-emerald-700 text-white rounded-xl text-sm font-semibold transition shadow-lg shadow-emerald-800/10 flex items-center gap-1.5">
                        <i class="fa-solid fa-cloud-arrow-up"></i> Simpan & Impor Sekarang
                    </button>
                </form>
            @else
                <button disabled class="px-5 py-2.5 bg-slate-200 text-slate-400 rounded-xl text-sm font-semibold cursor-not-allowed flex items-center gap-1.5" title="Selesaikan error terlebih dahulu">
                    <i class="fa-solid fa-triangle-exclamation"></i> Ada Error Pada Data
                </button>
            @endif
        </div>
    </div>

    @if(!$isValidAll)
        <div class="mt-4 p-4 bg-red-50 border-l-4 border-red-500 text-red-800 rounded-r-lg text-sm flex items-start">
            <i class="fa-solid fa-circle-exclamation text-red-500 mt-0.5 mr-3 text-lg"></i>
            <div>
                <strong>Perhatian:</strong> Beberapa baris data memiliki kesalahan. Impor tidak dapat dilanjutkan hingga seluruh kesalahan diperbaiki atau pastikan semua NIK unik dan No. KK sudah terdaftar di database.
            </div>
        </div>
    @endif
</div>

<!-- Table Preview -->
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-xs">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100 text-slate-400 uppercase font-bold">
                    <th class="py-3 px-4">Status</th>
                    <th class="py-3 px-4">NIK</th>
                    <th class="py-3 px-4">Nama Lengkap</th>
                    <th class="py-3 px-4">No. KK</th>
                    <th class="py-3 px-4">Gender</th>
                    <th class="py-3 px-4">Lahir</th>
                    <th class="py-3 px-4">Agama</th>
                    <th class="py-3 px-4">Hubungan</th>
                    <th class="py-3 px-4">Alamat</th>
                    <th class="py-3 px-4">Kesalahan / Validasi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-700">
                @foreach($rows as $row)
                    <tr class="hover:bg-slate-50/50 transition duration-150 {{ $row['status'] === 'Error' ? 'bg-red-50/20' : '' }}">
                        <td class="py-3 px-4">
                            @if($row['status'] === 'Valid')
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    Valid
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full font-bold bg-red-50 text-red-700 border border-red-200">
                                    Error
                                </span>
                            @endif
                        </td>
                        <td class="py-3 px-4 font-mono font-bold">{{ $row['nik'] }}</td>
                        <td class="py-3 px-4 font-semibold text-slate-800">{{ $row['nama_lengkap'] }}</td>
                        <td class="py-3 px-4 font-mono">{{ $row['nomor_kk'] }}</td>
                        <td class="py-3 px-4">{{ $row['jenis_kelamin'] }}</td>
                        <td class="py-3 px-4">{{ $row['tempat_lahir'] }}, {{ $row['tanggal_lahir'] }}</td>
                        <td class="py-3 px-4">{{ $row['agama'] }}</td>
                        <td class="py-3 px-4 text-slate-500 font-medium">{{ $row['hubungan_keluarga'] }}</td>
                        <td class="py-3 px-4 max-w-xs truncate" title="{{ $row['alamat'] }}">{{ $row['alamat'] }}</td>
                        <td class="py-3 px-4 text-red-600 font-semibold">
                            @if(!empty($row['errors']))
                                <ul class="list-disc list-inside space-y-0.5">
                                    @foreach($row['errors'] as $err)
                                        <li>{{ $err }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <span class="text-emerald-600">—</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
