@extends('layouts.admin')

@section('title', 'Dashboard Utama')

@section('content')
<!-- Grid Stats -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Card Total Warga -->
    <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700/60 flex items-center justify-between hover:-translate-y-1 hover:shadow-md transition-all duration-300">
        <div>
            <span class="text-xs uppercase font-bold text-slate-400 dark:text-slate-500 tracking-wider block">Total Warga Aktif</span>
            <h3 class="text-3xl font-extrabold text-slate-800 dark:text-white mt-1">{{ $total_warga }}</h3>
            <div class="text-xs mt-2 flex items-center">
                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-accent-50 dark:bg-accent-950/30 text-accent-700 dark:text-accent-400 border border-accent-200 dark:border-accent-800/50">
                    <i class="fa-solid fa-venus-mars mr-1.5"></i>{{ $laki_laki }} L / {{ $perempuan }} P
                </span>
            </div>
        </div>
        <div class="w-12 h-12 bg-accent-50 dark:bg-accent-950/40 text-accent-600 dark:text-accent-400 rounded-xl flex items-center justify-center text-xl shadow-inner border border-accent-100 dark:border-accent-900/50">
            <i class="fa-solid fa-users"></i>
        </div>
    </div>

    <!-- Card Total KK -->
    <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700/60 flex items-center justify-between hover:-translate-y-1 hover:shadow-md transition-all duration-300">
        <div>
            <span class="text-xs uppercase font-bold text-slate-400 dark:text-slate-500 tracking-wider block">Total Kartu Keluarga</span>
            <h3 class="text-3xl font-extrabold text-slate-800 dark:text-white mt-1">{{ $total_kk }}</h3>
            <div class="text-xs text-slate-500 dark:text-slate-400 mt-2 flex items-center">
                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-50 dark:bg-blue-950/30 text-blue-700 dark:text-blue-400 border border-blue-200 dark:border-blue-800/50">
                    <i class="fa-solid fa-map-location-dot mr-1.5"></i>Tersebar di RT 01-05
                </span>
            </div>
        </div>
        <div class="w-12 h-12 bg-blue-50 dark:bg-blue-950/40 text-blue-600 dark:text-blue-400 rounded-xl flex items-center justify-center text-xl shadow-inner border border-blue-100 dark:border-blue-900/50">
            <i class="fa-solid fa-address-card"></i>
        </div>
    </div>

    <!-- Card Surat Cetak -->
    <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700/60 flex items-center justify-between hover:-translate-y-1 hover:shadow-md transition-all duration-300">
        <div>
            <span class="text-xs uppercase font-bold text-slate-400 dark:text-slate-500 tracking-wider block">Surat Dicetak</span>
            <h3 class="text-3xl font-extrabold text-slate-800 dark:text-white mt-1">{{ $total_surat }}</h3>
            <div class="text-xs text-slate-500 dark:text-slate-400 mt-2 flex items-center">
                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-50 dark:bg-amber-950/30 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-800/50">
                    <i class="fa-solid fa-circle-check mr-1.5"></i>Bulan & tahun ini
                </span>
            </div>
        </div>
        <div class="w-12 h-12 bg-amber-50 dark:bg-amber-950/40 text-amber-600 dark:text-amber-400 rounded-xl flex items-center justify-center text-xl shadow-inner border border-amber-100 dark:border-amber-900/50">
            <i class="fa-solid fa-envelope-open-text"></i>
        </div>
    </div>

    <!-- Card Bantuan Sosial -->
    <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700/60 flex items-center justify-between hover:-translate-y-1 hover:shadow-md transition-all duration-300">
        <div>
            <span class="text-xs uppercase font-bold text-slate-400 dark:text-slate-500 tracking-wider block">Bantuan Aktif</span>
            <h3 class="text-3xl font-extrabold text-slate-800 dark:text-white mt-1">{{ $total_bantuan }}</h3>
            <div class="text-xs text-slate-500 dark:text-slate-400 mt-2 flex items-center">
                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-purple-50 dark:bg-purple-950/30 text-purple-700 dark:text-purple-400 border border-purple-200 dark:border-purple-800/50">
                    <i class="fa-solid fa-handshake-angle mr-1.5"></i>Program Bansos Desa
                </span>
            </div>
        </div>
        <div class="w-12 h-12 bg-purple-50 dark:bg-purple-950/40 text-purple-600 dark:text-purple-400 rounded-xl flex items-center justify-center text-xl shadow-inner border border-purple-100 dark:border-purple-900/50">
            <i class="fa-solid fa-hand-holding-dollar"></i>
        </div>
    </div>
