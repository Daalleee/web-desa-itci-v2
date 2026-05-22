@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6 text-gray-900">Manajemen Backup Sistem</h1>

    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6 max-w-2xl">
        <div class="flex items-start space-x-4 mb-6">
            <div class="p-3 bg-indigo-100 rounded-lg text-indigo-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-semibold text-gray-800">Backup Database Manual</h2>
                <p class="text-gray-600 mt-1">
                    Fitur ini akan mengekspor seluruh data dari database sistem (Warga, KK, Surat, dll) ke dalam file <strong>.sql</strong>. 
                    Gunakan file ini untuk mengamankan data secara fisik di luar server.
                </p>
            </div>
        </div>

        <div class="bg-gray-50 rounded-lg p-4 mb-6 border border-gray-100">
            <ul class="text-sm text-gray-600 space-y-2">
                <li class="flex items-center">
                    <svg class="h-4 w-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Mencakup skema dan data seluruh tabel inti.
                </li>
                <li class="flex items-center">
                    <svg class="h-4 w-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Format file: SQL (dapat di-import kembali via phpMyAdmin).
                </li>
                <li class="flex items-center">
                    <svg class="h-4 w-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Proses cepat dan langsung mengunduh ke perangkat Anda.
                </li>
            </ul>
        </div>

        <div class="flex items-center justify-between border-t border-gray-100 pt-6">
            <a href="{{ route('backup.download') }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg shadow-md transition duration-150 ease-in-out">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
                Proses & Unduh Sekarang (.sql)
            </a>
        </div>
    </div>

    <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-4 max-w-2xl">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-blue-800">Saran Pemeliharaan (Maintenance)</h3>
                <div class="mt-2 text-sm text-blue-700">
                    <p>Sesuai dengan SOP di <strong>job.md</strong>, disarankan untuk melakukan backup setiap hari Jumat sore dan menyimpan filenya di Flashdisk atau Harddisk Eksternal khusus.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection