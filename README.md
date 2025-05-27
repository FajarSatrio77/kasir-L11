# KasirKu - Aplikasi Kasir Sederhana

Aplikasi kasir sederhana yang dibangun dengan Laravel 11 dan Livewire. Aplikasi ini memungkinkan pengguna untuk mengelola produk, transaksi, dan laporan penjualan dengan mudah.

> **Status:** 🚧 Masih dalam tahap pengembangan

## 🚀 Fitur Utama

- 🔐 **Autentikasi & Manajemen Pengguna**
  - Login/Register
  - Manajemen pengguna (Admin/Kasir/Pelanggan)
  - Log aktivitas pengguna
  - Sistem poin pelanggan

- 📦 **Manajemen Produk**
  - CRUD Produk
  - Kategori Produk
  - Stok Management
  - Barcode Scanner
  - Harga berbeda untuk tipe pelanggan

- 💰 **Transaksi**
  - Transaksi kasir
  - Pencarian produk cepat
  - Perhitungan otomatis
  - Cetak struk
  - Sistem diskon
  - Sistem poin
  - PPN otomatis

- 📊 **Laporan**
  - Laporan penjualan
  - Laporan stok
  - Filter berdasarkan tanggal
  - Cetak laporan
  - Detail transaksi

## 🛠️ Teknologi yang Digunakan

- PHP 8.1+
- Laravel 11
- Livewire 3
- MySQL/MariaDB
- Bootstrap 5
- Font Awesome
- SweetAlert2

## 📋 Persyaratan Sistem

- PHP >= 8.1
- Composer
- MySQL/MariaDB
- Web Server (Apache/Nginx)
- Node.js & NPM

## 🚀 Instalasi

1. **Clone repository**
   ```bash
   git clone https://github.com/FajarSatrio77/kasir-laravel11.git
   cd kasir-laravel11
   ```

2. **Install dependencies PHP**
   ```bash
   composer install
   ```

3. **Install dependencies JavaScript**
   ```bash
   npm install
   npm run build
   ```

4. **Setup environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Konfigurasi database**
   - Buka file `.env`
   - Sesuaikan konfigurasi database:
     ```
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=nama_database
     DB_USERNAME=username
     DB_PASSWORD=password
     ```

6. **Jalankan migrasi dan seeder**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

7. **Jalankan aplikasi**
   ```bash
   php artisan serve
   ```

## 👥 Akses Aplikasi

Buka browser dan akses:
```
http://localhost:8000
```

### Kredensial Default
- **Admin**
  - Email: admin@admin.com
  - Password: admin123

- **Kasir**
  - Email: kasir@kasir.com
  - Password: kasir123

## 📁 Struktur Folder

```
kasir-laravel/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   └── Livewire/
│   ├── Models/
│   └── Traits/
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

## 🔧 Penggunaan

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

## 🔒 Keamanan

- Password di-hash menggunakan bcrypt
- Proteksi CSRF pada semua form
- Validasi input pada semua form
- Middleware untuk autentikasi dan otorisasi

## 📞 Kontak & Dukungan

- Email: mohamadfajarsatrio@gmail.com
- Telepon: 08979381884
- GitHub: [FajarSatrio77](https://github.com/FajarSatrio77)

## 📝 Lisensi

Project ini dilisensikan di bawah [MIT License](LICENSE).

## 🙏 Terima Kasih

Terima kasih telah menggunakan aplikasi KasirKu. Semoga aplikasi ini bermanfaat untuk bisnis Anda!

## 🔄 Update Terakhir

- Penambahan fitur log aktivitas
- Perbaikan tampilan UI/UX
- Optimasi performa aplikasi
- Penambahan fitur export Excel
- Perbaikan bug dan error
