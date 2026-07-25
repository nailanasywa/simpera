# SIMPERA

**Sistem Informasi Peminjaman dan Pengembalian Rekam Medis Rawat Jalan Berbasis Web**

## Persyaratan

Pastikan perangkat telah terpasang:

- PHP 8.2 atau lebih baru
- Composer
- MySQL/MariaDB
- Git

---

## Instalasi

### 1. Clone Repository

Melalui SSH:

```bash
git clone git@github.com:nailanasywa/simpera.git
```

Masuk ke direktori proyek:

```bash
cd simpera
```

---

### 2. Install Dependency

```bash
composer install
```

---

### 3. Salin File Environment

Linux/macOS:

```bash
cp .env.example .env
```

Windows (Command Prompt):

```cmd
copy .env.example .env
```

Windows (PowerShell):

```powershell
Copy-Item .env.example .env
```

---

### 4. Konfigurasi Environment

Buka file `.env`, kemudian sesuaikan konfigurasi berikut:

#### Database

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database
DB_USERNAME=username
DB_PASSWORD=password
```

#### Mail

Sesuaikan konfigurasi mail sesuai penyedia layanan yang digunakan, misalnya Gmail SMTP.

Contoh:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your_email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

---

### 5. Generate Application Key

```bash
php artisan key:generate
```

---

### 6. Jalankan Migrasi dan Seeder (jika diperlukan)

```bash
php artisan migrate --seed
```

atau

```bash
php artisan migrate
```

---

## Menjalankan Aplikasi

### Jalankan Laravel Development Server

```bash
php artisan serve
```

---

### Jalankan Queue Worker

Buka terminal baru kemudian jalankan:

```bash
php artisan queue:work
```

---

### Jalankan Scheduler

Buka terminal baru kemudian jalankan:

```bash
php artisan schedule:work
```

---

## Menjalankan Aplikasi

Pastikan tiga proses berikut berjalan secara bersamaan:

| Terminal   | Perintah                    |
| ---------- | --------------------------- |
| Terminal 1 | `php artisan serve`         |
| Terminal 2 | `php artisan queue:work`    |
| Terminal 3 | `php artisan schedule:work` |

Aplikasi dapat diakses melalui:

```
http://127.0.0.1:8000
```

---

# Update Project

Jika repository **sudah pernah di-clone** sebelumnya dan terdapat pembaruan dari repository, lakukan langkah berikut.

### 1. Masuk ke direktori project

```bash
cd simpera
```

### 2. Ambil perubahan terbaru

```bash
git pull
```

### 3. Perbarui dependency Composer

```bash
composer update
```

Atau jika hanya ingin menginstal dependency sesuai `composer.lock` terbaru (lebih disarankan):

```bash
composer install
```

### 4. Jalankan migrasi (jika terdapat perubahan database)

```bash
php artisan migrate:fresh --seed
```

### 5. Bersihkan cache aplikasi (opsional namun disarankan)

```bash
php artisan optimize:clear
```

### 6. Jalankan kembali aplikasi

Terminal 1

```bash
php artisan serve
```

Terminal 2

```bash
php artisan queue:work
```

Terminal 3

```bash
php artisan schedule:work
```

---

## Repository

```
git@github.com:nailanasywa/simpera.git
```

---

## Teknologi yang Digunakan

- Laravel v.13
- Bootstrap 5
- MySQL
- Laravel Queue
- Laravel Scheduler
