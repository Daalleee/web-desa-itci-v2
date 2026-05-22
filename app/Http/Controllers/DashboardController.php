<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use App\Models\KartuKeluarga;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $wargaAll = Warga::all();

        // 1. Hitung Umur secara dinamis
        $umur = [
            'Balita (0-5)' => 0,
            'Anak-anak (6-12)' => 0,
            'Remaja (13-18)' => 0,
            'Dewasa (19-59)' => 0,
            'Lansia (60+)' => 0,
        ];
        foreach ($wargaAll as $w) {
            if ($w->tanggal_lahir) {
                $age = $w->tanggal_lahir->age;
                if ($age <= 5) $umur['Balita (0-5)']++;
                elseif ($age <= 12) $umur['Anak-anak (6-12)']++;
                elseif ($age <= 18) $umur['Remaja (13-18)']++;
                elseif ($age <= 59) $umur['Dewasa (19-59)']++;
                else $umur['Lansia (60+)']++;
            }
        }

        // 2. Hitung Pendidikan
        $pendidikan = Warga::selectRaw('pendidikan, count(*) as total')
            ->groupBy('pendidikan')
            ->pluck('total', 'pendidikan')
            ->toArray();

        // 3. Hitung Pekerjaan
        $pekerjaan = Warga::selectRaw('pekerjaan, count(*) as total')
            ->groupBy('pekerjaan')
            ->pluck('total', 'pekerjaan')
            ->toArray();

        // 4. Hitung Agama
        $agama = Warga::selectRaw('agama, count(*) as total')
            ->groupBy('agama')
            ->pluck('total', 'agama')
            ->toArray();

        // 5. Total Surat & Bantuan (Stats Cepat)
        $total_surat = \App\Models\Surat::count();
        $total_bantuan = \App\Models\BantuanSosial::count();

        $data = [
            'total_warga' => Warga::where('status_warga', 'Aktif')->count(),
            'total_kk' => KartuKeluarga::count(),
            'laki_laki' => Warga::where('status_warga', 'Aktif')->where('jenis_kelamin', 'Laki-laki')->count(),
            'perempuan' => Warga::where('status_warga', 'Aktif')->where('jenis_kelamin', 'Perempuan')->count(),
            'total_surat' => $total_surat,
            'total_bantuan' => $total_bantuan,
            'recent_citizens' => Warga::latest()->take(5)->get(),
            'recent_logs' => LogAktivitas::with('user')->latest()->take(5)->get(),
            // Chart data
            'chart_umur' => $umur,
            'chart_pendidikan' => $pendidikan,
            'chart_pekerjaan' => $pekerjaan,
            'chart_agama' => $agama,
        ];

        return view('dashboard', $data);
    }
}