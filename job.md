# Konsep Lengkap Sistem Pengelolaan Data Warga Desa

Bayangkan website ini seperti “pusat administrasi digital desa”.

Semua data warga, surat, bantuan, dan arsip tersimpan dalam satu sistem sehingga perangkat desa tidak lagi memakai Excel manual.

---

# TUJUAN WEBSITE

Tujuan utama:

* Menggantikan Excel manual
* Mempercepat pencarian data warga
* Mempermudah pembuatan surat
* Mengurangi data hilang
* Membuat administrasi desa modern
* Bisa dipakai offline di kantor desa

---

# GAMBARAN BESAR ALUR WEBSITE

## Alur Utama Sistem

```text id="swl97v"
Login
 ↓
Dashboard
 ↓
Kelola Data Warga
 ↓
Kelola KK
 ↓
Cetak Surat
 ↓
Export Laporan
 ↓
Arsip & Backup
```

---

# SIAPA YANG MENGGUNAKAN?

# 1. Super Admin

Biasanya:

* Kepala IT
* Pembuat sistem

Hak akses:

* Semua fitur
* Kelola akun
* Backup database
* Pengaturan sistem

---

# 2. Operator Desa

Biasanya:

* Staff kantor desa
* Pengurus stasi

Hak akses:

* Input warga
* Edit data
* Cetak surat
* Import Excel

---

# 3. Ketua RT/RW

Hak akses:

* Lihat warga RT sendiri
* Cetak laporan RT
* Tidak bisa hapus data

---

# 4. Kepala Desa

Hak akses:

* Melihat statistik
* Approve surat
* Monitoring

---

# STRUKTUR WEBSITE

Website dibagi menjadi:

## A. Website Publik

Untuk masyarakat umum.

Route:

```text id="9p9h6x"
/
```

---

## B. Dashboard Admin

Untuk perangkat desa.

Route:

```text id="4qgg5g"
/dashboard
```

---

# A. WEBSITE PUBLIK

# HALAMAN HOME

Isi:

* Sambutan kepala desa
* Statistik warga
* Berita desa
* Informasi desa
* Kontak

---

# HALAMAN PROFIL DESA

Isi:

* Sejarah desa
* Visi misi
* Struktur organisasi
* Peta desa

---

# HALAMAN BERITA

Isi:

* Pengumuman
* Kegiatan desa
* Event

---

# HALAMAN STATISTIK

Menampilkan:

* Jumlah warga
* Jumlah KK
* Pendidikan
* Agama
* Pekerjaan

Pakai:

* Chart.js

---

# HALAMAN CEK SURAT

Masyarakat bisa:

* Scan QR surat
* Cek keaslian surat

---

# B. DASHBOARD ADMIN

Ini inti sistem.

---

# HALAMAN LOGIN

Fitur:

* Email/username
* Password
* Remember me

Keamanan:

* Hash password
* Middleware auth

---

# DASHBOARD UTAMA

Saat login tampil:

## Statistik Cepat

Card:

* Total warga
* Total KK
* Surat bulan ini
* Warga laki-laki
* Warga perempuan

---

## Grafik

Contoh:

* Grafik umur
* Grafik pendidikan
* Grafik pekerjaan

---

## Aktivitas Terbaru

Contoh:

```text id="2p4gk6"
Admin menambah warga
Operator membuat surat
```

---

# MENU DASHBOARD

Sidebar kiri:

```text id="vj5gbi"
Dashboard
Data Warga
Kartu Keluarga
Surat
Bantuan Sosial
Pendatang
Arsip Dokumen
Statistik
Laporan
Pengguna
Pengaturan
Backup
Logout
```

---

# MODUL 1 — DATA WARGA

Ini modul utama.

---

# HALAMAN LIST WARGA

Tampilan:

* Tabel data

Kolom:

* NIK
* Nama
* KK
* Jenis kelamin
* RT/RW
* Aksi

---

# FITUR LIST WARGA

## Search realtime

Cari:

* Nama
* NIK
* KK

---

## Filter

* RT
* RW
* Umur
* Agama
* Pendidikan

---

## Pagination

Karena data bisa ribuan.

---

# TAMBAH WARGA

Form input:

## Data Pribadi

* NIK
* Nama lengkap
* Tempat lahir
* Tanggal lahir
* Jenis kelamin
* Agama

---

## Data Sosial

* Pendidikan
* Pekerjaan
* Status kawin

---

## Data Kontak

* Nomor HP
* Alamat

---

## Data Keluarga

* Nomor KK
* Hubungan keluarga

---

## Upload

* Foto
* KTP
* KK

---

# VALIDASI WAJIB

## NIK unik

## Nomor KK valid

## Upload file aman

---

# DETAIL WARGA

