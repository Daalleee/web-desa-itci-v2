@extends('layouts.admin')

@section('title', 'Pengaturan Tampilan & Sistem')

@section('content')
<div class="max-w-4xl mx-auto space-y-8" 
     x-data="{
         theme: localStorage.getItem('theme') || 'light',
         fontSize: localStorage.getItem('fontSize') || 'medium',
         density: localStorage.getItem('density') || 'comfortable',
         accent: localStorage.getItem('accent') || 'emerald',
         
         updateTheme(val) {
             this.theme = val;
             localStorage.setItem('theme', val);
             const root = document.documentElement;
             if (val === 'dark' || (val === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                 root.classList.add('dark');
             } else {
                 root.classList.remove('dark');
             }
         },
         updateFontSize(val) {
             this.fontSize = val;
             localStorage.setItem('fontSize', val);
             const root = document.documentElement;
             if (val === 'small') {
                 root.style.fontSize = '14px';
             } else if (val === 'large') {
                 root.style.fontSize = '18px';
             } else {
                 root.style.fontSize = '16px';
             }
         },
         updateDensity(val) {
             this.density = val;
             localStorage.setItem('density', val);
             document.documentElement.setAttribute('data-density', val);
         },
         updateAccent(val) {
             this.accent = val;
             localStorage.setItem('accent', val);
             document.documentElement.setAttribute('data-accent', val);
         }
     }">
     
     <!-- Section: Tampilan -->
     <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 transition-colors duration-200">
         <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-6 flex items-center">
             <i class="fa-solid fa-palette text-accent-500 mr-3"></i> Personalisasi Tampilan
         </h3>
         
         <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
             <!-- 1. Tema Tampilan -->
             <div class="space-y-3">
                 <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300">Tema Visual</label>
                 <p class="text-xs text-slate-500 dark:text-slate-400">Pilih mode tampilan layar yang paling nyaman bagi mata Anda.</p>
                 <div class="grid grid-cols-3 gap-3 pt-2">
                     <button @click="updateTheme('light')" 
                             :class="theme === 'light' ? 'border-accent-500 bg-accent-50 dark:bg-accent-950/20 text-accent-700 dark:text-accent-400 font-semibold ring-2 ring-accent-500/20' : 'border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700'"
                             class="flex flex-col items-center justify-center p-3 rounded-xl border text-xs transition-all duration-150 bg-white dark:bg-slate-800">
                         <i class="fa-solid fa-sun text-lg mb-1.5"></i>
                         <span>Terang</span>
                     </button>
                     <button @click="updateTheme('dark')" 
                             :class="theme === 'dark' ? 'border-accent-500 bg-accent-50 dark:bg-accent-950/20 text-accent-700 dark:text-accent-400 font-semibold ring-2 ring-accent-500/20' : 'border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700'"
                             class="flex flex-col items-center justify-center p-3 rounded-xl border text-xs transition-all duration-150 bg-white dark:bg-slate-800">
                         <i class="fa-solid fa-moon text-lg mb-1.5"></i>
                         <span>Gelap</span>
                     </button>
                     <button @click="updateTheme('system')" 
                             :class="theme === 'system' ? 'border-accent-500 bg-accent-50 dark:bg-accent-950/20 text-accent-700 dark:text-accent-400 font-semibold ring-2 ring-accent-500/20' : 'border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700'"
                             class="flex flex-col items-center justify-center p-3 rounded-xl border text-xs transition-all duration-150 bg-white dark:bg-slate-800">
                         <i class="fa-solid fa-desktop text-lg mb-1.5"></i>
                         <span>Sistem</span>
                     </button>
                 </div>
             </div>

             <!-- 2. Warna Aksen -->
             <div class="space-y-3">
                 <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300">Warna Aksen Sistem</label>
                 <p class="text-xs text-slate-500 dark:text-slate-400">Pilih warna primer untuk sidebar, tombol, dan ornamen visual website.</p>
                 <div class="grid grid-cols-4 gap-3 pt-2">
                     <button @click="updateAccent('emerald')" 
                             :class="accent === 'emerald' ? 'border-emerald-500 bg-emerald-50 dark:bg-emerald-950/20 text-emerald-700 font-semibold ring-2 ring-emerald-500/20' : 'border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700'"
                             class="flex flex-col items-center justify-center p-2.5 rounded-xl border text-xs transition-all duration-150 bg-white dark:bg-slate-800">
                         <span class="w-4 h-4 rounded-full bg-emerald-500 mb-1.5"></span>
                         <span>Emerald</span>
                     </button>
                     <button @click="updateAccent('indigo')" 
                             :class="accent === 'indigo' ? 'border-indigo-500 bg-indigo-50 dark:bg-indigo-950/20 text-indigo-700 font-semibold ring-2 ring-indigo-500/20' : 'border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700'"
                             class="flex flex-col items-center justify-center p-2.5 rounded-xl border text-xs transition-all duration-150 bg-white dark:bg-slate-800">
                         <span class="w-4 h-4 rounded-full bg-indigo-500 mb-1.5"></span>
                         <span>Indigo</span>
                     </button>
                     <button @click="updateAccent('slate')" 
                             :class="accent === 'slate' ? 'border-slate-500 bg-slate-100 dark:bg-slate-950/20 text-slate-700 font-semibold ring-2 ring-slate-500/20' : 'border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700'"
                             class="flex flex-col items-center justify-center p-2.5 rounded-xl border text-xs transition-all duration-150 bg-white dark:bg-slate-800">
                         <span class="w-4 h-4 rounded-full bg-slate-500 mb-1.5"></span>
                         <span>Slate</span>
                     </button>
                     <button @click="updateAccent('crimson')" 
                             :class="accent === 'crimson' ? 'border-rose-500 bg-rose-50 dark:bg-rose-950/20 text-rose-700 font-semibold ring-2 ring-rose-500/20' : 'border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700'"
                             class="flex flex-col items-center justify-center p-2.5 rounded-xl border text-xs transition-all duration-150 bg-white dark:bg-slate-800">
                         <span class="w-4 h-4 rounded-full bg-rose-500 mb-1.5"></span>
                         <span>Crimson</span>
                     </button>
                 </div>
             </div>

             <!-- 3. Ukuran Huruf -->
             <div class="space-y-3">
                 <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300">Ukuran Huruf (Font Size)</label>
                 <p class="text-xs text-slate-500 dark:text-slate-400">Atur keterbacaan teks agar nyaman dibaca oleh mata Anda.</p>
                 <div class="grid grid-cols-3 gap-3 pt-2">
                     <button @click="updateFontSize('small')" 
                             :class="fontSize === 'small' ? 'border-accent-500 bg-accent-50 dark:bg-accent-950/20 text-accent-700 dark:text-accent-400 font-semibold ring-2 ring-accent-500/20' : 'border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700'"
                             class="flex flex-col items-center justify-center p-3 rounded-xl border text-xs transition-all duration-150 bg-white dark:bg-slate-800">
                         <span class="text-xs mb-1">A</span>
                         <span>Kecil (14px)</span>
                     </button>
                     <button @click="updateFontSize('medium')" 
                             :class="fontSize === 'medium' ? 'border-accent-500 bg-accent-50 dark:bg-accent-950/20 text-accent-700 dark:text-accent-400 font-semibold ring-2 ring-accent-500/20' : 'border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700'"
                             class="flex flex-col items-center justify-center p-3 rounded-xl border text-xs transition-all duration-150 bg-white dark:bg-slate-800">
                         <span class="text-sm mb-1">A</span>
                         <span>Sedang (16px)</span>
                     </button>
                     <button @click="updateFontSize('large')" 
                             :class="fontSize === 'large' ? 'border-accent-500 bg-accent-50 dark:bg-accent-950/20 text-accent-700 dark:text-accent-400 font-semibold ring-2 ring-accent-500/20' : 'border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700'"
                             class="flex flex-col items-center justify-center p-3 rounded-xl border text-xs transition-all duration-150 bg-white dark:bg-slate-800">
                         <span class="text-lg mb-1">A</span>
                         <span>Besar (18px)</span>
                     </button>
                 </div>
             </div>

             <!-- 4. Kepadatan Antarmuka -->
             <div class="space-y-3">
                 <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300">Kepadatan Grid & Tabel (Density)</label>
                 <p class="text-xs text-slate-500 dark:text-slate-400">Mode padat sangat cocok untuk melihat data warga dalam jumlah banyak sekaligus.</p>
                 <div class="grid grid-cols-2 gap-3 pt-2">
                     <button @click="updateDensity('comfortable')" 
                             :class="density === 'comfortable' ? 'border-accent-500 bg-accent-50 dark:bg-accent-950/20 text-accent-700 dark:text-accent-400 font-semibold ring-2 ring-accent-500/20' : 'border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700'"
                             class="flex flex-col items-center justify-center p-3 rounded-xl border text-xs transition-all duration-150 bg-white dark:bg-slate-800">
                         <i class="fa-solid fa-grip text-lg mb-1.5"></i>
                         <span>Longgar (Comfortable)</span>
                     </button>
                     <button @click="updateDensity('compact')" 
                             :class="density === 'compact' ? 'border-accent-500 bg-accent-50 dark:bg-accent-950/20 text-accent-700 dark:text-accent-400 font-semibold ring-2 ring-accent-500/20' : 'border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700'"
                             class="flex flex-col items-center justify-center p-3 rounded-xl border text-xs transition-all duration-150 bg-white dark:bg-slate-800">
                         <i class="fa-solid fa-grip-vertical text-lg mb-1.5"></i>
                         <span>Rapat (Compact)</span>
                     </button>
                 </div>
             </div>
         </div>
     </div>

     <!-- Section: Excel Migration & Citizen Data Management Guide -->
     <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 transition-colors duration-200">
         <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-4 flex items-center">
             <i class="fa-solid fa-file-excel text-emerald-600 dark:text-emerald-400 mr-3"></i> Panduan Migrasi Data Warga dari Excel
         </h3>
         <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed mb-4">
             Website ini dirancang untuk menggantikan file Excel manual yang rawan rusak atau terhapus. Ikuti panduan di bawah ini untuk mengimpor data lama Anda dengan sukses:
         </p>
         
         <div class="space-y-4">
             <div class="flex items-start space-x-3 p-3 bg-slate-50 dark:bg-slate-700/50 rounded-xl">
                 <span class="w-6 h-6 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400 flex items-center justify-center text-xs font-bold mt-0.5 flex-shrink-0">1</span>
                 <div>
                     <h4 class="text-sm font-semibold text-slate-800 dark:text-white">Persiapkan Kartu Keluarga Terlebih Dahulu</h4>
                     <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Sistem menggunakan relasi data yang ketat. Agar warga dapat diimpor, <strong>Nomor Kartu Keluarga (KK) harus sudah terdaftar</strong> di database web (Menu Kartu Keluarga).</p>
                 </div>
             </div>

             <div class="flex items-start space-x-3 p-3 bg-slate-50 dark:bg-slate-700/50 rounded-xl">
                 <span class="w-6 h-6 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400 flex items-center justify-center text-xs font-bold mt-0.5 flex-shrink-0">2</span>
                 <div>
                     <h4 class="text-sm font-semibold text-slate-800 dark:text-white">Gunakan Template Resmi CSV</h4>
                     <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Unduh template CSV resmi dari menu <strong>Laporan & Ekspor</strong>. Pastikan tidak menghapus baris pertama (header kolom) dan ikuti format persis di contoh.</p>
                 </div>
             </div>

             <div class="flex items-start space-x-3 p-3 bg-slate-50 dark:bg-slate-700/50 rounded-xl">
                 <span class="w-6 h-6 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400 flex items-center justify-center text-xs font-bold mt-0.5 flex-shrink-0">3</span>
                 <div>
                     <h4 class="text-sm font-semibold text-slate-800 dark:text-white">Pembersihan Format Sel</h4>
                     <ul class="list-disc list-inside text-xs text-slate-500 dark:text-slate-400 mt-1 space-y-1 font-medium">
                         <li><strong>NIK & No. KK:</strong> Harus berupa angka murni, tepat 16 digit. Excel sering mengubah ini menjadi notasi ilmiah (e.g. 6.4E+15). Set format sel Excel Anda ke <em>Text</em> sebelum mengetik atau mengimpor.</li>
                         <li><strong>Tanggal Lahir:</strong> Gunakan format standar <code>YYYY-MM-DD</code> (contoh: 1995-12-31).</li>
                         <li><strong>Jenis Kelamin:</strong> Harus diisi tepat <code>Laki-laki</code> atau <code>Perempuan</code> (sensitif huruf besar-kecil).</li>
                     </ul>
                 </div>
             </div>

             <div class="flex items-start space-x-3 p-3 bg-slate-50 dark:bg-slate-700/50 rounded-xl">
                 <span class="w-6 h-6 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400 flex items-center justify-center text-xs font-bold mt-0.5 flex-shrink-0">4</span>
                 <div>
                     <h4 class="text-sm font-semibold text-slate-800 dark:text-white">Manfaatkan Halaman Preview Impor</h4>
                     <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Setelah mengunggah berkas CSV, sistem akan memeriksa data Anda terlebih dahulu. Baris yang memiliki NIK ganda atau format tidak valid akan disorot warna merah dengan rincian eror sehingga Anda bisa memperbaikinya tanpa merusak database.</p>
                 </div>
             </div>
         </div>
     </div>
</div>
@endsection
