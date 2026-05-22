<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Surat Resmi - Desa ITCI</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4 sm:p-6 md:p-8">

    <div class="max-w-xl w-full bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden">
        
        <!-- Header Banner Green -->
        <div class="bg-emerald-950 px-6 py-8 text-center text-white relative">
            <div class="absolute inset-0 bg-cover bg-center opacity-10" style="background-image: url('https://images.unsplash.com/photo-1579546929518-9e396f3cc809?q=80&w=1000');"></div>
            
            <div class="relative space-y-3">
                <div class="w-16 h-16 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center mx-auto border border-white/20">
                    <i class="fa-solid fa-shield-check text-emerald-400 text-3xl"></i>
                </div>
                <div>
                    <h2 class="text-xs uppercase tracking-widest font-extrabold text-emerald-400">Sistem Verifikasi Digital</h2>
                    <h1 class="text-xl font-bold font-serif mt-1">Pemerintah Desa ITCI</h1>
                    <p class="text-[10px] text-emerald-200/70 italic mt-1">Kec. Sepaku, Kab. Penajam Paser Utara, Kaltim</p>
                </div>
            </div>
        </div>

        <!-- Verification Status Indicator -->
        <div class="p-6 text-center border-b border-slate-100 bg-slate-50/50">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-50 text-emerald-800 border border-emerald-200 rounded-full text-sm font-bold shadow-sm">
                <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i> Dokumen Terverifikasi Asli
            </div>
            <p class="text-xs text-slate-400 mt-2">Dokumen ini sah dikeluarkan oleh Kepala Desa ITCI dan tercatat dalam database kependudukan.</p>
        </div>

        <!-- Details Table -->
        <div class="p-6 space-y-6">
            <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider border-b border-slate-100 pb-2">Rincian Surat Keterangan</h3>

            <div class="space-y-4">
                <!-- Nomor Surat -->
                <div class="flex flex-col sm:flex-row sm:justify-between border-b border-slate-50 pb-3 gap-1">
                    <span class="text-xs font-bold text-slate-400 uppercase">Nomor Surat</span>
                    <span class="text-sm font-mono font-bold text-slate-800">{{ $surat->nomor_surat }}</span>
                </div>

                <!-- Jenis Surat -->
                <div class="flex flex-col sm:flex-row sm:justify-between border-b border-slate-50 pb-3 gap-1">
                    <span class="text-xs font-bold text-slate-400 uppercase">Jenis Surat Keterangan</span>
                    <span class="text-sm font-semibold text-slate-800">Surat Keterangan {{ $surat->jenis_surat }}</span>
                </div>

                <!-- Nama Warga -->
                <div class="flex flex-col sm:flex-row sm:justify-between border-b border-slate-50 pb-3 gap-1">
                    <span class="text-xs font-bold text-slate-400 uppercase">Nama Warga / Pemohon</span>
                    <span class="text-sm font-bold text-emerald-950 uppercase">{{ $surat->warga ? $surat->warga->nama_lengkap : '—' }}</span>
                </div>

                <!-- NIK Warga -->
                <div class="flex flex-col sm:flex-row sm:justify-between border-b border-slate-50 pb-3 gap-1">
                    <span class="text-xs font-bold text-slate-400 uppercase">NIK</span>
                    <span class="text-sm font-mono font-semibold text-slate-700">{{ $surat->warga ? $surat->warga->nik : '—' }}</span>
                </div>

                <!-- Ditandatangani Oleh -->
                <div class="flex flex-col sm:flex-row sm:justify-between border-b border-slate-50 pb-3 gap-1">
                    <span class="text-xs font-bold text-slate-400 uppercase">Ditandatangani Oleh</span>
                    <span class="text-sm font-semibold text-slate-800">{{ $surat->ditandatangani_oleh }}</span>
                </div>

                <!-- Tanggal Dikeluarkan -->
                <div class="flex flex-col sm:flex-row sm:justify-between pb-1 gap-1">
                    <span class="text-xs font-bold text-slate-400 uppercase">Tanggal Dikeluarkan</span>
                    <span class="text-sm font-semibold text-slate-800">{{ $surat->created_at->translatedFormat('d F Y') }}</span>
                </div>
            </div>
        </div>

        <!-- Footer Info -->
        <div class="bg-slate-100/50 px-6 py-4 text-center text-[10px] text-slate-400 border-t border-slate-150">
            <p>Halaman ini merupakan bukti resmi validitas dokumen digital Pemerintah Desa ITCI.</p>
            <p class="mt-1 font-semibold text-slate-500">© 2026 Pemerintah Desa ITCI. All Rights Reserved.</p>
        </div>

    </div>

</body>
</html>
