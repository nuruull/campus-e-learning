# 📚 E-LEARNING CAMPUS (API)

Backend API untuk aplikasi **E-Learning Kampus** yang dibangun menggunakan **Laravel**.
Menyediakan fitur lengkap seperti autentikasi, manajemen mata kuliah, tugas, forum diskusi, dan laporan aktivitas mahasiswa, sesuai dengan soal tes yang diberikan.

---

## 🚀 Features

- 🔐 **Autentikasi Token (Sanctum)** dengan manajemen Role Dosen & Mahasiswa (Spatie).
- 📘 **CRUD penuh** untuk manajemen mata kuliah, materi, tugas, dan sistem penilaian.
- 💬 **Forum Diskusi interaktif** antar pengguna.
- 📊 **Laporan & Statistik** aktivitas mahasiswa dan tugas.
- ⚙️ **Fitur tambahan**: Soft Deletes, Notifikasi Email via Queue, Forum Real-Time dengan Laravel Reverb.

---

## 🧩 Technologies

- Laravel 12 / PHP 8.2
- Laravel Sanctum
- Spatie Laravel Permission
- Laravel Reverb & Queue
- MySQL / PostgreSQL

---

## 🛠️ Installation

### 1. Clone Repository

```bash
git clone https://github.com/nuruull/campus-e-learning.git
cd campus-e-learning
```

### 2. Install Dependencies

```bash
composer install
npm install
```

### 3. Configure Environment

```bash
cp .env.example .env
php artisan key:generate
```

> Pastikan untuk mengatur koneksi database (`DB_*`) dan kredensial Mailtrap (`MAIL_*`) di file `.env`.

### 4. Run Migrations

```bash
php artisan migrate --seed
```

---

## ▶️ Usage

Jalankan tiga server berikut di terminal terpisah untuk fungsionalitas penuh.

**Terminal 1 – Web Server**

```bash
php artisan serve
```

**Terminal 2 – WebSocket Server (Reverb)**

```bash
php artisan reverb:start
```

**Terminal 3 – Queue Worker**

```bash
php artisan queue:work
```

---

## 📡 API Documentation

> Semua endpoint memerlukan header:
>
> ```
> Accept: application/json
> ```
>
> Endpoint yang terproteksi memerlukan:
>
> ```
> Authorization: Bearer {token}
> ```

---

### 1. 🔑 Authentication

**Register User**

```http
POST /register
```

**Body**

```json
{
  "name": "Nama User",
  "email": "user@example.com",
  "password": "password",
  "password_confirmation": "password",
  "role": "mahasiswa"
}
```

**Login**

```http
POST /login
```

**Body**

```json
{
  "email": "user@example.com",
  "password": "password"
}
```

**Logout**

```http
POST /logout
```

---

### 2. 📘 Course Management

```http
GET /api/courses
POST /api/courses
PUT /api/courses/{course:slug}
DELETE /api/courses/{course:slug}
POST /api/courses/{course:slug}/enroll
```

---

### 3. 📂 Materials, Assignments & Grading

```http
POST /api/courses/{course:slug}/materials
GET /api/materials/{material}/download
POST /api/courses/{course:slug}/assignments
POST /api/assignments/{assignment}/submissions
POST /api/submissions/{submission}/grade
```

---

### 4. 💬 Forum & Reports

```http
GET /api/courses/{course:slug}/discussions
POST /api/courses/{course:slug}/discussions
POST /api/discussions/{discussion}/replies
GET /api/reports/courses
GET /api/reports/assignments
GET /api/reports/students/{user}
```

---

## 🤝 Contributing

Pull requests are welcome!
Untuk perubahan besar, silakan buka issue terlebih dahulu untuk mendiskusikan apa yang ingin Anda ubah.

---

## 🧾 License

This project is licensed under the [MIT License](LICENSE).