Menampilkan:

* Biodata lengkap
* Riwayat surat
* Riwayat bantuan
* Dokumen

---

# EDIT WARGA

Operator bisa:

* Mengubah data
* Mengganti foto
* Memperbaiki typo

---

# HAPUS WARGA

Jangan hard delete.

Gunakan:

```text id="g4j5bz"
soft delete
```

Supaya data masih bisa dipulihkan.

---

# MODUL 2 — KARTU KELUARGA

---

# LIST KK

Kolom:

* Nomor KK
* Kepala keluarga
* Jumlah anggota
* RT/RW

---

# DETAIL KK

Isi:

* Kepala keluarga
* Semua anggota
* Alamat lengkap

---

# RELASI DATABASE

1 KK:

```text id="w32icm"
hasMany warga
```

---

# MODUL 3 — IMPORT EXCEL

Sangat penting.

---

# ALUR IMPORT

```text id="10nnl0"
Download Template
 ↓
Isi Excel
 ↓
Upload
 ↓
Validasi
 ↓
Import
```

---

# VALIDASI IMPORT

Cek:

* NIK ganda
* Data kosong
* Format salah

---

# FITUR BAGUS

## Preview sebelum simpan

Jadi operator bisa cek dulu.

---

# MODUL 4 — EXPORT DATA

Export:

* Excel
* CSV
* PDF

---

# FILTER EXPORT

Contoh:

* Semua warga
* RT tertentu
* Umur tertentu

---

# MODUL 5 — SURAT OTOMATIS

Ini fitur paling dipakai.

---

# ALUR PEMBUATAN SURAT

```text id="bf1q86"
Cari Warga
 ↓
Pilih Jenis Surat
 ↓
Isi Keperluan
 ↓
Generate PDF
 ↓
Cetak
```

---

# JENIS SURAT

* Domisili
* Kelahiran
* Kematian
* Usaha
* Tidak mampu
* Pindah

---

# FITUR CERDAS

## Auto isi data warga

Tidak perlu ketik ulang.

---

## Nomor surat otomatis

Contoh:

```text id="f1wpzj"
001/DS-ITCI/V/2026
```

---

## QR Verification

QR menuju:

```text id="g6gc2h"
/verify/surat/123
```

---

# DETAIL SURAT

Menampilkan:

* Data warga
* Jenis surat
* File PDF
* Tanggal dibuat

---

# MODUL 6 — BANTUAN SOSIAL

---

# DATA BANTUAN

Contoh:

* BLT
* PKH
* Sembako

---

# FITUR

## Cari penerima bantuan

## Riwayat bantuan warga

## Statistik bantuan

---

# MODUL 7 — PENDATANG & PINDAH

Tracking:

* Pendatang baru
* Warga pindah
* Warga meninggal

---

# MODUL 8 — ARSIP DOKUMEN

Upload:

* KTP
* KK
* Akta lahir

---

# FITUR

## Preview dokumen

## Download dokumen

## Kategori dokumen

---

# MODUL 9 — STATISTIK

Menampilkan grafik:

* Umur
* Agama
* Pendidikan
* Pekerjaan
* Gender

---

# MODUL 10 — LAPORAN

Generate laporan:

* Bulanan
* Tahunan
* Per RT

---

# MODUL 11 — USER MANAGEMENT

Admin bisa:

* Tambah akun
* Atur role
* Reset password

---

# MODUL 12 — BACKUP

Fitur:

* Backup database
* Download backup

---

# MODUL 13 — LOG AKTIVITAS

Mencatat:

* Siapa login
* Siapa edit data
* Siapa hapus data

---

# STRUKTUR DATABASE RELASI

## users

Untuk login.

---

## families

Untuk KK.

---

## citizens

Data warga.

Relasi:

```text id="swhdh9"
citizen belongsTo family
```

---

## letters

Data surat.

Relasi:

```text id="ocofon"
letter belongsTo citizen
```

---

## documents

Dokumen warga.

---

## social_assistance

Data bantuan.

---

# FLOW DATABASE

```text id="fe1i5n"
KK
 ↓
Warga
 ↓
Surat
 ↓
Dokumen
 ↓
Bantuan
```

---

# KEAMANAN SISTEM

# WAJIB

## Middleware role

## Validasi upload file

## CSRF protection

## Hash password

## Backup otomatis

## Soft delete

---

# MODE OFFLINE

Sangat cocok untuk desa.

---

# CARA KERJA

## 1 komputer server

Menjalankan:

* Apache/Nginx
* MySQL
* Laravel

---

## Komputer lain akses lewat WiFi

Contoh:

```text id="dkp6wn"
192.168.1.10
```

---

# UI YANG DISARANKAN

