<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Sistem Administrasi Desa ITCI</title>
    <!-- Script untuk memuat preferensi visual pengguna secepatnya guna menghindari kedipan layar -->
    <script>
        (function() {
            const theme = localStorage.getItem('theme') || 'light';
            const fontSize = localStorage.getItem('fontSize') || 'medium';
            const density = localStorage.getItem('density') || 'comfortable';
            const accent = localStorage.getItem('accent') || 'emerald';
            const sidebarOpen = localStorage.getItem('sidebarOpen') !== null ? localStorage.getItem('sidebarOpen') === 'true' : window.innerWidth >= 1024;

            const root = document.documentElement;
            
            // Setel Tema
            if (theme === 'dark' || (theme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                root.classList.add('dark');
            } else {
                root.classList.remove('dark');
            }

            // Setel Ukuran Font (Mempengaruhi satuan rem secara proporsional)
            if (fontSize === 'small') {
                root.style.fontSize = '14px';
            } else if (fontSize === 'large') {
                root.style.fontSize = '18px';
            } else {
                root.style.fontSize = '16px';
            }

            // Setel Atribut Tambahan
            root.setAttribute('data-density', density);
            root.setAttribute('data-accent', accent);
            root.setAttribute('data-sidebar-open', sidebarOpen);
        })();
    </script>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        accent: {
                            950: 'var(--color-primary-950)',
                            900: 'var(--color-primary-900)',
                            800: 'var(--color-primary-800)',
                            700: 'var(--color-primary-700)',
                            600: 'var(--color-primary-600)',
                            500: 'var(--color-primary-500)',
                            400: 'var(--color-primary-400)',
                            300: 'var(--color-primary-300)',
                            200: 'var(--color-primary-200)',
                            100: 'var(--color-primary-100)',
                            50: 'var(--color-primary-50)',
                        },
                        emerald: {
                            950: 'var(--color-primary-950)',
                            900: 'var(--color-primary-900)',
                            800: 'var(--color-primary-800)',
                            700: 'var(--color-primary-700)',
                            600: 'var(--color-primary-600)',
                            500: 'var(--color-primary-500)',
                            400: 'var(--color-primary-400)',
                            300: 'var(--color-primary-300)',
                            200: 'var(--color-primary-200)',
                            100: 'var(--color-primary-100)',
                            50: 'var(--color-primary-50)',
                        }
                    }
                }
            }
        }
    </script>
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- AlpineJS for interactive components -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        /* CSS Variables untuk Skema Warna Aksen Dinamis */
        :root, :root[data-accent="emerald"] {
            --color-primary-950: #022c22;
            --color-primary-900: #064e3b;
            --color-primary-800: #065f46;
            --color-primary-700: #047857;
            --color-primary-600: #059669;
            --color-primary-500: #10b981;
            --color-primary-400: #34d399;
            --color-primary-300: #6ee7b7;
            --color-primary-200: #a7f3d0;
            --color-primary-100: #d1fae5;
            --color-primary-50: #ecfdf5;
        }
        :root[data-accent="indigo"] {
            --color-primary-950: #1e1b4b;
            --color-primary-900: #312e81;
            --color-primary-800: #3730a3;
            --color-primary-700: #4338ca;
            --color-primary-600: #4f46e5;
            --color-primary-500: #6366f1;
            --color-primary-400: #818cf8;
            --color-primary-300: #a5b4fc;
            --color-primary-200: #c7d2fe;
            --color-primary-100: #e0e7ff;
            --color-primary-50: #f5f3ff;
        }
        :root[data-accent="slate"] {
            --color-primary-950: #09090b; /* Zinc 950 - hitam */
            --color-primary-900: #18181b; /* Zinc 900 */
            --color-primary-800: #27272a; /* Zinc 800 */
            --color-primary-700: #3f3f46; /* Zinc 700 */
            --color-primary-600: #52525b;
            --color-primary-500: #71717a;
            --color-primary-400: #a1a1aa;
            --color-primary-300: #d4d4d8;
            --color-primary-200: #e4e4e7;
            --color-primary-100: #f4f4f5;
            --color-primary-50: #fafafa;
        }
        :root[data-accent="crimson"] {
            --color-primary-950: #4c0519;
            --color-primary-900: #881337;
            --color-primary-800: #9f1239;
            --color-primary-700: #be123c;
            --color-primary-600: #e11d48;
            --color-primary-500: #f43f5e;
            --color-primary-400: #fb7185;
            --color-primary-300: #fca5a5;
            --color-primary-200: #fecaca;
            --color-primary-100: #fee2e2;
            --color-primary-50: #fff5f5;
        }

        /* Dukungan Kepadatan Tampilan Compact (Hemat Ruang untuk Eks-Excel) */
        html[data-density="compact"] td, 
        html[data-density="compact"] th {
            padding-top: 0.35rem !important;
            padding-bottom: 0.35rem !important;
            font-size: 0.85rem !important;
        }
        html[data-density="compact"] .grid {
            gap: 1rem !important;
        }
        html[data-density="compact"] h3 {
            font-size: 1.5rem !important;
        }
        html[data-density="compact"] .mb-8 {
            margin-bottom: 1.25rem !important;
        }
        html[data-density="compact"] .p-6 {
            padding: 1rem !important;
        }

        /* --- GLOBAL THEME OVERRIDES --- */

        /* 1. Theme: Hijau & Putih (emerald) */
        :root[data-accent="emerald"] body,
        :root[data-accent="emerald"] .bg-slate-50 {
            background-color: #f0fdf4 !important;
            color: #0f2922 !important;
        }
        :root[data-accent="emerald"] .bg-white {
            background-color: #ffffff !important;
            color: #0f2922 !important;
        }
        :root[data-accent="emerald"] .border-slate-100,
        :root[data-accent="emerald"] .border-slate-200,
        :root[data-accent="emerald"] .border-slate-300,
        :root[data-accent="emerald"] .border-slate-200\/60,
        :root[data-accent="emerald"] .divide-slate-100 {
            border-color: #d1fae5 !important;
        }
        :root[data-accent="emerald"] .text-slate-800,
        :root[data-accent="emerald"] .text-slate-900,
        :root[data-accent="emerald"] .text-slate-700 {
            color: #0f2922 !important;
        }
        :root[data-accent="emerald"] .text-slate-600 {
            color: #1e3f35 !important;
        }
        :root[data-accent="emerald"] .text-slate-500 {
            color: #3b5f54 !important;
        }
        :root[data-accent="emerald"] header {
            background-color: #ffffff !important;
            border-bottom-color: #d1fae5 !important;
        }
        :root[data-accent="emerald"] header h2 {
            color: #064e3b !important;
        }
        :root[data-accent="emerald"] input,
        :root[data-accent="emerald"] select,
        :root[data-accent="emerald"] textarea {
            background-color: #ffffff !important;
            color: #0f2922 !important;
            border-color: #a7f3d0 !important;
        }

        /* 1.1 Theme: Hijau & Putih in Dark Mode */
        .dark:root[data-accent="emerald"] body,
        .dark:root[data-accent="emerald"] .bg-slate-50 {
            background-color: #022c22 !important;
            color: #e6f4ea !important;
        }
        .dark:root[data-accent="emerald"] .bg-white {
            background-color: #064e3b !important;
            color: #e6f4ea !important;
        }
        .dark:root[data-accent="emerald"] .border-slate-100,
        .dark:root[data-accent="emerald"] .border-slate-200,
        .dark:root[data-accent="emerald"] .border-slate-300,
        .dark:root[data-accent="emerald"] .border-slate-200\/60,
        .dark:root[data-accent="emerald"] .divide-slate-100 {
            border-color: #065f46 !important;
        }
        .dark:root[data-accent="emerald"] .text-slate-800,
        .dark:root[data-accent="emerald"] .text-slate-900,
        .dark:root[data-accent="emerald"] .text-slate-700 {
            color: #ffffff !important;
        }
        .dark:root[data-accent="emerald"] .text-slate-600 {
            color: #a7f3d0 !important;
        }
        .dark:root[data-accent="emerald"] .text-slate-500 {
            color: #6ee7b7 !important;
        }
        .dark:root[data-accent="emerald"] header {
            background-color: #064e3b !important;
            border-bottom-color: #065f46 !important;
        }
        .dark:root[data-accent="emerald"] header h2 {
            color: #ffffff !important;
        }
        .dark:root[data-accent="emerald"] input,
        .dark:root[data-accent="emerald"] select,
        .dark:root[data-accent="emerald"] textarea {
            background-color: #022c22 !important;
            color: #ffffff !important;
            border-color: #065f46 !important;
        }

        /* 2. Theme: Biru & Putih (indigo) */
        :root[data-accent="indigo"] body,
        :root[data-accent="indigo"] .bg-slate-50 {
            background-color: #eff6ff !important;
            color: #1e293b !important;
        }
        :root[data-accent="indigo"] .bg-white {
            background-color: #ffffff !important;
            color: #1e293b !important;
        }
        :root[data-accent="indigo"] .border-slate-100,
        :root[data-accent="indigo"] .border-slate-200,
        :root[data-accent="indigo"] .border-slate-300,
        :root[data-accent="indigo"] .border-slate-200\/60,
        :root[data-accent="indigo"] .divide-slate-100 {
            border-color: #dbeafe !important;
        }
        :root[data-accent="indigo"] .text-slate-800,
        :root[data-accent="indigo"] .text-slate-900,
        :root[data-accent="indigo"] .text-slate-700 {
            color: #1e293b !important;
        }
        :root[data-accent="indigo"] .text-slate-600 {
            color: #334155 !important;
        }
        :root[data-accent="indigo"] .text-slate-500 {
            color: #475569 !important;
        }
        :root[data-accent="indigo"] header {
            background-color: #ffffff !important;
            border-bottom-color: #dbeafe !important;
        }
        :root[data-accent="indigo"] header h2 {
            color: #1e3a8a !important;
        }
        :root[data-accent="indigo"] input,
        :root[data-accent="indigo"] select,
        :root[data-accent="indigo"] textarea {
            background-color: #ffffff !important;
            color: #1e293b !important;
            border-color: #c7d2fe !important;
        }

        /* 2.1 Theme: Biru & Putih in Dark Mode */
        .dark:root[data-accent="indigo"] body,
        .dark:root[data-accent="indigo"] .bg-slate-50 {
            background-color: #0f172a !important;
            color: #cbd5e1 !important;
        }
        .dark:root[data-accent="indigo"] .bg-white {
            background-color: #1e293b !important;
            color: #cbd5e1 !important;
        }
        .dark:root[data-accent="indigo"] .border-slate-100,
        .dark:root[data-accent="indigo"] .border-slate-200,
        .dark:root[data-accent="indigo"] .border-slate-300,
        .dark:root[data-accent="indigo"] .border-slate-200\/60,
        .dark:root[data-accent="indigo"] .divide-slate-100 {
            border-color: #334155 !important;
        }
        .dark:root[data-accent="indigo"] .text-slate-800,
        .dark:root[data-accent="indigo"] .text-slate-900,
        .dark:root[data-accent="indigo"] .text-slate-700 {
            color: #ffffff !important;
        }
        .dark:root[data-accent="indigo"] .text-slate-600 {
            color: #e2e8f0 !important;
        }
        .dark:root[data-accent="indigo"] .text-slate-500 {
            color: #94a3b8 !important;
        }
        .dark:root[data-accent="indigo"] header {
            background-color: #1e293b !important;
            border-bottom-color: #334155 !important;
        }
        .dark:root[data-accent="indigo"] header h2 {
            color: #ffffff !important;
        }
        .dark:root[data-accent="indigo"] input,
        .dark:root[data-accent="indigo"] select,
        .dark:root[data-accent="indigo"] textarea {
            background-color: #0f172a !important;
            color: #ffffff !important;
            border-color: #334155 !important;
        }

        /* 3. Theme: Abu-abu & Hitam (slate) - Sleek Dark Monochrome */
        :root[data-accent="slate"] body,
        :root[data-accent="slate"] .bg-slate-50 {
            background-color: #09090b !important; /* Zinc 950 - hitam */
            color: #f4f4f5 !important; /* zinc 100 - abu terang */
        }
        :root[data-accent="slate"] .bg-white {
            background-color: #18181b !important; /* Zinc 900 - abu gelap */
            color: #f4f4f5 !important;
        }
        :root[data-accent="slate"] .border-slate-100,
        :root[data-accent="slate"] .border-slate-200,
        :root[data-accent="slate"] .border-slate-300,
        :root[data-accent="slate"] .border-slate-200\/60,
        :root[data-accent="slate"] .divide-slate-100 {
            border-color: #27272a !important; /* zinc-800 border */
        }
        :root[data-accent="slate"] .text-slate-800,
        :root[data-accent="slate"] .text-slate-900,
        :root[data-accent="slate"] .text-slate-700 {
            color: #ffffff !important;
        }
        :root[data-accent="slate"] .text-slate-600 {
            color: #d4d4d8 !important; /* zinc 300 */
        }
        :root[data-accent="slate"] .text-slate-500 {
            color: #a1a1aa !important; /* zinc 400 */
        }
        :root[data-accent="slate"] header {
            background-color: #18181b !important;
            border-bottom-color: #27272a !important;
            color: #ffffff !important;
        }
        :root[data-accent="slate"] header h2 {
            color: #ffffff !important;
        }
        :root[data-accent="slate"] input,
        :root[data-accent="slate"] select,
        :root[data-accent="slate"] textarea {
            background-color: #27272a !important;
            color: #ffffff !important;
            border-color: #3f3f46 !important;
        }
        :root[data-accent="slate"] input:focus,
        :root[data-accent="slate"] select:focus,
        :root[data-accent="slate"] textarea:focus {
            border-color: #71717a !important;
        }

        /* 3.1 Theme: Abu-abu & Hitam in Dark Mode (consistent dark) */
        .dark:root[data-accent="slate"] body,
        .dark:root[data-accent="slate"] .bg-slate-50 {
            background-color: #09090b !important;
            color: #f4f4f5 !important;
        }
        .dark:root[data-accent="slate"] .bg-white {
            background-color: #18181b !important;
            color: #f4f4f5 !important;
        }
        .dark:root[data-accent="slate"] .border-slate-100,
        .dark:root[data-accent="slate"] .border-slate-200,
        .dark:root[data-accent="slate"] .border-slate-300,
        .dark:root[data-accent="slate"] .border-slate-200\/60,
        .dark:root[data-accent="slate"] .divide-slate-100 {
            border-color: #27272a !important;
        }
        .dark:root[data-accent="slate"] .text-slate-800,
        .dark:root[data-accent="slate"] .text-slate-900,
        .dark:root[data-accent="slate"] .text-slate-700 {
            color: #ffffff !important;
        }
        .dark:root[data-accent="slate"] .text-slate-600 {
            color: #d4d4d8 !important;
        }
        .dark:root[data-accent="slate"] .text-slate-500 {
            color: #a1a1aa !important;
        }
        .dark:root[data-accent="slate"] header {
            background-color: #18181b !important;
            border-bottom-color: #27272a !important;
        }
        .dark:root[data-accent="slate"] input,
        .dark:root[data-accent="slate"] select,
        .dark:root[data-accent="slate"] textarea {
            background-color: #27272a !important;
            color: #ffffff !important;
            border-color: #3f3f46 !important;
        }

        /* 4. Theme: Merah & Putih (crimson) */
        :root[data-accent="crimson"] body,
        :root[data-accent="crimson"] .bg-slate-50 {
            background-color: #fff5f5 !important;
            color: #4c0519 !important;
        }
        :root[data-accent="crimson"] .bg-white {
            background-color: #ffffff !important;
            color: #4c0519 !important;
        }
        :root[data-accent="crimson"] .border-slate-100,
        :root[data-accent="crimson"] .border-slate-200,
        :root[data-accent="crimson"] .border-slate-300,
        :root[data-accent="crimson"] .border-slate-200\/60,
        :root[data-accent="crimson"] .divide-slate-100 {
            border-color: #fee2e2 !important;
        }
        :root[data-accent="crimson"] .text-slate-800,
        :root[data-accent="crimson"] .text-slate-900,
        :root[data-accent="crimson"] .text-slate-700 {
            color: #4c0519 !important;
        }
        :root[data-accent="crimson"] .text-slate-600 {
            color: #881337 !important;
        }
        :root[data-accent="crimson"] .text-slate-500 {
            color: #9f1239 !important;
        }
        :root[data-accent="crimson"] header {
            background-color: #ffffff !important;
            border-bottom-color: #fee2e2 !important;
        }
        :root[data-accent="crimson"] header h2 {
            color: #be123c !important;
        }
        :root[data-accent="crimson"] input,
        :root[data-accent="crimson"] select,
        :root[data-accent="crimson"] textarea {
            background-color: #ffffff !important;
            color: #4c0519 !important;
            border-color: #fecaca !important;
        }

        /* 4.1 Theme: Merah & Putih in Dark Mode */
        .dark:root[data-accent="crimson"] body,
        .dark:root[data-accent="crimson"] .bg-slate-50 {
            background-color: #4c0519 !important;
            color: #ffe4e6 !important;
        }
        .dark:root[data-accent="crimson"] .bg-white {
            background-color: #881337 !important;
            color: #ffe4e6 !important;
        }
        .dark:root[data-accent="crimson"] .border-slate-100,
        .dark:root[data-accent="crimson"] .border-slate-200,
        .dark:root[data-accent="crimson"] .border-slate-300,
        .dark:root[data-accent="crimson"] .border-slate-200\/60,
        .dark:root[data-accent="crimson"] .divide-slate-100 {
            border-color: #9f1239 !important;
        }
        .dark:root[data-accent="crimson"] .text-slate-800,
        .dark:root[data-accent="crimson"] .text-slate-900,
        .dark:root[data-accent="crimson"] .text-slate-700 {
            color: #ffffff !important;
        }
        .dark:root[data-accent="crimson"] .text-slate-600 {
            color: #fca5a5 !important;
        }
        .dark:root[data-accent="crimson"] .text-slate-500 {
            color: #fecaca !important;
        }
        .dark:root[data-accent="crimson"] header {
            background-color: #881337 !important;
            border-bottom-color: #9f1239 !important;
        }
        .dark:root[data-accent="crimson"] header h2 {
            color: #ffffff !important;
        }
        .dark:root[data-accent="crimson"] input,
        .dark:root[data-accent="crimson"] select,
        .dark:root[data-accent="crimson"] textarea {
            background-color: #4c0519 !important;
            color: #ffffff !important;
            border-color: #9f1239 !important;
        }

        /* Cegah animasi transisi saat memuat halaman */
        .preload * {
            -webkit-transition: none !important;
            -moz-transition: none !important;
            -ms-transition: none !important;
            -o-transition: none !important;
            transition: none !important;
        }

        /* CSS Rule untuk mengunci lebar sidebar secara instan jika dalam kondisi tertutup (menghindari kedipan AlpineJS) */
        html[data-sidebar-open="false"] aside {
            width: 5rem !important;
            transform: translateX(0) !important;
        }
        @media (max-width: 1023px) {
            html[data-sidebar-open="false"] aside {
                transform: translateX(-100%) !important;
                width: 16rem !important;
            }
        }
        
        /* Logo / Brand */
        html[data-sidebar-open="false"] aside > div:first-child {
            padding-left: 0 !important;
            padding-right: 0 !important;
            justify-content: center !important;
        }
        html[data-sidebar-open="false"] aside > div:first-child i {
            margin-right: 0 !important;
        }
        html[data-sidebar-open="false"] aside > div:first-child div {
            display: none !important;
        }
        
        /* Navigation Links */
        html[data-sidebar-open="false"] nav {
            padding-left: 0.5rem !important;
            padding-right: 0.5rem !important;
        }
        html[data-sidebar-open="false"] nav a {
            padding-left: 0 !important;
            padding-right: 0 !important;
            justify-content: center !important;
        }
        html[data-sidebar-open="false"] nav a i {
            margin-right: 0 !important;
            width: 1.5rem !important;
            text-align: center !important;
        }
        html[data-sidebar-open="false"] nav a span {
            display: none !important;
        }
        html[data-sidebar-open="false"] nav div.pt-4.pb-2 {
            padding-left: 0 !important;
            padding-right: 0 !important;
            text-align: center !important;
        }
        html[data-sidebar-open="false"] nav div.pt-4.pb-2 span {
            display: none !important;
        }
        
        /* User Footer Panel */
        html[data-sidebar-open="false"] aside > div:last-child {
            padding-left: 0.5rem !important;
            padding-right: 0.5rem !important;
        }
        html[data-sidebar-open="false"] aside > div:last-child .flex {
            justify-content: center !important;
        }
        html[data-sidebar-open="false"] aside > div:last-child .flex div {
            display: none !important;
        }
        html[data-sidebar-open="false"] aside > div:last-child form {
            margin-top: 1rem !important;
        }
        html[data-sidebar-open="false"] aside > div:last-child form button {
            padding-left: 0 !important;
            padding-right: 0 !important;
            justify-content: center !important;
        }
        html[data-sidebar-open="false"] aside > div:last-child form button i {
            margin-right: 0 !important;
        }
        html[data-sidebar-open="false"] aside > div:last-child form button span {
            display: none !important;
        }

        /* Sembunyikan scrollbar bawaan */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        .dark ::-webkit-scrollbar-track {
            background: #1e293b;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        .dark ::-webkit-scrollbar-thumb {
            background: #475569;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        .dark ::-webkit-scrollbar-thumb:hover {
            background: #64748b;
        }
        /* Cetak stylesheet khusus surat */
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background: white !important;
                color: black !important;
            }
            main {
                padding: 0 !important;
                margin: 0 !important;
            }
        }
    </style>
