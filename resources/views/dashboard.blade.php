@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<!-- Grid Stats -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Card Total Warga -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center justify-between">
        <div>
            <span class="text-xs uppercase font-bold text-slate-400 tracking-wider">Total Warga Aktif</span>
            <h3 class="text-3xl font-extrabold text-slate-800 mt-1">{{ $total_warga }}</h3>
            <div class="text-xs text-slate-500 mt-2">
                <span class="text-emerald-600 font-semibold"><i class="fa-solid fa-venus-mars mr-1"></i> {{ $laki_laki }} L / {{ $perempuan }} P</span>
            </div>
        </div>
        <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center text-xl">
            <i class="fa-solid fa-users"></i>
        </div>
    </div>

    <!-- Card Total KK -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center justify-between">
        <div>
            <span class="text-xs uppercase font-bold text-slate-400 tracking-wider">Total Kartu Keluarga</span>
            <h3 class="text-3xl font-extrabold text-slate-800 mt-1">{{ $total_kk }}</h3>
            <div class="text-xs text-slate-500 mt-2">
                <span>Tersebar di berbagai RT</span>
            </div>
        </div>
        <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center text-xl">
            <i class="fa-solid fa-address-card"></i>
        </div>
    </div>

    <!-- Card Surat Cetak -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center justify-between">
        <div>
            <span class="text-xs uppercase font-bold text-slate-400 tracking-wider">Surat Dicetak</span>
            <h3 class="text-3xl font-extrabold text-slate-800 mt-1">{{ $total_surat }}</h3>
            <div class="text-xs text-slate-500 mt-2">
                <span>Bulan & tahun ini</span>
            </div>
        </div>
        <div class="w-12 h-12 bg-orange-50 text-orange-600 rounded-xl flex items-center justify-center text-xl">
            <i class="fa-solid fa-envelope-open-text"></i>
        </div>
    </div>

    <!-- Card Bantuan Sosial -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center justify-between">
        <div>
            <span class="text-xs uppercase font-bold text-slate-400 tracking-wider">Bantuan Aktif</span>
            <h3 class="text-3xl font-extrabold text-slate-800 mt-1">{{ $total_bantuan }}</h3>
            <div class="text-xs text-slate-500 mt-2">
                <span>Program Bansos Desa</span>
            </div>
        </div>
        <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center text-xl">
            <i class="fa-solid fa-hand-holding-dollar"></i>
        </div>
    </div>
</div>

<!-- Grid Grafik & Logs -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
    <!-- Grafik Umur & Pendidikan -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 lg:col-span-2 space-y-8">
        <div>
            <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center">
                <i class="fa-solid fa-chart-simple text-emerald-600 mr-2"></i> Grafik Demografis Warga
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Chart Umur -->
                <div class="border border-slate-100 p-4 rounded-xl">
                    <h4 class="text-sm font-semibold text-slate-600 mb-2 text-center">Kelompok Usia</h4>
                    <div class="h-48 flex justify-center">
                        <canvas id="chartUmur"></canvas>
                    </div>
                </div>

                <!-- Chart Agama -->
                <div class="border border-slate-100 p-4 rounded-xl">
                    <h4 class="text-sm font-semibold text-slate-600 mb-2 text-center">Agama Warga</h4>
                    <div class="h-48 flex justify-center">
                        <canvas id="chartAgama"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Chart Pendidikan -->
            <div class="border border-slate-100 p-4 rounded-xl">
                <h4 class="text-sm font-semibold text-slate-600 mb-2 text-center">Pendidikan Terakhir</h4>
                <div class="h-48 flex justify-center">
                    <canvas id="chartPendidikan"></canvas>
                </div>
            </div>

            <!-- Chart Pekerjaan -->
            <div class="border border-slate-100 p-4 rounded-xl">
                <h4 class="text-sm font-semibold text-slate-600 mb-2 text-center">Pekerjaan Warga</h4>
                <div class="h-48 flex justify-center">
                    <canvas id="chartPekerjaan"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Aktivitas Terbaru -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
        <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center">
            <i class="fa-solid fa-clock-rotate-left text-emerald-600 mr-2"></i> Aktivitas Terbaru
        </h3>
        
        <div class="flow-root">
            <ul class="-mb-8">
                @forelse($recent_logs as $log)
                    <li>
                        <div class="relative pb-8">
                            @if(!$loop->last)
                                <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-slate-200" aria-hidden="true"></span>
                            @endif
                            <div class="relative flex space-x-3">
                                <div>
                                    <span class="h-8 w-8 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center ring-8 ring-white text-xs">
                                        <i class="fa-solid fa-user-edit"></i>
                                    </span>
                                </div>
                                <div class="flex-1 min-w-0 pt-1.5">
                                    <p class="text-xs font-semibold text-slate-800">{{ $log->aktivitas }}</p>
                                    <div class="text-left mt-0.5 flex justify-between items-center">
                                        <span class="text-[10px] text-slate-400"><i class="fa-solid fa-user mr-0.5"></i> {{ $log->user ? $log->user->name : 'Sistem' }}</span>
                                        <span class="text-[10px] text-slate-400">{{ $log->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                @empty
                    <div class="text-center py-8 text-slate-400">
                        <i class="fa-solid fa-database text-4xl mb-2"></i>
                        <p class="text-sm">Belum ada aktivitas tercatat.</p>
                    </div>
                @endforelse
            </ul>
        </div>
    </div>
</div>

<!-- Load ChartJS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // 1. Chart Umur
    new Chart(document.getElementById('chartUmur'), {
        type: 'doughnut',
        data: {
            labels: {!! json_encode(array_keys($chart_umur)) !!},
            datasets: [{
                data: {!! json_encode(array_values($chart_umur)) !!},
                backgroundColor: ['#f87171', '#fb923c', '#fbbf24', '#34d399', '#60a5fa'],
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { boxWidth: 10, font: { size: 10 } } }
            }
        }
    });

    // 2. Chart Agama
    new Chart(document.getElementById('chartAgama'), {
        type: 'pie',
        data: {
            labels: {!! json_encode(array_keys($chart_agama)) !!},
            datasets: [{
                data: {!! json_encode(array_values($chart_agama)) !!},
                backgroundColor: ['#10b981', '#3b82f6', '#f59e0b', '#ef4444', '#8b5cf6', '#ec4899'],
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { boxWidth: 10, font: { size: 10 } } }
            }
        }
    });

    // 3. Chart Pendidikan
    new Chart(document.getElementById('chartPendidikan'), {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_keys($chart_pendidikan)) !!},
            datasets: [{
                label: 'Jumlah Warga',
                data: {!! json_encode(array_values($chart_pendidikan)) !!},
                backgroundColor: '#3b82f6',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1, font: { size: 9 } } },
                x: { ticks: { font: { size: 9 } } }
            }
        }
    });

    // 4. Chart Pekerjaan
    new Chart(document.getElementById('chartPekerjaan'), {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_keys($chart_pekerjaan)) !!},
            datasets: [{
                label: 'Jumlah Warga',
                data: {!! json_encode(array_values($chart_pekerjaan)) !!},
                backgroundColor: '#10b981',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1, font: { size: 9 } } },
                x: { ticks: { font: { size: 9 } } }
            }
        }
    });
</script>
@endsection