## Standar Tampilan (Clean & Professional)
Agar dashboard nyaman digunakan dalam waktu lama:
* **Background Utama**: Abu-abu sangat muda (`#f8f9fa`) atau Putih (`#ffffff`).
* **Teks**: Gunakan warna gelap (`#333333` atau `#212529`) untuk keterbacaan maksimal. **Hindari teks putih di atas background terang.**
* **Tabel**:
    * Gunakan style `table-hover` (baris berubah warna saat kursor di atasnya).
    * Header tabel warna abu-abu muda (`table-light`).
    * Border tipis dan halus.
* **Alert/Notifikasi**:
    * Cukup muncul satu kali di pojok kanan atas (*Toast style*) atau di bawah Navbar.
    * Harus memiliki fitur *Auto-close* (Timer 3-5 detik).
    * Warna hijau untuk sukses, merah untuk error.

## Warna:

* Hijau
* Putih
* Biru

Karena identik pemerintahan.

---

# STYLE DASHBOARD

Gunakan:

* Sidebar kiri
* Navbar atas
* Card statistik
* Table modern

---

# STRUKTUR PEMBUATAN PROJECT

# Tahap 1

Authentication

---

# Tahap 2

CRUD warga & KK

---

# Tahap 3

Import/export

---

# Tahap 4

Generator surat

---

# Tahap 5

Statistik

---

# Tahap 6

Statistik & Laporan (PDF/Excel)

# Tahap 7

Arsip & Backup

---

# DETAIL IMPLEMENTASI TEKNIS

## Tech Stack

* **Framework**: Laravel 11+
* **Database**: MySQL / MariaDB
* **Frontend**: Bootstrap 5 (Udah bawaan Laravel UI/Breeze)
* **Icons**: Bootstrap Icons atau FontAwesome
* **Charts**: Chart.js
* **Excel**: Laravel Excel (Maatwebsite)
* **PDF**: DomPDF atau Snappy

---

# STRATEGI DEPLOYMENT OFFLINE (LAN)

Karena ditujukan untuk kantor desa dengan akses internet terbatas:

1. **Server Lokal**: Satu PC dijadikan server (Install XAMPP/Laragon).
2. **Akses Client**: Laptop staff lain mengakses via IP Address (contoh: `http://192.168.1.10:8000`).
3. **Optimalisasi**:
    * Gunakan `php artisan serve --host=0.0.0.0` agar bisa diakses di jaringan lokal.
    * Asset (CSS/JS) harus tersimpan lokal (bukan CDN) agar tampilan tidak rusak saat offline.

---

# DAFTAR PENGUJIAN (CHECKLIST)

Sebelum dianggap selesai, setiap modul harus lulus tes:

## 1. Keamanan
* [ ] User non-admin tidak bisa buka menu Pengguna.
* [ ] Input NIK tidak boleh huruf.
* [ ] Session otomatis logout jika idle terlalu lama.

## 2. Validitas Data
* [ ] NIK tidak boleh duplikat.
* [ ] Umur otomatis terhitung dari tanggal lahir.
* [ ] Saat warga dihapus (soft delete), data KK tetap aman.

## 3. Performa
* [ ] Loading data 1000+ warga tetap cepat (Gunakan pagination).
* [ ] Pencarian nama berfungsi secara instan.

---

# PEMELIHARAAN (MAINTENANCE)

1. **Backup Mingguan**: Admin wajib mengunduh SQL backup setiap hari Jumat.
2. **Log Clean-up**: Log aktivitas yang sudah lebih dari 3 bulan otomatis dihapus atau diarsipkan untuk menjaga ukuran database.
3. **Update Data**: Verifikasi data warga setiap 6 bulan sekali (Sinkronisasi dengan data pusat/Dukcapil jika memungkinkan).

---

# LOG PERUBAHAN (CHANGELOG)

* **v1.0.0**: Inisiasi proyek, setup auth, dan desain database awal.
* **v1.1.0**: Perbaikan UI Dashboard (Fix kontras warna tabel & font) dan sistem notifikasi single-alert dengan timer.
* **v1.2.0**: Implementasi fitur Backup Database manual (.sql) dan perbaikan error View Not Found pada modul backup.
* **v1.2.0**: Implementasi fitur Backup Database manual (.sql), perbaikan error View Not Found pada modul backup, dan standardisasi penamaan view folder.

---

# Saran Penting

**Jangan langsung membuat semua fitur sekaligus.**

Mulai dari:

1. Login
2. CRUD warga
3. CRUD KK
4. Surat otomatis

Karena itu inti sistem administrasi desa.
Selalu gunakan **Git** untuk version control agar jika ada error tampilan seperti sebelumnya, Anda bisa melakukan *rollback* dengan mudah.
