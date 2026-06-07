# SurveyKita

SurveyKita adalah Portal Evaluasi Mahasiswa & Penjaminan Mutu Akademik yang dirancang untuk memfasilitasi pengumpulan umpan balik mahasiswa secara terstruktur, aman, dan efisien. Sistem ini membantu institusi akademik dalam memantau kualitas layanan, pembelajaran, dan fasilitas melalui instrumen evaluasi digital yang komprehensif.

## Fitur Utama

- **Otentikasi Ganda:** Masuk menggunakan akun lokal atau Google Workspace (OAuth).
- **Manajemen Identitas:** Pengisian profil mahasiswa otomatis berdasarkan parsing NIM.
- **Dashboard Operasional:** Ringkasan data real-time untuk mahasiswa dan administrator.
- **Instrumen Evaluasi Dinamis:** Pengelolaan periode, formulir, kategori, dan butir pertanyaan.
- **Analisis & Pelaporan:** Visualisasi hasil evaluasi dengan ApexCharts dan ekspor laporan ke format PDF dan Excel.

## Peran Pengguna

### 1. Mahasiswa (Mahasiswa)
- Melengkapi profil akademik (NIM, Program Studi, Angkatan, Kelas).
- Melihat daftar evaluasi aktif pada periode berjalan.
- Mengisi kuesioner evaluasi dengan skala Likert 1-5.
- Memberikan saran dan masukan tertulis.
- Memantau riwayat partisipasi pengisian.

### 2. Administrator (Admin)
- Mengelola data mahasiswa dan periode evaluasi.
- Menyusun instrumen survei (formulir, kategori, pertanyaan).
- Memantau tingkat partisipasi (cakupan pengisian).
- Menganalisis hasil kepuasan rata-rata dan distribusi skor.
- Mengunduh laporan hasil evaluasi untuk kepentingan akreditasi dan penjaminan mutu.

## Teknologi (Tech Stack)

- **Backend:** Laravel 13 (PHP 8.3+)
- **Frontend:** Laravel Blade, Tailwind CSS 4, Vite
- **Database:** MariaDB / MySQL
- **Otentikasi:** Laravel Socialite (Google OAuth)
- **Visualisasi:** ApexCharts
- **Ekspor Data:** DomPDF (PDF), Maatwebsite Excel (Excel)
- **Testing:** Pest PHP
- **Runtime/Package Manager:** Bun / Composer

## Persyaratan Sistem

- PHP >= 8.3
- Composer
- Bun (atau Node.js/NPM)
- Docker (Opsional, untuk MariaDB)
- MariaDB / MySQL Server

## Panduan Instalasi Lokal

1. **Clone Repository:**
   ```bash
   git clone <repository-url> surveykita
   cd surveykita
   ```

2. **Setup Environment:**
   ```bash
   cp .env.example .env
   # Edit .env dan sesuaikan koneksi database serta kredensial Google OAuth
   ```

3. **Instalasi Dependensi & Setup Database:**
   ```bash
   composer install
   bun install
   
   # Jalankan database (jika menggunakan Docker)
   docker compose up -d
   
   # Generate Key & Migrasi
   php artisan key:generate
   php artisan migrate --seed
   ```

4. **Build Aset Frontend:**
   ```bash
   bun run build
   ```

5. **Jalankan Aplikasi:**
   ```bash
   php artisan serve
   ```
   Buka `http://localhost:8000` di peramban Anda.

## Konfigurasi Google OAuth

Untuk mengaktifkan login dengan Google, pastikan Anda telah membuat kredensial di Google Cloud Console dan mengisi nilai berikut di `.env`:

```dotenv
GOOGLE_CLIENT_ID=your-client-id
GOOGLE_CLIENT_SECRET=your-client-secret
GOOGLE_REDIRECT_URI=${APP_URL}/auth/google/callback
```

## Akun Demo (Seeded)

Jika Anda menjalankan seeder, gunakan akun berikut untuk mencoba:

- **Admin:** `admin@surveykita.ac.id` (Password: `password`)
- **Mahasiswa:** `mahasiswa@surveykita.ac.id` (Password: `password`)

## Perintah Verifikasi

```bash
# Menjalankan seluruh test suite
php artisan test --compact

# Linting kode (Laravel Pint)
vendor/bin/pint

# Melihat daftar rute aktif
php artisan route:list --except-vendor
```

## Troubleshooting

- **App Key:** Pastikan `APP_KEY` terisi di `.env`. Jika belum, jalankan `php artisan key:generate`.
- **Database Connection:** Jika menggunakan Docker, pastikan port `3306` tersedia dan `DB_HOST` mengarah ke `127.0.0.1`.
- **Google Redirect URI:** Pastikan URI callback yang terdaftar di Google Cloud Console persis sama dengan `GOOGLE_REDIRECT_URI` di `.env`.
- **Vite Build:** Jika aset tidak muncul, pastikan telah menjalankan `bun run build`.
- **PDF/Excel Export:** Pastikan direktori `storage/app` memiliki izin tulis yang cukup.

## Struktur Proyek Utama

- `app/Http/Controllers/Student`: Logika alur mahasiswa.
- `app/Http/Controllers/Admin`: Logika manajemen administrator.
- `app/Models`: Definisi domain bisnis (EvaluationForm, Student, Response, dll).
- `app/Services`: Layanan perhitungan hasil dan charting.
- `resources/views/components/layouts`: Layout dasar aplikasi.
- `resources/views/components/ui`: Komponen UI reusable.

## Panduan Deployment (Produksi)

1. Pastikan `.env` disetel ke `APP_ENV=production` dan `APP_DEBUG=false`.
2. Gunakan web server (Nginx/Apache) dengan document root mengarah ke folder `public`.
3. Jalankan optimasi Laravel:
   ```bash
   php artisan optimize
   php artisan view:cache
   php artisan event:cache
   ```
4. Pastikan `GOOGLE_REDIRECT_URI` menggunakan HTTPS jika domain produksi menggunakan SSL.
5. Jalankan `bun run build` di lingkungan build sebelum deploy.

---
&copy; 2026 SurveyKita Team
