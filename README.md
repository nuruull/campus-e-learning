<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<img src="https://img.shields.io/badge/Laravel-v12.x-FF2D20?style=for-the-badge&logo=laravel" alt="Laravel Version">
<img src="https://www.google.com/search?q=https://img.shields.io/badge/PHP-8.2-777BB4%3Fstyle%3Dfor-the-badge%26logo%3Dphp" alt="PHP Version">
<img src="https://www.google.com/search?q=https://img.shields.io/badge/License-MIT-green.svg%3Fstyle%3Dfor-the-badge" alt="License">
</p>

Aplikasi E-Learning Kampus (API)
Ini adalah backend API untuk aplikasi E-Learning Kampus yang dibangun menggunakan Laravel. Aplikasi ini menyediakan fungsionalitas lengkap mulai dari autentikasi, manajemen mata kuliah, tugas, forum diskusi, hingga laporan statistik, sesuai dengan soal tes yang diberikan.

✨ Fitur Utama
Autentikasi Berbasis Token: Menggunakan Laravel Sanctum untuk autentikasi yang aman.

Manajemen Role: Membedakan hak akses antara Dosen dan Mahasiswa menggunakan spatie/laravel-permission.

Manajemen Mata Kuliah: CRUD penuh untuk mata kuliah dan sistem pendaftaran (enroll) untuk mahasiswa.

Manajemen Materi: Dosen dapat mengunggah materi dan mahasiswa dapat mengunduhnya.

Sistem Tugas & Penilaian: Dosen dapat membuat tugas, mahasiswa mengumpulkan jawaban, dan dosen dapat memberi nilai.

Forum Diskusi: Sarana interaksi antara dosen dan mahasiswa di setiap mata kuliah.

Laporan & Statistik: Endpoint untuk melihat statistik jumlah mahasiswa, status penilaian tugas, dan laporan detail per mahasiswa.

🚀 Fitur Tambahan yang Diimplementasikan
✅ Soft Deletes: Data penting seperti mata kuliah dan tugas tidak akan terhapus permanen.

✅ Notifikasi Email: Mahasiswa menerima notifikasi email saat ada tugas baru, diproses melalui sistem antrean (Queue) untuk performa optimal.

✅ Forum Real-Time: Diskusi diperbarui secara real-time tanpa perlu refresh halaman, dibangun menggunakan Laravel Reverb.

🛠️ Teknologi yang Digunakan
Laravel 12

PHP 8.2

Laravel Sanctum (untuk autentikasi API)

Spatie Laravel Permission (untuk manajemen role)

Laravel Reverb (untuk fungsionalitas WebSocket real-time)

Laravel Queue (untuk memproses pengiriman email di latar belakang)

MySQL / PostgreSQL

⚙️ Panduan Instalasi & Setup Lokal
Clone Repositori

git clone [https://github.com/NAMA_ANDA/NAMA_REPO.git](https://github.com/NAMA_ANDA/NAMA_REPO.git)
cd NAMA_REPO

Install Dependensi

composer install
npm install

Konfigurasi Environment
Salin file .env.example dan sesuaikan konfigurasinya.

cp .env.example .env

Buka file .env dan atur koneksi database (DB_*), kredensial Mailtrap (MAIL_*), dan biarkan konfigurasi Reverb & Pusher apa adanya untuk lokal.

Generate Key & Migrasi Database

php artisan key:generate
php artisan migrate --seed

(Pastikan Anda sudah membuat database kosong sesuai konfigurasi di .env)

Jalankan Server-Server yang Dibutuhkan
Buka 3 terminal terpisah dan jalankan perintah berikut di masing-masing terminal:

Terminal 1: Web Server (jika tidak pakai Laragon/Valet)

php artisan serve

Terminal 2: WebSocket Server (Reverb)

php artisan reverb:start

Terminal 3: Queue Worker

php artisan queue:work

Aplikasi API sekarang siap diakses di http://localhost:8000 atau URL lokal Anda.

📖 Dokumentasi Endpoint API
Semua endpoint di bawah ini memerlukan header Accept: application/json. Endpoint yang terproteksi memerlukan Authorization: Bearer <TOKEN>.

1. Autentikasi
Method

Endpoint

Deskripsi

Akses

POST

/register

Mendaftarkan user baru.

Publik

POST

/login

Login untuk mendapatkan token API.

Publik

POST

/logout

Logout dan mencabut token API.

Login

<details>
<summary>Lihat Detail Request & Response</summary>

POST /register

{
    "name": "Nama User",
    "email": "user@example.com",
    "password": "password",
    "password_confirmation": "password",
    "role": "mahasiswa" // atau "dosen"
}

POST /login

{
    "email": "user@example.com",
    "password": "password"
}

Respons Sukses /login

{
    "access_token": "1|token_anda...",
    "token_type": "Bearer"
}

</details>

2. Manajemen Mata Kuliah
Method

Endpoint

Deskripsi

Akses

GET

/api/courses

Menampilkan semua mata kuliah.

Login

GET

/api/courses/{course:slug}

Menampilkan detail satu mata kuliah.

Login

POST

/api/courses

Membuat mata kuliah baru.

Dosen

PUT

/api/courses/{course:slug}

Mengupdate mata kuliah.

Dosen (Pemilik)

DELETE

/api/courses/{course:slug}

Mengarsipkan mata kuliah.

Dosen (Pemilik)

POST

/api/courses/{course:slug}/enroll

Mendaftar ke mata kuliah.

Mahasiswa

3. Materi Perkuliahan
Method

Endpoint

Deskripsi

Akses

POST

/api/courses/{course:slug}/materials

Upload materi baru.

Dosen (Pemilik)

GET

/api/materials/{material}/download

Download file materi.

Login

4. Tugas & Penilaian
Method

Endpoint

Deskripsi

Akses

POST

/api/courses/{course:slug}/assignments

Membuat tugas baru.

Dosen (Pemilik)

POST

/api/assignments/{assignment}/submissions

Mengumpulkan jawaban.

Mahasiswa

POST

/api/submissions/{submission}/grade

Memberi nilai.

Dosen

5. Forum Diskusi
Method

Endpoint

Deskripsi

Akses

GET

/api/courses/{course:slug}/discussions

Menampilkan semua diskusi.

Login

POST

/api/courses/{course:slug}/discussions

Membuat diskusi baru.

Login

POST

/api/discussions/{discussion}/replies

Membalas sebuah diskusi.

Login

6. Laporan & Statistik
Method

Endpoint

Deskripsi

Akses

GET

/api/reports/courses

Statistik jumlah mahasiswa per mata kuliah.

Login

GET

/api/reports/assignments

Statistik submission (berdasarkan role).

Login

GET

/api/reports/students/{user}

Laporan detail seorang mahasiswa.

Terbatas

License
Proyek ini adalah perangkat lunak sumber terbuka yang dilisensikan di bawah Lisensi MIT.
