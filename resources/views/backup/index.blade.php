@extends('layouts.admin')

@section('title', 'Backup Sistem')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 md:p-8">
        <div class="flex items-center space-x-4 mb-6">
            <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center text-2xl">
                <i class="fa-solid fa-database"></i>
            </div>
            <div>
                <h3 class="text-xl font-bold text-slate-800">Backup Database Manual</h3>
                <p class="text-sm text-slate-500">Unduh salinan cadangan basis data (.sql) sistem Anda secara langsung.</p>
            </div>
        </div>

        <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-8 flex items-start">
            <i class="fa-solid fa-circle-info text-amber-500 mt-0.5 mr-3 text-lg"></i>
            <div class="text-sm text-amber-800 leading-relaxed">
                <strong>Catatan Penting Pemeliharaan:</strong>
                <ul class="list-disc list-inside mt-1 space-y-1">
                    <li>Disarankan untuk mengunduh berkas cadangan database secara berkala (misal: setiap Jumat sore).</li>
                    <li>Berkas cadangan berisi seluruh skema tabel dan data (warga, kartu keluarga, surat, dll).</li>
                    <li>Berkas ini dapat digunakan untuk pemulihan data jika terjadi kerusakan sistem atau hardware.</li>
                    <li>Pastikan menyimpan berkas cadangan di media penyimpanan eksternal yang aman.</li>
                </ul>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 p-4 border border-slate-100 rounded-xl bg-slate-50/50">
            <div class="flex items-center gap-3">
                <i class="fa-solid fa-file-export text-slate-400 text-2xl"></i>
                <div class="text-left">
                    <span class="text-xs text-slate-400 block uppercase font-bold">Format Berkas</span>
                    <span class="text-sm font-semibold text-slate-700">MySQL Dump (.sql)</span>
                </div>
            </div>
            <a href="{{ route('backup.download') }}" class="w-full sm:w-auto px-6 py-3 bg-emerald-800 hover:bg-emerald-700 text-white rounded-xl text-sm font-semibold transition flex items-center justify-center gap-2 shadow-lg shadow-emerald-800/10">
                <i class="fa-solid fa-cloud-arrow-down"></i> Unduh Cadangan Database
            </a>
        </div>
    </div>
</div>
@endsection
