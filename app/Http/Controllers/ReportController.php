<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use App\Models\KartuKeluarga;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Hitung statistik per RT untuk Modul 10
        $query = Warga::join('kartu_keluarga', 'warga.kartu_keluarga_id', '=', 'kartu_keluarga.id')
            ->selectRaw('kartu_keluarga.rt, count(warga.id) as total_warga, sum(case when warga.jenis_kelamin = "Laki-laki" then 1 else 0 end) as total_l, sum(case when warga.jenis_kelamin = "Perempuan" then 1 else 0 end) as total_p')
            ->groupBy('kartu_keluarga.rt')
            ->orderBy('kartu_keluarga.rt');

        // Ketua RT hanya bisa melihat statistik RT miliknya sendiri
        if (auth()->user()->role === 'Ketua RT') {
            $query->where('kartu_keluarga.rt', auth()->user()->rt_rw);
        }

        $rtStats = $query->get();

        return view('laporan.index', compact('rtStats'));
    }

    public function downloadTemplate()
    {
        if (!in_array(auth()->user()->role, ['Super Admin', 'Operator Desa'])) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengunduh template impor.');
        }
        $headers = [
            'NIK', 'Nama Lengkap', 'Nomor KK', 'Jenis Kelamin', 'Tempat Lahir', 
            'Tanggal Lahir', 'Agama', 'Pendidikan', 'Pekerjaan', 
            'Status Perkawinan', 'Hubungan Keluarga', 'Alamat', 'Nomor Telepon'
        ];

        $callback = function() use ($headers) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $headers);
            // Contoh baris
            fputcsv($file, [
                '6409011234567890', 'Budi Santoso', '6409019999999999', 'Laki-laki', 'Penajam', 
                '1995-08-20', 'Islam', 'D3 / S1 / S2', 'PNS / Swasta', 
                'Belum Kawin', 'Anak', 'Dusun Makmur RT 001', '081234567890'
            ]);
            fclose($file);
        };

        return response()->streamDownload($callback, 'template_impor_warga.csv', [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="template_impor_warga.csv"',
        ]);
    }

    public function previewImport(Request $request)
    {
        if (!in_array(auth()->user()->role, ['Super Admin', 'Operator Desa'])) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengimpor data.');
        }
        $request->validate([
            'file_csv' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        $file = $request->file('file_csv');
        $path = $file->getRealPath();
        
        $handle = fopen($path, 'r');
        $headers = fgetcsv($handle); // Baca header

        $rows = [];
        $isValidAll = true;

        while (($data = fgetcsv($handle)) !== false) {
            if (count($data) < 12) continue; // Skip jika data kurang

            $nik = trim($data[0]);
            $nama = trim($data[1]);
            $nomor_kk = trim($data[2]);
            $jenis_kelamin = trim($data[3]);
            $tempat_lahir = trim($data[4]);
            $tanggal_lahir = trim($data[5]);
            $agama = trim($data[6]);
            $pendidikan = trim($data[7]);
            $pekerjaan = trim($data[8]);
            $status_perkawinan = trim($data[9]);
            $hubungan_keluarga = trim($data[10]);
            $alamat = trim($data[11]);
            $nomor_telepon = isset($data[12]) ? trim($data[12]) : '';

            $errors = [];

            // Validasi NIK
            if (strlen($nik) !== 16) {
                $errors[] = 'NIK harus 16 digit.';
            } elseif (!ctype_digit($nik)) {
                $errors[] = 'NIK tidak boleh mengandung huruf.';
            } else {
                // Cek ganda di database
                if (Warga::where('nik', $nik)->exists()) {
                    $errors[] = 'NIK sudah terdaftar di database.';
                }
            }

            // Cek KK
            $kk = null;
            if (strlen($nomor_kk) !== 16) {
                $errors[] = 'Nomor KK harus 16 digit.';
            } elseif (!ctype_digit($nomor_kk)) {
                $errors[] = 'Nomor KK tidak boleh mengandung huruf.';
            } else {
                $kk = KartuKeluarga::where('nomor_kk', $nomor_kk)->first();
                if (!$kk) {
                    $errors[] = "No. KK {$nomor_kk} belum terdaftar di database. Silakan buat KK terlebih dahulu.";
                }
            }

            // Validasi Jenis Kelamin
            if (!in_array($jenis_kelamin, ['Laki-laki', 'Perempuan'])) {
                $errors[] = 'Jenis Kelamin harus Laki-laki atau Perempuan.';
            }

            if (empty($nama)) $errors[] = 'Nama Lengkap wajib diisi.';
            if (empty($tanggal_lahir) || !strtotime($tanggal_lahir)) $errors[] = 'Tanggal Lahir kosong atau format salah (Harus YYYY-MM-DD).';

            $rows[] = [
                'nik' => $nik,
                'nama_lengkap' => $nama,
                'nomor_kk' => $nomor_kk,
                'kartu_keluarga_id' => $kk ? $kk->id : null,
                'jenis_kelamin' => $jenis_kelamin,
                'tempat_lahir' => $tempat_lahir,
                'tanggal_lahir' => $tanggal_lahir,
                'agama' => $agama,
                'pendidikan' => $pendidikan,
                'pekerjaan' => $pekerjaan,
                'status_perkawinan' => $status_perkawinan,
                'hubungan_keluarga' => $hubungan_keluarga,
                'alamat' => $alamat,
                'nomor_telepon' => $nomor_telepon,
                'errors' => $errors,
                'status' => empty($errors) ? 'Valid' : 'Error',
            ];

            if (!empty($errors)) {
                $isValidAll = false;
            }
        }
        fclose($handle);

        // Simpan data preview ke session
        session(['preview_import_data' => $rows]);

        return view('laporan.preview', compact('rows', 'isValidAll'));
    }

    public function importWarga()
    {
        if (!in_array(auth()->user()->role, ['Super Admin', 'Operator Desa'])) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengimpor data.');
        }
        $rows = session('preview_import_data');

        if (!$rows) {
            return redirect()->route('laporan.index')->with('error', 'Tidak ada data untuk diimpor.');
        }

        $importedCount = 0;
        foreach ($rows as $row) {
            if ($row['status'] === 'Valid') {
                Warga::create([
                    'kartu_keluarga_id' => $row['kartu_keluarga_id'],
                    'nik' => $row['nik'],
                    'nama_lengkap' => $row['nama_lengkap'],
                    'jenis_kelamin' => $row['jenis_kelamin'],
                    'tempat_lahir' => $row['tempat_lahir'],
                    'tanggal_lahir' => $row['tanggal_lahir'],
                    'agama' => $row['agama'],
                    'pendidikan' => $row['pendidikan'],
                    'pekerjaan' => $row['pekerjaan'],
                    'status_perkawinan' => $row['status_perkawinan'],
                    'hubungan_keluarga' => $row['hubungan_keluarga'],
                    'alamat' => $row['alamat'],
                    'nomor_telepon' => $row['nomor_telepon'],
                    'status_warga' => 'Aktif',
                ]);
                $importedCount++;
            }
        }

        LogAktivitas::catat("Mengimpor {$importedCount} data warga dari berkas CSV");

        // Hapus session
        session()->forget('preview_import_data');

        return redirect()->route('warga.index')->with('success', "Berhasil mengimpor {$importedCount} data warga.");
    }

    public function exportWarga(Request $request)
    {
        $query = Warga::with('kartuKeluarga');

        // Ketua RT hanya bisa mengekspor warga dari RT miliknya sendiri
        if (auth()->user()->role === 'Ketua RT') {
            $query->whereHas('kartuKeluarga', fn($q) => $q->where('rt', auth()->user()->rt_rw));
        } else {
            // Filter RT/RW
            if ($request->filled('rt')) {
                $query->whereHas('kartuKeluarga', fn($q) => $q->where('rt', $request->rt));
            }
            if ($request->filled('rw')) {
                $query->whereHas('kartuKeluarga', fn($q) => $q->where('rw', $request->rw));
            }
        }
        // Filter Jenis Kelamin
        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        $wargaList = $query->get();

        $callback = function() use ($wargaList) {
            $file = fopen('php://output', 'w');
            
            // Header
            fputcsv($file, [
                'NIK', 'Nama Lengkap', 'Nomor KK', 'Jenis Kelamin', 'Tempat Lahir', 
                'Tanggal Lahir', 'Agama', 'Pendidikan', 'Pekerjaan', 
                'Status Perkawinan', 'Hubungan Keluarga', 'Alamat', 'Nomor Telepon', 'Status Warga'
            ]);

            foreach ($wargaList as $w) {
                fputcsv($file, [
                    $w->nik,
                    $w->nama_lengkap,
                    $w->kartuKeluarga ? $w->kartuKeluarga->nomor_kk : '',
                    $w->jenis_kelamin,
                    $w->tempat_lahir,
                    $w->tanggal_lahir ? $w->tanggal_lahir->format('Y-m-d') : '',
                    $w->agama,
                    $w->pendidikan,
                    $w->pekerjaan,
                    $w->status_perkawinan,
                    $w->hubungan_keluarga,
                    $w->alamat,
                    $w->nomor_telepon,
                    $w->status_warga,
                ]);
            }
            fclose($file);
        };

        LogAktivitas::catat("Mengekspor data warga ke berkas CSV");

        return response()->streamDownload($callback, 'data_warga_desa_itci.csv', [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="data_warga_desa_itci.csv"',
        ]);
    }
}
