Aplikasi E-Learning Kampus (API)Ini adalah backend API untuk aplikasi E-Learning Kampus yang dibangun menggunakan Laravel. Aplikasi ini menyediakan fungsionalitas lengkap mulai dari autentikasi, manajemen mata kuliah, tugas, forum diskusi, hingga laporan statistik, sesuai dengan soal tes yang diberikan.Fitur UtamaAutentikasi Berbasis Token: Menggunakan Laravel Sanctum untuk autentikasi yang aman.Manajemen Role: Membedakan hak akses antara Dosen dan Mahasiswa menggunakan spatie/laravel-permission.Manajemen Mata Kuliah: CRUD penuh untuk mata kuliah dan sistem pendaftaran (enroll) untuk mahasiswa.Manajemen Materi: Dosen dapat mengunggah materi dan mahasiswa dapat mengunduhnya.Sistem Tugas & Penilaian: Dosen dapat membuat tugas, mahasiswa mengumpulkan jawaban, dan dosen dapat memberi nilai.Forum Diskusi: Sarana interaksi antara dosen dan mahasiswa di setiap mata kuliah.Laporan & Statistik: Endpoint untuk melihat statistik jumlah mahasiswa, status penilaian tugas, dan laporan detail per mahasiswa.Fitur Tambahan yang Diimplementasikan✅ Soft Deletes: Data penting seperti mata kuliah dan tugas tidak akan terhapus permanen.✅ Notifikasi Email: Mahasiswa menerima notifikasi email saat ada tugas baru, diproses melalui sistem antrean (Queue) untuk performa optimal.✅ Forum Real-Time: Diskusi diperbarui secara real-time tanpa perlu refresh halaman, dibangun menggunakan Laravel Reverb.Teknologi yang DigunakanLaravel 12PHP 8.2Laravel Sanctum (untuk autentikasi API)Spatie Laravel Permission (untuk manajemen role)Laravel Reverb (untuk fungsionalitas WebSocket real-time)Laravel Queue (untuk memproses pengiriman email di latar belakang)MySQL / PostgreSQLPanduan Instalasi & Setup LokalClone Repositorigit clone [https://github.com/nama-anda/e-learning-kampus.git](https://github.com/nama-anda/e-learning-kampus.git)
cd e-learning-kampus
Install Dependensicomposer install
npm install
Konfigurasi EnvironmentSalin file .env.example dan sesuaikan konfigurasinya.cp .env.example .env
Buka file .env dan atur koneksi database (DB_*), kredensial Mailtrap (MAIL_*), dan biarkan konfigurasi Reverb & Pusher apa adanya untuk lokal.Generate Key & Migrasi Databasephp artisan key:generate
php artisan migrate --seed
(Pastikan Anda sudah membuat database kosong sesuai konfigurasi di .env)Jalankan Server-Server yang DibutuhkanBuka 3 terminal terpisah dan jalankan perintah berikut di masing-masing terminal:Terminal 1: Web Server (jika tidak pakai Laragon/Valet)php artisan serve
Terminal 2: WebSocket Server (Reverb)php artisan reverb:start
Terminal 3: Queue Workerphp artisan queue:work
Aplikasi API sekarang siap diakses di http://localhost:8000 atau URL lokal Anda.Dokumentasi Endpoint APISemua endpoint di bawah ini memerlukan header Accept: application/json.1. AutentikasiRegistrasi UserEndpoint: POST /registerDeskripsi: Mendaftarkan user baru sebagai Dosen atau Mahasiswa.Body:{
    "name": "Nama User",
    "email": "user@example.com",
    "password": "password",
    "password_confirmation": "password",
    "role": "mahasiswa" // atau "dosen"
}
Login UserEndpoint: POST /loginDeskripsi: Login untuk mendapatkan token API.Body:{
    "email": "user@example.com",
    "password": "password"
}
Respons Sukses:{
    "access_token": "1|token_anda...",
    "token_type": "Bearer"
}
Logout UserEndpoint: POST /logoutAuthorization: Bearer Token diperlukan.2. Manajemen Mata KuliahSemua endpoint di bawah ini memerlukan Bearer Token.GET /api/courses: Menampilkan semua mata kuliah.GET /api/courses/{course:slug}: Menampilkan detail satu mata kuliah.POST /api/courses: Membuat mata kuliah baru (hanya Dosen).PUT /api/courses/{course:slug}: Mengupdate mata kuliah (hanya Dosen pemilik).DELETE /api/courses/{course:slug}: Mengarsipkan mata kuliah (hanya Dosen pemilik).POST /api/courses/{course:slug}/enroll: Mendaftarkan mahasiswa ke mata kuliah (hanya Mahasiswa).3. Materi PerkuliahanMemerlukan Bearer Token.POST /api/courses/{course:slug}/materials: Upload materi baru (hanya Dosen pemilik).GET /api/materials/{material}/download: Download file materi.4. Tugas & PenilaianMemerlukan Bearer Token.POST /api/courses/{course:slug}/assignments: Membuat tugas baru (hanya Dosen pemilik).POST /api/assignments/{assignment}/submissions: Mengumpulkan jawaban (hanya Mahasiswa).POST /api/submissions/{submission}/grade: Memberi nilai (hanya Dosen).5. Forum DiskusiMemerlukan Bearer Token.GET /api/courses/{course:slug}/discussions: Menampilkan semua diskusi di mata kuliah.POST /api/courses/{course:slug}/discussions: Membuat diskusi baru.POST /api/discussions/{discussion}/replies: Membalas sebuah diskusi.6. Laporan & StatistikMemerlukan Bearer Token.GET /api/reports/courses: Statistik jumlah mahasiswa per mata kuliah.GET /api/reports/assignments: Statistik submission yang sudah/belum dinilai (berdasarkan role).GET /api/reports/students/{user}: Laporan detail tugas dan nilai seorang mahasiswa (akses dibatasi).
