# LibraTech - Sistem Manajemen Perpustakaan Digital

LibraTech adalah sistem manajemen perpustakaan digital yang dibangun menggunakan PHP dan MySQL. Aplikasi ini dirancang untuk memudahkan pengelolaan perpustakaan dengan fitur-fitur modern seperti verifikasi email, manajemen buku, dan sistem peminjaman.

## 🏗️ Struktur Proyek

```
LibraTech/
├── Admin/           # Halaman dan fungsi admin
├── User/            # Halaman dan fungsi user
├── Auth/            # Sistem autentikasi
├── assets/          # File statis (gambar, dll)
├── css/             # Stylesheet
├── js/              # JavaScript
├── Database/        # File database
├── vendor/          # Dependencies
├── func.php         # Fungsi-fungsi utama
└── index.php        # Halaman utama
```

## 🚀 Fitur Utama

### 🔐 Sistem Autentikasi

- Registrasi pengguna dengan verifikasi email
- Sistem OTP (One-Time Password)
- Login multi-level (Admin & User)
- Keamanan password dengan hashing

### 📚 Manajemen Buku

- CRUD (Create, Read, Update, Delete) data buku
- Kategorisasi buku
- Upload cover buku
- Detail lengkap buku (judul, pengarang, penerbit, dll)

### 👥 Manajemen Anggota

- Registrasi anggota
- Verifikasi email
- Manajemen profil
- Riwayat peminjaman

### 📧 Sistem Notifikasi

- Notifikasi email menggunakan PHPMailer
- Verifikasi email
- Pengingat peminjaman

## 🛠️ Teknologi yang Digunakan

- PHP 7.4+
- MySQL Database
- PHPMailer untuk notifikasi email
- Bootstrap untuk UI/UX
- JavaScript & jQuery
- SweetAlert2 untuk notifikasi

## 📋 Persyaratan Sistem

- Web Server (Apache/Nginx)
- PHP 7.4 atau lebih tinggi
- MySQL 5.7 atau lebih tinggi
- Ekstensi PHP yang diperlukan:
  - PDO
  - MySQLi
  - GD Library
  - cURL

## 🚀 Panduan Instalasi

1. **Persiapan**

   ```bash
   git clone [url-repository]
   cd LibraTech
   composer install
   ```

2. **Konfigurasi Database**

   - Buat database baru di phpMyAdmin
   - Impor file `perpustakaan.sql` dari folder `Database`
   - Sesuaikan konfigurasi database di `func.php`:
     ```php
     $host = 'localhost';
     $user = 'LibraTech';
     $pass = 'Lupalagi21';
     $db = 'perpustakaan';
     ```

3. **Konfigurasi Email**

   - Atur SMTP di `func.php`:
     ```php
     $mail->Host = 'smtp.gmail.com';
     $mail->Username = 'your-email@gmail.com';
     $mail->Password = 'your-app-password';
     ```

4. **Jalankan Aplikasi**
   - Buka `index.php` di browser
   - Registrasi akun baru atau login

## 📝 Panduan Penggunaan

### Untuk Admin

1. Login ke dashboard admin
2. Kelola data buku di menu "Buku"
3. Kelola anggota di menu "Anggota"
4. Monitor peminjaman di menu "Peminjaman"

### Untuk Pengguna

1. Registrasi akun baru
2. Verifikasi email
3. Login ke sistem
4. Cari dan pinjam buku
5. Lihat riwayat peminjaman

## 🔒 Keamanan

- Password di-hash menggunakan `password_hash()`
- Validasi input
- Sanitasi data
- Session management
- Proteksi CSRF

## 📞 Dukungan

Untuk bantuan dan dukungan, silakan hubungi:

- Email: Shiddiqduasatu@gmail.com

---

Dikembangkan dengan ❤️ oleh Shiddiq
