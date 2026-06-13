# Srawung — Platform Komunitas Lokal Jember

Platform mikro sosial media berbasis komunitas lokal Jember.
PHP 8.3 + Laravel 11 + MySQL

---

## Fitur Lengkap

- Register & Login (Email/Password + Google OAuth)
- Mode Publik / Anonim — post anonim TIDAK tampil di profil
- Feed: Like, Komentar, Repost
- Follow/Unfollow — klik nama di panel kanan buka profil
- Daftar Pengikut & Mengikuti (klik → buka list)
- Thread Lokal — wajib aktifkan GPS, post hanya tampil radius tertentu
- Hidden Gem + upload foto
- DM / Chat antar pengguna
- Upload foto profil
- **Srawung Ketemu** — check-in lokasi, lihat warga sekitar, ajak ngopi
- Fully Responsive (mobile + desktop)
- UI elegant — bukan Twitter clone

---

## Setup di Laragon (PHP 8.3)

### 1. Taruh folder
```
C:\laragon\www\srawung\
```

### 2. Buka Terminal Laragon, install dependencies
```bash
cd C:\laragon\www\srawung
composer install
```

### 3. Setup .env
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Edit .env — sesuaikan database & Google OAuth
```
DB_DATABASE=srawung
DB_USERNAME=root
DB_PASSWORD=

GOOGLE_CLIENT_ID=ISI_DENGAN_CLIENT_ID_KAMU
GOOGLE_CLIENT_SECRET=ISI_DENGAN_CLIENT_SECRET_KAMU
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

### 5. Buat database di phpMyAdmin
Buka `http://localhost/phpmyadmin` → New → nama: `srawung` → Create

### 6. Migrasi & seeder
```bash
php artisan migrate --seed
php artisan storage:link
```

### 7. Jalankan
```bash
php artisan serve
```
Buka: **http://localhost:8000**

---

## Akun Demo (setelah seed)

| Email | Password | Mode |
|---|---|---|
| budi_s@demo.com | password | Publik |
| siti_a@demo.com | password | Publik |
| rina_k@demo.com | password | Publik |
| ahmad_f@demo.com | password | Anonim |

---

## Setup Google OAuth

1. Buka https://console.cloud.google.com
2. Buat project → APIs & Services → Credentials
3. Create OAuth 2.0 Client ID → Web Application
4. Authorized redirect URIs: `http://localhost:8000/auth/google/callback`
5. Copy Client ID & Secret ke `.env`

---

## Fitur Srawung Ketemu

1. Buka menu **Srawung Ketemu**
2. Klik **Aktifkan Lokasi** — browser akan minta izin GPS
3. Setelah check-in, kamu terlihat oleh warga dalam radius 10 km
4. Klik **Ajak Ketemu** pada user yang online
5. Tulis pesan & saran tempat (misal: "Ngopi di Warkop Pak Bejo?")
6. Target user terima notifikasi dan bisa Accept/Decline
7. Jika diterima, lanjutkan chat via fitur Pesan

---

## Struktur Project

```
app/Http/Controllers/   → 12 controller
app/Models/             → User, Post, Comment, Like, Follow,
                          Message, Location, UserCheckin, MeetupRequest
database/migrations/    → 4 file migration
database/seeders/       → DatabaseSeeder (data demo)
resources/views/        → 20+ Blade template
  layouts/app.blade.php → Layout utama sidebar
  auth/                 → login, register, pilih-mode
  dashboard/            → index (feed), lokal (thread lokal)
  posts/                → create, show, _card
  profile/              → show, edit, user-list
  locations/            → index, create, show
  messages/             → index, show
  ketemu/               → index (Srawung Ketemu)
routes/web.php          → Semua routing
config/                 → app, auth, database, filesystems,
                          services (Google), session
```

---

## Deploy ke Hosting

1. Upload semua file (kecuali `vendor/`, `.env`)
2. Jalankan `composer install --no-dev --optimize-autoloader`
3. Copy & edit `.env` → set `APP_ENV=production`, `APP_DEBUG=false`
4. Update `APP_URL` dan `GOOGLE_REDIRECT_URI` ke domain production
5. `php artisan migrate --seed`
6. `php artisan storage:link`
7. `php artisan config:cache && php artisan route:cache`
8. Arahkan document root ke folder `public/`
