# 📚 Savansa Library — SMP Negeri 181 Jakarta

<div align="center">

**Sistem Informasi Perpustakaan Sekolah** — katalog buku online, event & berita, absensi pengunjung, dan manajemen peminjaman dalam satu aplikasi.

![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?style=flat-square&logo=laravel&logoColor=white)
![Filament](https://img.shields.io/badge/Filament-3-F7B32B?style=flat-square&logo=filament&logoColor=black)
![PHP](https://img.shields.io/badge/PHP-%E2%89%A58.2-777BB4?style=flat-square&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-Database-4479A1?style=flat-square&logo=mysql&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3-06B6D4?style=flat-square&logo=tailwindcss&logoColor=white)

[🏠 Kunjungi Situs](https://perpus.keii.my.id) · [📖 Katalog Buku](https://perpus.keii.my.id/buku) · [🗓️ Event & Berita](https://perpus.keii.my.id/blog)

</div>

---

## ✨ Fitur

### 🌐 Sisi Publik
| Fitur | Deskripsi |
|---|---|
| 🖼️ **Hero Slider** | Halaman beranda dengan slider foto full-screen |
| 📖 **Katalog Buku** | Pencarian & detail buku dengan cover 9:16 di [buku](https://perpus.keii.my.id/buku) |
| 🗓️ **Event & Berita** | Pengumuman kegiatan perpustakaan dalam format blog |
| 📊 **Statistik Publik** | Grafik kunjungan & pengembalian (7/30 hari terakhir) |
| 🏫 **Profil** | Visi Misi, Struktur Pengelola, dan Tata Tertib perpustakaan |
| 💬 **Sambutan** | Sambutan Kepala Sekolah yang dikelola via admin |

### 🔐 Panel Admin (Filament)
- **Manajemen Buku** — CRUD koleksi + import massal dari Excel (`maatwebsite/excel`)
- **Data Siswa** — database anggota perpustakaan + import NIS
- **Peminjaman & Pengembalian** — pencatatan transaksi dengan status (dipinjam / terlambat / dikembalikan)
- **Absensi Pengunjung** — rekap kunjungan harian + export Excel
- **Konten Website** — kelola event, rekomendasi buku, slider, sambutan kepala sekolah, visi misi, struktur pengelola, tata tertib
- **Pengaturan Situs & Role** — konfigurasi dan kontrol akses berbasis permission

---

## 🛠️ Teknologi

- **Backend** — [Laravel 11](https://laravel.com) · [Filament 3](https://filamentphp.com) (admin panel)
- **Frontend** — [Tailwind CSS](https://tailwindcss.com) · [Alpine.js](https://alpinejs.dev) · [Swiper](https://swiperjs.com) · [Chart.js](https://www.chartjs.org)
- **Database** — MySQL
- **Import/Export** — [maatwebsite/excel](https://docs.laravel-excel.com)

---

## 🚀 Instalasi Lokal

**Prasyarat:** PHP ≥ 8.2, Composer, Node.js, MySQL

```bash
# 1. Clone repositori
git clone https://github.com/KekeNihBoss/PerpusSMP181.git
cd PerpusSMP181

# 2. Instal dependensi
composer install
npm install

# 3. Konfigurasi environment
cp .env.example .env
php artisan key:generate

# 4. Atur koneksi database di .env
#    DB_DATABASE, DB_USERNAME, DB_PASSWORD

# 5. Migrasi & seed database
php artisan migrate --seed

# 6. Buat storage link (untuk gambar/foto)
php artisan storage:link

# 7. Jalankan
npm run dev      # terminal 1
php artisan serve  # terminal 2
```

Aplikasi: `http://localhost:8000` · Admin: `http://localhost:8000/perpus/login`

---

## 🐳 Deploy dengan Docker

```bash
cp .env.example .env   # sesuaikan konfigurasi dulu
docker compose up -d --build
```

---

## 📂 Struktur Utama

```
├── app/
│   ├── Filament/Resources/    # Admin CRUD (buku, siswa, peminjaman, dst.)
│   ├── Http/Controllers/      # Controller halaman publik
│   ├── Exports/               # Export Excel (absensi, buku, pengembalian)
│   └── Models/                # 14 model Eloquent
├── resources/views/           # Blade templates (publik + admin)
├── routes/web.php             # Routing halaman publik
└── docker-compose.yml         # Konfigurasi deployment
```

---

## 📄 Lisensi

Proyek ini dibuat untuk keperluan internal **SMP Negeri 181 Jakarta**.

<div align="center">

**© 2026 Savansa Library — Perpustakaan SMP Negeri 181 Jakarta Pusat**

</div>