</div>

<!-- Grid Grafik & Logs -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
    <!-- Grafik Demografi Warga -->
    <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700/60 lg:col-span-2 space-y-8">
        <div>
            <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-6 flex items-center">
                <i class="fa-solid fa-chart-simple text-accent-500 mr-3"></i> Grafik Demografis Warga
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Chart Umur -->
                <div class="border border-slate-100 dark:border-slate-750 p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/40">
                    <h4 class="text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3 text-center">Kelompok Usia</h4>
                    <div class="h-52 flex justify-center items-center">
                        <canvas id="chartUmur"></canvas>
                    </div>
                </div>

                <!-- Chart Agama -->
                <div class="border border-slate-100 dark:border-slate-750 p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/40">
                    <h4 class="text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3 text-center">Agama Warga</h4>
                    <div class="h-52 flex justify-center items-center">
                        <canvas id="chartAgama"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Chart Pendidikan -->
            <div class="border border-slate-100 dark:border-slate-750 p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/40">
                <h4 class="text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3 text-center">Pendidikan Terakhir</h4>
                <div class="h-52 flex justify-center items-center">
                    <canvas id="chartPendidikan"></canvas>
                </div>
            </div>

            <!-- Chart Pekerjaan -->
            <div class="border border-slate-100 dark:border-slate-750 p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/40">
                <h4 class="text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3 text-center">Pekerjaan Warga</h4>
                <div class="h-52 flex justify-center items-center">
                    <canvas id="chartPekerjaan"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Aktivitas Terbaru -->
    <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700/60 flex flex-col justify-between">
        <div>
            <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-6 flex items-center">
                <i class="fa-solid fa-clock-rotate-left text-accent-500 mr-3"></i> Aktivitas Terbaru
            </h3>
            
            <div class="flow-root relative pl-2">
                <ul class="-mb-8">
                    @forelse($recent_logs as $log)
                        <li>
                            <div class="relative pb-6">
                                @if(!$loop->last)
                                    <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-slate-200 dark:bg-slate-700" aria-hidden="true"></span>
                                @endif
                                <div class="relative flex space-x-3">
                                    <div>
                                        <span class="h-8 w-8 rounded-full bg-accent-50 dark:bg-accent-950/50 text-accent-600 dark:text-accent-400 flex items-center justify-center ring-4 ring-white dark:ring-slate-800 text-xs">
                                            <i class="fa-solid fa-user-edit"></i>
                                        </span>
                                    </div>
                                    <div class="flex-1 min-w-0 pt-1">
                                        <p class="text-xs font-semibold text-slate-850 dark:text-slate-200">{{ $log->aktivitas }}</p>
                                        <div class="text-left mt-1.5 flex justify-between items-center">
                                            <span class="text-[10px] text-slate-400 dark:text-slate-500 font-medium">
                                                <i class="fa-solid fa-user mr-1 text-slate-300 dark:text-slate-600"></i>{{ $log->user ? $log->user->name : 'Sistem' }}
                                            </span>
                                            <span class="text-[10px] text-slate-400 dark:text-slate-500 font-medium">
                                                <i class="fa-solid fa-calendar mr-1 text-slate-300 dark:text-slate-600"></i>{{ $log->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @empty
                        <div class="text-center py-12 text-slate-400 dark:text-slate-500">
                            <i class="fa-solid fa-database text-4xl mb-3 block text-slate-300 dark:text-slate-700"></i>
                            <p class="text-sm">Belum ada aktivitas tercatat.</p>
                        </div>
                    @endforelse
                </ul>
            </div>
        </div>
        
        <div class="mt-6 pt-4 border-t border-slate-100 dark:border-slate-700 flex justify-end">
            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                Log Server Lokal (Live)
            </span>
        </div>
    </div>
</div>

<!-- Load ChartJS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Konfigurasi ChartJS Dinamis Berdasarkan Mode Gelap/Terang & Warna Aksen
    (function() {
        const isDark = document.documentElement.classList.contains('dark');
        const textColor = isDark ? '#cbd5e1' : '#475569';
        const gridColor = isDark ? '#334155' : '#f1f5f9';

        // Baca warna primer CSS aksen terpilih
        const rootStyles = getComputedStyle(document.documentElement);
        const accentColor = rootStyles.getPropertyValue('--color-primary-500').trim() || '#10b981';
        const accentColorLight = rootStyles.getPropertyValue('--color-primary-300').trim() || '#a7f3d0';

        // Setel default Chart.js
        Chart.defaults.color = textColor;
        Chart.defaults.font.family = "'Inter', sans-serif";

        const basePieOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 8,
                        font: { size: 10, weight: '500' },
                        color: textColor,
                        padding: 12
                    }
                }
            }
        };

        const baseBarOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        color: textColor,
                        font: { size: 9 }
                    },
                    grid: {
                        color: gridColor,
                        drawBorder: false
                    }
                },
                x: {
                    ticks: {
                        color: textColor,
                        font: { size: 9 }
                    },
                    grid: {
                        display: false
                    }
                }
            }
        };

        // 1. Chart Umur
        new Chart(document.getElementById('chartUmur'), {
            type: 'doughnut',
            data: {
                labels: {!! json_encode(array_keys($chart_umur)) !!},
                datasets: [{
                    data: {!! json_encode(array_values($chart_umur)) !!},
                    backgroundColor: ['#f43f5e', '#fb7185', '#38bdf8', '#34d399', '#6366f1'],
                    borderWidth: isDark ? 2 : 1,
                    borderColor: isDark ? '#1e293b' : '#ffffff'
                }]
            },
            options: basePieOptions
        });

        // 2. Chart Agama
        new Chart(document.getElementById('chartAgama'), {
            type: 'pie',
            data: {
                labels: {!! json_encode(array_keys($chart_agama)) !!},
                datasets: [{
                    data: {!! json_encode(array_values($chart_agama)) !!},
                    backgroundColor: ['#10b981', '#6366f1', '#f59e0b', '#f43f5e', '#8b5cf6', '#ec4899'],
                    borderWidth: isDark ? 2 : 1,
                    borderColor: isDark ? '#1e293b' : '#ffffff'
                }]
            },
            options: basePieOptions
        });

        // 3. Chart Pendidikan
        new Chart(document.getElementById('chartPendidikan'), {
            type: 'bar',
            data: {
                labels: {!! json_encode(array_keys($chart_pendidikan)) !!},
                datasets: [{
                    label: 'Jumlah Warga',
                    data: {!! json_encode(array_values($chart_pendidikan)) !!},
                    backgroundColor: accentColor,
                    borderRadius: 6,
                }]
            },
            options: baseBarOptions
        });

        // 4. Chart Pekerjaan
        new Chart(document.getElementById('chartPekerjaan'), {
            type: 'bar',
            data: {
                labels: {!! json_encode(array_keys($chart_pekerjaan)) !!},
                datasets: [{
                    label: 'Jumlah Warga',
                    data: {!! json_encode(array_values($chart_pekerjaan)) !!},
                    backgroundColor: accentColorLight,
                    borderRadius: 6,
                }]
            },
            options: baseBarOptions
        });
    })();
</script>
@endsection