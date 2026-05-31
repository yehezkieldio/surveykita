# SurveyKita

SurveyKita adalah Sistem Informasi Evaluasi Kepuasan Mahasiswa terhadap
Layanan Akademik Berbasis Web Menggunakan Laravel untuk konteks Universitas
Mulia. Aplikasi ini menyediakan autentikasi kustom, role admin dan mahasiswa,
login Google khusus email mahasiswa, manajemen data evaluasi, alur pengisian
Likert 1-5, dashboard hasil, grafik, ekspor PDF, ekspor Excel, seed data, dan
Pest tests.

## Stack

- PHP 8.3 atau lebih baru
- Laravel 13
- Laravel Blade dan Tailwind CSS
- Bun, Vite
- MariaDB via Docker Compose
- Laravel Socialite
- akaunting/laravel-apexcharts
- barryvdh/laravel-dompdf
- maatwebsite/excel
- Pest

## Larangan Stack

Project ini tidak menggunakan Breeze, Jetstream, Laravel UI, Filament, Nova,
Backpack, Bootstrap, React, Vue, Inertia, Livewire, SQLite sebagai database
local utama, npm, yarn, atau pnpm.

## Setup Fresh Clone

```bash
composer install
bun install
docker compose up -d
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
bun run build
php artisan test
php artisan route:list --except-vendor
```

Jalankan server lokal:

```bash
php artisan serve --host=127.0.0.1 --port=8000
```

Buka:

```text
http://127.0.0.1:8000/login
```

## Konfigurasi Environment

Nilai default local development memakai MariaDB dari `docker-compose.yml`:

```dotenv
APP_URL=http://localhost:8000

DB_CONNECTION=mariadb
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=surveykita
DB_USERNAME=surveykita
DB_PASSWORD=surveykita

GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
GOOGLE_REDIRECT_URI="${APP_URL}/auth/google/callback"
```

Google OAuth harus memakai callback route yang diimplementasikan:

```text
http://localhost:8000/auth/google/callback
```

Jika browser verification tidak dapat menyelesaikan login Google karena consent
screen, MFA, CAPTCHA, atau akun mahasiswa Universitas Mulia tidak tersedia,
gunakan akun password mahasiswa hasil seeder. Perilaku domain Google tetap
ditutup oleh Pest test dengan Socialite fake.

## Demo Accounts

Password semua akun seed berikut adalah:

```text
password
```

Admin:

```text
admin@universitasmulia.ac.id
```

Mahasiswa seeded:

```text
2311032@students.universitasmulia.ac.id
2312045@students.universitasmulia.ac.id
2313056@students.universitasmulia.ac.id
2321078@students.universitasmulia.ac.id
2322091@students.universitasmulia.ac.id
2333014@students.universitasmulia.ac.id
2351025@students.universitasmulia.ac.id
2353036@students.universitasmulia.ac.id
```

Contoh parsing NIM `2311032`:

- `23`: tahun masuk 2023
- `11`: S1 Informatika
- `032`: nomor urut mahasiswa

## Fitur Utama

Admin dapat:

- login dan logout
- mengelola mahasiswa, periode evaluasi, form evaluasi, kategori, dan
  pertanyaan
- mengaktifkan dan menonaktifkan periode dan form
- melihat dashboard hasil evaluasi
- memfilter hasil berdasarkan periode, form, dan kategori
- melihat grafik persentase kepuasan, jumlah responden, rata-rata kategori, dan
  distribusi Likert
- mengunduh laporan PDF dan Excel
- melihat saran mahasiswa

Mahasiswa dapat:

- login dengan email/password dari admin
- login dengan Google khusus domain `@students.universitasmulia.ac.id`
- melengkapi profil mahasiswa
- melihat form evaluasi aktif
- mengisi evaluasi Likert 1-5
- mengirim saran opsional
- melihat status form yang sudah dikirim
- melihat riwayat pengisian

## Aturan Evaluasi

- Form hanya dapat diisi jika form aktif, periode aktif, dan tanggal hari ini
  berada di antara `start_date` dan `end_date` secara inklusif.
- Mahasiswa hanya dapat mengirim satu respons per `evaluation_form_id`.
- Skor wajib bernilai integer 1 sampai 5.
- Pertanyaan wajib harus dijawab.
- Mahasiswa dengan profil belum lengkap tidak dapat mengirim evaluasi.
- Dashboard tanpa respons harus menampilkan ringkasan nol dan empty state,
  bukan error.

## Verification Commands

Gunakan perintah ini sebelum menganggap perubahan selesai:

```bash
vendor/bin/pint --dirty --format agent
php artisan test --compact
bun run build
php artisan route:list --except-vendor
```

Verifikasi fresh database:

```bash
docker compose up -d
php artisan migrate:fresh --seed
php artisan test --compact
```

## Agent Browser E2E

Setelah migrasi, seeding, build, dan Pest test pass, jalankan browser E2E dengan
`agent-browser`.

```bash
agent-browser skills get core
php artisan serve --host=127.0.0.1 --port=8000
agent-browser open http://127.0.0.1:8000/login
agent-browser snapshot -i
```

Browser workflow yang harus diverifikasi:

- admin login, dashboard admin, navigasi CRUD, hasil, grafik, ekspor PDF,
  ekspor Excel, dan logout
- mahasiswa login, profil, daftar evaluasi aktif, detail form, submit evaluasi,
  success page, duplicate submission feedback, riwayat, dan logout
- wrong-role access menampilkan feedback aman
- satu empty state hasil evaluasi tampil tanpa error

Ambil screenshot atau snapshot untuk dashboard admin, grafik hasil, halaman isi
evaluasi, success page, duplicate feedback, dan wrong-role feedback. Setelah
selesai, bersihkan proses browser milik task:

```bash
agent-browser close --all
pgrep -af "agent-browser|chrome|chromium" || true
```

## Unattended Autonomous Execution

Untuk sesi implementasi long-horizon tanpa human-in-the-loop, Codex boleh
melakukan hal berikut secara non-interaktif:

- install dependency Composer dan Bun yang sudah disetujui
- menjalankan Docker Compose, Laravel server, Vite build, Pest, route list, dan
  `agent-browser`
- reset dan seed database local MariaDB
- mengambil screenshot atau snapshot sebagai bukti verifikasi
- memperbaiki kegagalan gate secara terarah
- menjalankan ulang gate paling kecil yang gagal, lalu full verification
- commit setiap slice kerja dengan Conventional Commit yang mereferensikan atau
  menutup GitHub Issue terkait
- push commit agar issue tracker merefleksikan progres
- membersihkan proses server/browser yang dimiliki task sebelum selesai

Stop hanya jika dependency yang wajib tidak dapat dipasang, kredensial external
yang benar-benar human-only diperlukan, database local tidak dapat dijalankan
setelah perbaikan wajar, atau acceptance criteria tidak dapat dipenuhi tanpa
mengubah konstitusi/spec.
