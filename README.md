# KasirKu - Aplikasi Kasir Sederhana

Aplikasi kasir sederhana yang dibangun dengan Laravel dan Livewire. Aplikasi ini memungkinkan pengguna untuk mengelola produk, transaksi, dan laporan penjualan dengan mudah.


> **Status:** 🚧 Masih dalam tahap pengembangan



## Fitur

- 🔐 Autentikasi pengguna (Login/Register)
- 👥 Manajemen pengguna (Admin/Kasir)
- 📦 Manajemen produk (CRUD)
- 💰 Transaksi kasir dengan barcode scanner
- 📊 Laporan penjualan dengan filter tanggal
- 🖨️ Cetak laporan penjualan

## Persyaratan Sistem

- PHP >= 8.1
- Composer
- MySQL/MariaDB
- Web Server (Apache/Nginx)
- Node.js & NPM (untuk asset compilation)

## Instalasi

1. Clone repository ini:
```bash
git clone https://github.com/FajarSatrio77/kasir-laravel11.git
cd kasir-laravel11
```

2. Install dependencies PHP menggunakan Composer:
```bash
composer install
```

3. Install dependencies JavaScript menggunakan NPM:
```bash
npm install
npm run build
```

4. Salin file .env.example menjadi .env:
```bash
cp .env.example .env
```

5. Generate application key:
```bash
php artisan key:generate
```

6. Jalankan migrasi database:
```bash
php artisan migrate
```

7. Jalankan seeder untuk membuat user admin default:
```bash
php artisan db:seed
```

## Menjalankan Aplikasi

1. Jalankan server development Laravel:
```bash
php artisan serve
```

2. Buka browser dan akses:
```
http://localhost:8000
```

3. Login dengan kredensial default:
- Email: admin@admin.com
- Password: admin123

## Penggunaan

### Login
1. Buka aplikasi di browser
2. Masukkan email dan password
3. Klik tombol "Login"

### Manajemen Produk
1. Klik menu "Produk"
2. Untuk menambah produk baru, klik "Tambah Produk"
3. Isi form produk (nama, kode, harga, stok)
4. Klik "Simpan"

### Transaksi
1. Klik menu "Transaksi"
2. Scan barcode produk atau masukkan kode produk
3. Masukkan jumlah pembayaran
4. Klik "Selesai" untuk menyelesaikan transaksi

### Laporan
1. Klik menu "Laporan"
2. Pilih rentang tanggal
3. Klik "Filter" untuk melihat laporan
4. Klik "Print Laporan" untuk mencetak

## Struktur Folder

```
kasir-laravel/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   └── Livewire/
│   └── Models/
├── config/
├── database/
│   ├── migrations/
│   └── seeders/
├── public/
├── resources/
│   └── views/
│       ├── components/
│       ├── layouts/
│       └── livewire/
├── routes/
└── tests/
```

## Teknologi yang Digunakan

- [Laravel](https://laravel.com) - PHP Framework
- [Livewire](https://livewire.laravel.com) - Full-stack Framework
- [Bootstrap](https://getbootstrap.com) - CSS Framework
- [Font Awesome](https://fontawesome.com) - Icons
- [MySQL](https://www.mysql.com) - Database



## Kontak

- Email: mohamadfajarsatrio@gmail.com
- Telepon: 08979381884
