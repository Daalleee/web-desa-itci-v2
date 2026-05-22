<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Sistem Administrasi Desa ITCI</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- AlpineJS for interactive components -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        /* Sembunyikan scrollbar bawaan */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
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
<body class="bg-slate-50 font-sans text-slate-800 antialiased">
    <div class="flex h-screen overflow-hidden" x-data="{ sidebarOpen: false }">
        
        <!-- Sidebar (no-print) -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
               class="fixed inset-y-0 left-0 z-50 w-64 bg-emerald-950 text-emerald-100 flex flex-col flex-shrink-0 transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static no-print shadow-xl">
            
            <!-- Logo / Brand -->
            <div class="h-16 flex items-center px-6 bg-emerald-900 border-b border-emerald-800">
                <i class="fa-solid fa-hotel text-2xl text-emerald-400 mr-3"></i>
                <div>
                    <h1 class="font-bold text-white leading-tight tracking-wide">DESA ITCI</h1>
                    <span class="text-xs text-emerald-400 font-medium">Administrasi Digital</span>
                </div>
            </div>
            
            <!-- Navigation Links -->
            <nav class="flex-1 overflow-y-auto px-4 py-6 space-y-1">
                @php
                    $role = auth()->user()->role;
                    $route = Route::currentRouteName();
                @endphp

                <!-- Dashboard (All) -->
                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 rounded-lg text-sm font-medium transition-colors duration-150 {{ $route == 'dashboard' ? 'bg-emerald-800 text-white shadow-md' : 'hover:bg-emerald-900/60 hover:text-white' }}">
                    <i class="fa-solid fa-chart-pie w-5 mr-3 text-lg {{ $route == 'dashboard' ? 'text-white' : 'text-emerald-400' }}"></i>
                    Dashboard
                </a>

                @if($role !== 'Super Admin')
                    <!-- Data Warga -->
                    <a href="{{ route('warga.index') }}" class="flex items-center px-4 py-3 rounded-lg text-sm font-medium transition-colors duration-150 {{ str_starts_with($route, 'warga.') ? 'bg-emerald-800 text-white shadow-md' : 'hover:bg-emerald-900/60 hover:text-white' }}">
                        <i class="fa-solid fa-users w-5 mr-3 text-lg {{ str_starts_with($route, 'warga.') ? 'text-white' : 'text-emerald-400' }}"></i>
                        Data Warga
                    </a>

                    <!-- Kartu Keluarga -->
                    <a href="{{ route('kartu-keluarga.index') }}" class="flex items-center px-4 py-3 rounded-lg text-sm font-medium transition-colors duration-150 {{ str_starts_with($route, 'kartu-keluarga.') ? 'bg-emerald-800 text-white shadow-md' : 'hover:bg-emerald-900/60 hover:text-white' }}">
                        <i class="fa-solid fa-address-card w-5 mr-3 text-lg {{ str_starts_with($route, 'kartu-keluarga.') ? 'text-white' : 'text-emerald-400' }}"></i>
                        Kartu Keluarga
                    </a>

                    <!-- Surat Otomatis (Operator, Kades) -->
                    @if(in_array($role, ['Operator Desa', 'Kepala Desa']))
                        <a href="{{ route('surat.index') }}" class="flex items-center px-4 py-3 rounded-lg text-sm font-medium transition-colors duration-150 {{ str_starts_with($route, 'surat.') ? 'bg-emerald-800 text-white shadow-md' : 'hover:bg-emerald-900/60 hover:text-white' }}">
                            <i class="fa-solid fa-envelope-open-text w-5 mr-3 text-lg {{ str_starts_with($route, 'surat.') ? 'text-white' : 'text-emerald-400' }}"></i>
                            Surat Otomatis
                        </a>
                    @endif

                    <!-- Bantuan Sosial (Operator, Kades) -->
                    @if(in_array($role, ['Operator Desa', 'Kepala Desa']))
                        <a href="{{ route('bantuan.index') }}" class="flex items-center px-4 py-3 rounded-lg text-sm font-medium transition-colors duration-150 {{ str_starts_with($route, 'bantuan.') ? 'bg-emerald-800 text-white shadow-md' : 'hover:bg-emerald-900/60 hover:text-white' }}">
                            <i class="fa-solid fa-hand-holding-dollar w-5 mr-3 text-lg {{ str_starts_with($route, 'bantuan.') ? 'text-white' : 'text-emerald-400' }}"></i>
                            Bantuan Sosial
                        </a>
                    @endif

                    <!-- Arsip Dokumen (Operator) -->
                    @if($role === 'Operator Desa')
                        <a href="{{ route('dokumen.index') }}" class="flex items-center px-4 py-3 rounded-lg text-sm font-medium transition-colors duration-150 {{ $route == 'dokumen.index' ? 'bg-emerald-800 text-white shadow-md' : 'hover:bg-emerald-900/60 hover:text-white' }}">
                            <i class="fa-solid fa-folder-open w-5 mr-3 text-lg {{ $route == 'dokumen.index' ? 'text-white' : 'text-emerald-400' }}"></i>
                            Arsip Dokumen
                        </a>
                    @endif

                    <!-- Laporan -->
                    <a href="{{ route('laporan.index') }}" class="flex items-center px-4 py-3 rounded-lg text-sm font-medium transition-colors duration-150 {{ str_starts_with($route, 'laporan.') ? 'bg-emerald-800 text-white shadow-md' : 'hover:bg-emerald-900/60 hover:text-white' }}">
                        <i class="fa-solid fa-file-invoice w-5 mr-3 text-lg {{ str_starts_with($route, 'laporan.') ? 'text-white' : 'text-emerald-400' }}"></i>
                        Laporan & Ekspor
                    </a>
                @endif

                <!-- Super Admin Menu -->
                @if($role === 'Super Admin')
                    <div class="pt-4 pb-2 border-t border-emerald-900">
                        <span class="text-xs uppercase font-bold text-emerald-500 px-4">Super Admin</span>
                    </div>

                    <a href="{{ route('users.index') }}" class="flex items-center px-4 py-3 rounded-lg text-sm font-medium transition-colors duration-150 {{ str_starts_with($route, 'users.') ? 'bg-emerald-800 text-white shadow-md' : 'hover:bg-emerald-900/60 hover:text-white' }}">
                        <i class="fa-solid fa-users-gear w-5 mr-3 text-lg {{ str_starts_with($route, 'users.') ? 'text-white' : 'text-emerald-400' }}"></i>
                        Kelola Pengguna
                    </a>

                    <a href="{{ route('backup.index') }}" class="flex items-center px-4 py-3 rounded-lg text-sm font-medium transition-colors duration-150 {{ str_starts_with($route, 'backup.') ? 'bg-emerald-800 text-white shadow-md' : 'hover:bg-emerald-900/60 hover:text-white' }}">
                        <i class="fa-solid fa-database w-5 mr-3 text-lg {{ str_starts_with($route, 'backup.') ? 'text-white' : 'text-emerald-400' }}"></i>
                        Backup Sistem
                    </a>
                @endif
            </nav>
            
            <!-- User Footer Panel -->
            <div class="p-4 border-t border-emerald-900 bg-emerald-950/80">
                <div class="flex items-center">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=10b981&color=fff" class="w-10 h-10 rounded-full ring-2 ring-emerald-500 shadow" alt="Avatar">
                    <div class="ml-3 overflow-hidden">
                        <h4 class="text-sm font-bold text-white truncate">{{ auth()->user()->name }}</h4>
                        <span class="text-xs text-emerald-400 truncate block">{{ auth()->user()->role }}</span>
                    </div>
                </div>
                <!-- Logout Form -->
                <form action="{{ route('logout') }}" method="POST" class="mt-4">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center px-4 py-2 bg-emerald-900/40 hover:bg-red-800/80 hover:text-white text-emerald-300 rounded-lg text-sm font-medium transition-all duration-150">
                        <i class="fa-solid fa-sign-out-alt mr-2"></i>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        <!-- Overlay Sidebar Mobile -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-40 bg-slate-900/60 backdrop-blur-sm lg:hidden no-print"></div>

        <!-- Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden">
            
            <!-- Header (no-print) -->
            <header class="h-16 bg-white shadow-sm flex items-center justify-between px-6 lg:px-8 border-b border-slate-100 flex-shrink-0 no-print">
                <!-- Hamburger Menu Mobile -->
                <button @click="sidebarOpen = true" class="text-slate-500 hover:text-slate-700 lg:hidden p-2 rounded focus:outline-none">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
                
                <h2 class="text-lg font-bold text-slate-800 truncate">@yield('title')</h2>
                
                <div class="flex items-center space-x-4">
                    <!-- Badges Info -->
                    <span class="hidden md:inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                        <i class="fa-solid fa-circle text-[6px] mr-1.5 text-emerald-500"></i> Server Lokal (Offline Mode)
                    </span>
                    @if(auth()->user()->rt_rw)
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                            Wilayah RT: {{ auth()->user()->rt_rw }}
                        </span>
                    @endif
                    <div class="h-8 w-px bg-slate-200 hidden md:block"></div>
                    <span class="text-xs text-slate-500 hidden md:block font-medium">Sistem v2.1</span>
                </div>
            </header>
            
            <!-- Main Content Container -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 p-6 lg:p-8">
                
                <!-- Status Messages / Alerts -->
                @if(session('success'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
                         class="mb-6 flex items-center justify-between p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 rounded-r-lg shadow-sm"
                         x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                        <div class="flex items-center">
                            <i class="fa-solid fa-circle-check text-xl mr-3 text-emerald-500"></i>
                            <span class="text-sm font-medium">{{ session('success') }}</span>
                        </div>
                        <button @click="show = false" class="text-emerald-500 hover:text-emerald-700">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                @endif

                @if(session('error'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
                         class="mb-6 flex items-center justify-between p-4 bg-red-50 border-l-4 border-red-500 text-red-800 rounded-r-lg shadow-sm"
                         x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                        <div class="flex items-center">
                            <i class="fa-solid fa-circle-xmark text-xl mr-3 text-red-500"></i>
                            <span class="text-sm font-medium">{{ session('error') }}</span>
                        </div>
                        <button @click="show = false" class="text-red-500 hover:text-red-700">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                @endif
                
                <!-- Core Content -->
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
