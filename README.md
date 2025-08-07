# aplikasi SIBADAK "SISTEM INFORMASI BAKORWIL TIGA MALANG DALAM ANGKA
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# SI BADAK

Selamat datang di **Aplikasi Stunting**!  
Aplikasi ini dibangun menggunakan **Laravel 10** untuk mengelola data tentang wilayah BAKORWIL III Malang <br>
note : aplikasi ini masih dalam proses pengerjaan belum selesai

---

## 🎯 Fitur Utama  
- **CRUD Operations**:  
  - Create, Read, Update, dan Deletedata dengan mudah.  
- **Relasi Antar Tabel**:  
  - Mendukung relasi seperti *One-to-Many*, *Many-to-Many*, dan *One-to-One*.  
- **Validasi Data**:  
  - Validasi form untuk memastikan data yang dimasukkan sesuai.  
- **UI Dinamis**:  
  - Antarmuka interaktif menggunakan Blade Template Engine.  
- **Pagination**:  
  - Membagi data menjadi beberapa halaman untuk performa lebih baik.  

---

## 🛠️ Teknologi yang Digunakan  
- **Framework**: Laravel 10  
- **Database**: MySQL / MariaDB  
- **Frontend**: Blade Template, Bootstrap 
- **Authentication**: Laravel Authentication

---

## 📋 Prasyarat  
Sebelum memulai, pastikan Anda memiliki:  
- **PHP >= 8.1**  
- **Composer**  
- **Node.js & npm**  
- **Database**: MySQL atau MariaDB  

---

## 📦 Instalasi  

1. Clone repositori ini:  
   ```bash
   git clone https://github.com/elisaoktvna/Stunting-Apps.git
2. Masuk ke projek :
```
cd StuntingApps
```

3. Install semua dependency :
```
composer install
```

4. Copy .env.example ke .env :
```
- copy file .env.example
- buat file baru .env
- paste isi env axample ke file env yang baru dibuat
```

5. Generate key :
```
php artisan key:generate
```

6. Buka **.env** lalu ubah konfigurasi database sesuai yang ingin dipakai :
```
DB_PORT=3306
DB_DATABASE=db_stunting
DB_USERNAME=root
DB_PASSWORD=
```

7. Migrate database :
```
php artisan migrate
```

8. Selesai, sudah bisa di jalankan :
```
php artisan serve