</head>
<body class="preload bg-slate-50 dark:bg-slate-900 font-sans text-slate-800 dark:text-slate-200 antialiased transition-colors duration-200">
    <div class="flex h-screen overflow-hidden" 
         x-data="{ 
             sidebarOpen: localStorage.getItem('sidebarOpen') !== null ? localStorage.getItem('sidebarOpen') === 'true' : window.innerWidth >= 1024,
             toggleSidebar() {
                 this.sidebarOpen = !this.sidebarOpen;
                 localStorage.setItem('sidebarOpen', this.sidebarOpen);
                 document.documentElement.setAttribute('data-sidebar-open', this.sidebarOpen);
             }
         }">
         
        <!-- Sidebar (no-print) -->
        <aside :class="sidebarOpen ? 'translate-x-0 w-64' : '-translate-x-full lg:translate-x-0 lg:w-20'" 
               class="fixed inset-y-0 left-0 z-50 bg-accent-950 text-accent-100 flex flex-col flex-shrink-0 transition-all duration-300 ease-in-out lg:static no-print shadow-xl">
            
            <!-- Logo / Brand -->
            <div class="h-16 flex items-center bg-accent-900 border-b border-accent-800 transition-all duration-300 ease-in-out" :class="sidebarOpen ? 'px-6 justify-start' : 'px-0 justify-center'">
                <i class="fa-solid fa-hotel text-2xl text-accent-400" :class="sidebarOpen ? 'mr-3' : ''"></i>
                <div x-show="sidebarOpen" x-transition class="overflow-hidden">
                    <h1 class="font-bold text-white leading-tight tracking-wide truncate">DESA ITCI</h1>
                    <span class="text-xs text-accent-400 font-medium truncate block">Administrasi Digital</span>
                </div>
            </div>
            
            <!-- Navigation Links -->
            <nav class="flex-1 overflow-y-auto py-6 space-y-1 transition-all duration-300 ease-in-out" :class="sidebarOpen ? 'px-4' : 'px-2'">
                @php
                    $role = auth()->user()->role;
                    $route = Route::currentRouteName();
                @endphp
 
                <!-- Dashboard (All) -->
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center py-3 rounded-lg text-sm font-medium transition-all duration-150 {{ $route == 'dashboard' ? 'bg-accent-800 text-white shadow-md' : 'hover:bg-accent-900/60 hover:text-white' }}"
                   :class="sidebarOpen ? 'px-4 justify-start' : 'px-0 justify-center'" title="Dashboard">
                    <i class="fa-solid fa-house text-lg {{ $route == 'dashboard' ? 'text-white' : 'text-accent-400' }}" :class="sidebarOpen ? 'w-5 mr-3' : 'w-6 text-center'"></i>
                    <span x-show="sidebarOpen" x-transition class="truncate">Dashboard</span>
                </a>
 
                <!-- Data Warga (Super Admin, Operator Desa, Kepala Desa, Ketua RT) -->
                @if(in_array($role, ['Super Admin', 'Operator Desa', 'Kepala Desa', 'Ketua RT']))
                    <a href="{{ route('warga.index') }}" 
                       class="flex items-center py-3 rounded-lg text-sm font-medium transition-all duration-150 {{ str_starts_with($route, 'warga.') ? 'bg-accent-800 text-white shadow-md' : 'hover:bg-accent-900/60 hover:text-white' }}"
                       :class="sidebarOpen ? 'px-4 justify-start' : 'px-0 justify-center'" title="Data Warga">
                        <i class="fa-solid fa-users text-lg {{ str_starts_with($route, 'warga.') ? 'text-white' : 'text-accent-400' }}" :class="sidebarOpen ? 'w-5 mr-3' : 'w-6 text-center'"></i>
                        <span x-show="sidebarOpen" x-transition class="truncate">Data Warga</span>
                    </a>
                @endif
 
                <!-- Kartu Keluarga (Super Admin, Operator Desa, Kepala Desa, Ketua RT) -->
                @if(in_array($role, ['Super Admin', 'Operator Desa', 'Kepala Desa', 'Ketua RT']))
                    <a href="{{ route('kartu-keluarga.index') }}" 
                       class="flex items-center py-3 rounded-lg text-sm font-medium transition-all duration-150 {{ str_starts_with($route, 'kartu-keluarga.') ? 'bg-accent-800 text-white shadow-md' : 'hover:bg-accent-900/60 hover:text-white' }}"
                       :class="sidebarOpen ? 'px-4 justify-start' : 'px-0 justify-center'" title="Kartu Keluarga">
                        <i class="fa-solid fa-address-card text-lg {{ str_starts_with($route, 'kartu-keluarga.') ? 'text-white' : 'text-accent-400' }}" :class="sidebarOpen ? 'w-5 mr-3' : 'w-6 text-center'"></i>
                        <span x-show="sidebarOpen" x-transition class="truncate">Kartu Keluarga</span>
                    </a>
                @endif
 
                <!-- Surat Otomatis (Super Admin, Operator Desa, Kepala Desa) -->
                @if(in_array($role, ['Super Admin', 'Operator Desa', 'Kepala Desa']))
                    <a href="{{ route('surat.index') }}" 
                       class="flex items-center py-3 rounded-lg text-sm font-medium transition-all duration-150 {{ str_starts_with($route, 'surat.') ? 'bg-accent-800 text-white shadow-md' : 'hover:bg-accent-900/60 hover:text-white' }}"
                       :class="sidebarOpen ? 'px-4 justify-start' : 'px-0 justify-center'" title="Surat Otomatis">
                        <i class="fa-solid fa-envelope-open-text text-lg {{ str_starts_with($route, 'surat.') ? 'text-white' : 'text-accent-400' }}" :class="sidebarOpen ? 'w-5 mr-3' : 'w-6 text-center'"></i>
                        <span x-show="sidebarOpen" x-transition class="truncate">Surat Otomatis</span>
                    </a>
                @endif
 
                <!-- Bantuan Sosial (Super Admin, Operator Desa, Kepala Desa) -->
                @if(in_array($role, ['Super Admin', 'Operator Desa', 'Kepala Desa']))
                    <a href="{{ route('bantuan.index') }}" 
                       class="flex items-center py-3 rounded-lg text-sm font-medium transition-all duration-150 {{ str_starts_with($route, 'bantuan.') ? 'bg-accent-800 text-white shadow-md' : 'hover:bg-accent-900/60 hover:text-white' }}"
                       :class="sidebarOpen ? 'px-4 justify-start' : 'px-0 justify-center'" title="Bantuan Sosial">
                        <i class="fa-solid fa-hand-holding-dollar text-lg {{ str_starts_with($route, 'bantuan.') ? 'text-white' : 'text-accent-400' }}" :class="sidebarOpen ? 'w-5 mr-3' : 'w-6 text-center'"></i>
                        <span x-show="sidebarOpen" x-transition class="truncate">Bantuan Sosial</span>
                    </a>
                @endif
 
                <!-- Arsip Dokumen (Super Admin, Operator Desa) -->
                @if(in_array($role, ['Super Admin', 'Operator Desa']))
                    <a href="{{ route('dokumen.index') }}" 
                       class="flex items-center py-3 rounded-lg text-sm font-medium transition-all duration-150 {{ $route == 'dokumen.index' ? 'bg-accent-800 text-white shadow-md' : 'hover:bg-accent-900/60 hover:text-white' }}"
                       :class="sidebarOpen ? 'px-4 justify-start' : 'px-0 justify-center'" title="Arsip Dokumen">
                        <i class="fa-solid fa-folder-open text-lg {{ $route == 'dokumen.index' ? 'text-white' : 'text-accent-400' }}" :class="sidebarOpen ? 'w-5 mr-3' : 'w-6 text-center'"></i>
                        <span x-show="sidebarOpen" x-transition class="truncate">Arsip Dokumen</span>
                    </a>
                @endif
 
                <!-- Laporan & Ekspor (Super Admin, Operator Desa, Kepala Desa, Ketua RT) -->
                @if(in_array($role, ['Super Admin', 'Operator Desa', 'Kepala Desa', 'Ketua RT']))
                    <a href="{{ route('laporan.index') }}" 
                       class="flex items-center py-3 rounded-lg text-sm font-medium transition-all duration-150 {{ str_starts_with($route, 'laporan.') ? 'bg-accent-800 text-white shadow-md' : 'hover:bg-accent-900/60 hover:text-white' }}"
                       :class="sidebarOpen ? 'px-4 justify-start' : 'px-0 justify-center'" title="Laporan & Ekspor">
                        <i class="fa-solid fa-file-invoice text-lg {{ str_starts_with($route, 'laporan.') ? 'text-white' : 'text-accent-400' }}" :class="sidebarOpen ? 'w-5 mr-3' : 'w-6 text-center'"></i>
                        <span x-show="sidebarOpen" x-transition class="truncate">Laporan & Ekspor</span>
                    </a>
                @endif

                <!-- Pengaturan Pengguna & Tampilan (All) -->
                <a href="{{ route('pengaturan') }}" 
                   class="flex items-center py-3 rounded-lg text-sm font-medium transition-all duration-150 {{ $route == 'pengaturan' ? 'bg-accent-800 text-white shadow-md' : 'hover:bg-accent-900/60 hover:text-white' }}"
                   :class="sidebarOpen ? 'px-4 justify-start' : 'px-0 justify-center'" title="Pengaturan">
                    <i class="fa-solid fa-gear text-lg {{ $route == 'pengaturan' ? 'text-white' : 'text-accent-400' }}" :class="sidebarOpen ? 'w-5 mr-3' : 'w-6 text-center'"></i>
                    <span x-show="sidebarOpen" x-transition class="truncate">Pengaturan</span>
                </a>
 
                <!-- Super Admin Menu -->
                @if($role === 'Super Admin')
                    <div class="pt-4 pb-2 border-t border-accent-900" :class="sidebarOpen ? 'px-4' : 'px-0'">
                        <span x-show="sidebarOpen" x-transition class="text-xs uppercase font-bold text-accent-500">Super Admin</span>
                    </div>
 
                    <a href="{{ route('users.index') }}" 
                       class="flex items-center py-3 rounded-lg text-sm font-medium transition-all duration-150 {{ str_starts_with($route, 'users.') ? 'bg-accent-800 text-white shadow-md' : 'hover:bg-accent-900/60 hover:text-white' }}"
                       :class="sidebarOpen ? 'px-4 justify-start' : 'px-0 justify-center'" title="Kelola Pengguna">
                        <i class="fa-solid fa-users-gear text-lg {{ str_starts_with($route, 'users.') ? 'text-white' : 'text-accent-400' }}" :class="sidebarOpen ? 'w-5 mr-3' : 'w-6 text-center'"></i>
                        <span x-show="sidebarOpen" x-transition class="truncate">Kelola Pengguna</span>
                    </a>
 
                    <a href="{{ route('backup.index') }}" 
                       class="flex items-center py-3 rounded-lg text-sm font-medium transition-all duration-150 {{ str_starts_with($route, 'backup.') ? 'bg-accent-800 text-white shadow-md' : 'hover:bg-accent-900/60 hover:text-white' }}"
                       :class="sidebarOpen ? 'px-4 justify-start' : 'px-0 justify-center'" title="Backup Sistem">
                        <i class="fa-solid fa-database text-lg {{ str_starts_with($route, 'backup.') ? 'text-white' : 'text-accent-400' }}" :class="sidebarOpen ? 'w-5 mr-3' : 'w-6 text-center'"></i>
                        <span x-show="sidebarOpen" x-transition class="truncate">Backup Sistem</span>
                    </a>
                @endif
            </nav>
            
            <!-- User Footer Panel -->
            <div class="p-4 border-t border-accent-900 bg-accent-950/80 transition-all duration-300" :class="sidebarOpen ? 'px-4' : 'px-2'">
                <div class="flex items-center" :class="sidebarOpen ? 'justify-start' : 'justify-center'">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=10b981&color=fff" class="w-10 h-10 rounded-full ring-2 ring-accent-500 shadow flex-shrink-0" alt="Avatar">
                    <div class="ml-3 overflow-hidden" x-show="sidebarOpen" x-transition>
                        <h4 class="text-sm font-bold text-white truncate">{{ auth()->user()->name }}</h4>
                        <span class="text-xs text-accent-400 truncate block">{{ auth()->user()->role }}</span>
                    </div>
                </div>
                <!-- Logout Form -->
                <form action="{{ route('logout') }}" method="POST" class="mt-4">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center py-2 bg-accent-900/40 hover:bg-red-800/80 hover:text-white text-accent-300 rounded-lg text-sm font-medium transition-all duration-150" :class="sidebarOpen ? 'px-4' : 'px-0'">
                        <i class="fa-solid fa-sign-out-alt text-base" :class="sidebarOpen ? 'mr-2' : ''"></i>
                        <span x-show="sidebarOpen" x-transition class="truncate">Keluar</span>
                    </button>
                </form>
            </div>
        </aside>
 
        <!-- Overlay Sidebar Mobile -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-40 bg-slate-900/60 backdrop-blur-sm lg:hidden no-print"></div>
 
        <!-- Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden">
            
            <!-- Header (no-print) -->
            <header class="h-16 bg-white dark:bg-slate-800 shadow-sm flex items-center justify-between px-6 lg:px-8 border-b border-slate-100 dark:border-slate-700 flex-shrink-0 no-print transition-colors duration-200">
                <!-- Hamburger Menu Mobile & Desktop -->
                <button @click="toggleSidebar()" class="text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 p-2 rounded focus:outline-none transition-colors duration-150">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
                
                <h2 class="text-lg font-bold text-slate-800 dark:text-white truncate">@yield('title')</h2>
                
                <div class="flex items-center space-x-4">
                    <!-- Badges Info -->
                    <span class="hidden md:inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-accent-50 dark:bg-accent-950/30 text-accent-700 dark:text-accent-400 border border-accent-200 dark:border-accent-800">
                        <i class="fa-solid fa-circle text-[6px] mr-1.5 text-accent-500"></i> Server Lokal (Offline Mode)
                    </span>
                    @if(auth()->user()->rt_rw)
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-50 dark:bg-blue-950/30 text-blue-700 dark:text-blue-400 border border-blue-200 dark:border-blue-800">
                            Wilayah RT: {{ auth()->user()->rt_rw }}
                        </span>
                    @endif
                    <div class="h-8 w-px bg-slate-200 dark:bg-slate-700 hidden md:block"></div>
                    <span class="text-xs text-slate-500 dark:text-slate-400 hidden md:block font-medium">Sistem v2.1</span>
                </div>
            </header>
            
            <!-- Main Content Container -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 dark:bg-slate-900 p-6 lg:p-8 transition-colors duration-200">
                
                <!-- Status Messages / Alerts -->
                @if(session('success'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
                         class="mb-6 flex items-center justify-between p-4 bg-accent-50 dark:bg-accent-950/20 border-l-4 border-accent-500 text-accent-800 dark:text-accent-200 rounded-r-lg shadow-sm"
                         x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                        <div class="flex items-center">
                            <i class="fa-solid fa-circle-check text-xl mr-3 text-accent-500"></i>
                            <span class="text-sm font-medium">{{ session('success') }}</span>
                        </div>
                        <button @click="show = false" class="text-accent-500 hover:text-accent-700 dark:hover:text-accent-300">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                @endif
 
                @if(session('error'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
                         class="mb-6 flex items-center justify-between p-4 bg-red-50 dark:bg-red-950/20 border-l-4 border-red-500 text-red-800 dark:text-red-200 rounded-r-lg shadow-sm"
                         x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                        <div class="flex items-center">
                            <i class="fa-solid fa-circle-xmark text-xl mr-3 text-red-500"></i>
                            <span class="text-sm font-medium">{{ session('error') }}</span>
                        </div>
                        <button @click="show = false" class="text-red-500 hover:text-red-700 dark:hover:text-red-300">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                @endif
                
                <!-- Core Content -->
                @yield('content')
            </main>
        </div>
    </div>
    
    <script>
        // Hapus class preload setelah dokumen selesai dimuat untuk mengaktifkan kembali efek transisi
        window.addEventListener('DOMContentLoaded', (event) => {
            setTimeout(() => {
                document.body.classList.remove('preload');
            }, 50);
        });
    </script>
</body>
</html>
