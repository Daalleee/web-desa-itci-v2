<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\KartuKeluarga;
use App\Models\Warga;
use App\Models\BantuanSosial;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Users (Pengguna Desa)
        User::create([
            'name' => 'Kepala IT Desa',
            'username' => 'admin',
            'email' => 'admin@desaitci.gov',
            'password' => Hash::make('admin123'),
            'role' => 'Super Admin',
        ]);

        User::create([
            'name' => 'Staf Kantor Desa (Budi)',
            'username' => 'operator',
            'email' => 'budi@desaitci.gov',
            'password' => Hash::make('operator123'),
            'role' => 'Operator Desa',
        ]);

        User::create([
            'name' => 'Ketua RT 001 (Pak Joko)',
            'username' => 'rt01',
            'email' => 'joko@desaitci.gov',
            'password' => Hash::make('rt123'),
            'role' => 'Ketua RT',
            'rt_rw' => '001',
        ]);

        User::create([
            'name' => 'Kepala Desa ITCI (Pak H. Salim)',
            'username' => 'kades',
            'email' => 'salim@desaitci.gov',
            'password' => Hash::make('kades123'),
            'role' => 'Kepala Desa',
        ]);

        // 2. Seed Kartu Keluarga (KK)
        $kk1 = KartuKeluarga::create([
            'nomor_kk' => '6409012205090001',
            'kepala_keluarga' => 'Supriadi',
            'alamat' => 'RT 001 Dusun Harapan, Desa ITCI',
            'rt' => '001',
            'rw' => '001',
        ]);

        $kk2 = KartuKeluarga::create([
            'nomor_kk' => '6409012205090002',
            'kepala_keluarga' => 'Kartini',
            'alamat' => 'RT 002 Dusun Makmur, Desa ITCI',
            'rt' => '002',
            'rw' => '001',
        ]);

        // 3. Seed Warga
        $warga1 = Warga::create([
            'kartu_keluarga_id' => $kk1->id,
            'nik' => '6409011203850001',
            'nama_lengkap' => 'Supriadi',
            'tempat_lahir' => 'Penajam',
            'tanggal_lahir' => '1985-03-12',
            'jenis_kelamin' => 'Laki-laki',
            'agama' => 'Islam',
            'pendidikan' => 'SMA / Sederajat',
            'pekerjaan' => 'Petani / Pekebun',
            'status_perkawinan' => 'Kawin',
            'hubungan_keluarga' => 'Kepala Keluarga',
            'nomor_telepon' => '081234567890',
            'alamat' => 'RT 001 Dusun Harapan, Desa ITCI',
            'status_warga' => 'Aktif',
        ]);

        $warga2 = Warga::create([
            'kartu_keluarga_id' => $kk1->id,
            'nik' => '6409015507900001',
            'nama_lengkap' => 'Sumarni',
            'tempat_lahir' => 'Balikpapan',
            'tanggal_lahir' => '1990-07-15',
            'jenis_kelamin' => 'Perempuan',
            'agama' => 'Islam',
            'pendidikan' => 'SMA / Sederajat',
            'pekerjaan' => 'Mengurus Rumah Tangga',
            'status_perkawinan' => 'Kawin',
            'hubungan_keluarga' => 'Istri',
            'nomor_telepon' => '081234567891',
            'alamat' => 'RT 001 Dusun Harapan, Desa ITCI',
            'status_warga' => 'Aktif',
        ]);

        $warga3 = Warga::create([
            'kartu_keluarga_id' => $kk2->id,
            'nik' => '6409016104780002',
            'nama_lengkap' => 'Kartini',
            'tempat_lahir' => 'Samarinda',
            'tanggal_lahir' => '1978-04-21',
            'jenis_kelamin' => 'Perempuan',
            'agama' => 'Kristen',
            'pendidikan' => 'Diploma III',
            'pekerjaan' => 'PNS / Pegawai Swasta',
            'status_perkawinan' => 'Cerai Mati',
            'hubungan_keluarga' => 'Kepala Keluarga',
            'nomor_telepon' => '081399887766',
            'alamat' => 'RT 002 Dusun Makmur, Desa ITCI',
            'status_warga' => 'Aktif',
        ]);

        // 4. Seed Bantuan Sosial
        $blt = BantuanSosial::create([
            'nama_program' => 'BLT Dana Desa 2026',
            'keterangan' => 'Bantuan Langsung Tunai untuk Warga Terdampak Ekonomi',
            'nominal' => 300000,
            'tanggal_penyaluran' => '2026-05-01',
        ]);

        $pkh = BantuanSosial::create([
            'nama_program' => 'Program Keluarga Harapan (PKH)',
            'keterangan' => 'Bantuan Pendidikan dan Kesehatan Keluarga',
            'nominal' => 750000,
            'tanggal_penyaluran' => '2026-04-15',
        ]);

        // 5. Relasi Penerima Bantuan
        $warga1->bantuanSosial()->attach($blt->id, ['tanggal_terima' => '2026-05-02']);
        $warga3->bantuanSosial()->attach($pkh->id, ['tanggal_terima' => '2026-04-16']);
    }
}
