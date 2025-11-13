# Apriori Sales App

> **Market Basket Analysis Application** - Aplikasi berbasis Laravel untuk analisis asosiasi data penjualan menggunakan algoritma Apriori. Temukan pola pembelian produk dan tingkatkan strategi cross-selling Anda!

[![Laravel](https://img.shields.io/badge/Laravel-11.x-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-blue.svg)](https://php.net)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind-3.x-38bdf8.svg)](https://tailwindcss.com)

---

## 📋 Fitur Utama

- ✅ **Multi-User Authentication** - Sistem login/register dengan Laravel Breeze
- 📊 **Dashboard Interaktif** - Statistik real-time untuk setiap user
- 📁 **Project Management** - Kelola multiple project analisa
- 📤 **Import Data** - Upload CSV/Excel untuk data transaksi penjualan
- 🤖 **Apriori Algorithm** - Analisis asosiasi otomatis dengan background jobs
- 📈 **Association Rules** - Tampilan hasil dengan Support, Confidence, dan Lift
- 🔍 **Filter & Sort** - Pencarian dan sorting rules berdasarkan berbagai kriteria
- 🔒 **Multi-Tenant** - Data isolation per user
- 📱 **Responsive Design** - UI yang optimal di semua device

---

## 🚀 Quick Start

### Prerequisites

Pastikan Anda sudah menginstall:
- PHP >= 8.2
- Composer
- Node.js & NPM
- SQLite / MySQL / PostgreSQL

### Installation

```bash
# Clone repository
git clone <repository-url>
cd apriori-sales-app

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Setup database
touch database/database.sqlite  # Jika menggunakan SQLite
php artisan migrate

# Build assets
npm run build

# Create storage link
php artisan storage:link

# Start development server
php artisan serve
```

Aplikasi akan berjalan di `http://localhost:8000`

### Running Queue Worker (untuk Background Jobs)

Untuk menjalankan analisis Apriori di background:

```bash
php artisan queue:work
```

**Catatan:** Untuk production, gunakan Supervisor atau process manager lainnya.

---

## 📖 Cara Penggunaan

### 1. Register & Login
- Buat akun baru atau login dengan akun existing
- Setiap user memiliki data yang terpisah

### 2. Buat Project Baru
- Klik **"New Project"** di dashboard
- Isi nama project dan deskripsi
- Set parameter:
  - **Minimum Support** (0.01 - 1.0): Frekuensi minimum itemset
  - **Minimum Confidence** (0.0 - 1.0): Tingkat kepercayaan rule

### 3. Import Data Penjualan
- Klik **"Import Data"** pada project
- Download template CSV jika perlu
- Upload file dengan format:
  ```csv
  transaction_id,item_name
  T001,Bread
  T001,Milk
  T001,Butter
  T002,Bread
  T002,Coffee
  ```
- Format: 1 baris = 1 item dalam transaksi
- Transaksi yang sama dikenali dari `transaction_id`

### 4. Jalankan Analisis
- Klik **"Run Apriori Analysis"**
- Proses akan berjalan di background
- Status akan berubah dari `Processing` → `Completed`

### 5. Lihat Hasil
- Klik **"View Results"**
- Analisis association rules dengan kolom:
  - **Antecedent (IF)**: Item pembeli
  - **Consequent (THEN)**: Item yang mungkin dibeli
  - **Support**: Frekuensi kemunculan
  - **Confidence**: Probabilitas rule
  - **Lift**: Kekuatan asosiasi (>1 = positif)

---

## 🏗️ Struktur Project

```
apriori-sales-app/
├── app/
│   ├── Http/Controllers/      # Controllers untuk routing
│   │   ├── DashboardController.php
│   │   ├── ProjectController.php
│   │   ├── DatasetController.php
│   │   └── AprioriController.php
│   ├── Models/                # Eloquent models
│   │   ├── User.php
│   │   ├── Project.php
│   │   ├── Dataset.php
│   │   ├── Transaction.php
│   │   └── Rule.php
│   ├── Services/              # Business logic
│   │   └── AprioriService.php # Implementasi algoritma Apriori
│   ├── Jobs/                  # Background jobs
│   │   └── RunAprioriJob.php
│   ├── Imports/               # Excel import handlers
│   │   └── TransactionsImport.php
│   └── Policies/              # Authorization policies
│       └── ProjectPolicy.php
├── database/migrations/       # Database schema
├── resources/views/           # Blade templates
│   ├── dashboard.blade.php
│   ├── projects/
│   ├── datasets/
│   └── apriori/
└── routes/web.php            # Application routes
```

---

## 🔧 Konfigurasi

### Database
Default menggunakan SQLite. Untuk menggunakan MySQL/PostgreSQL:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=apriori_sales
DB_USERNAME=root
DB_PASSWORD=
```

### Queue Driver
Default menggunakan `database`. Untuk Redis:

```env
QUEUE_CONNECTION=redis
REDIS_HOST=127.0.0.1
REDIS_PORT=6379
```

---

## 📊 Algoritma Apriori

Aplikasi ini mengimplementasikan algoritma Apriori untuk menemukan pola asosiasi:

1. **Generate Frequent Itemsets**: Menemukan kombinasi item yang sering muncul bersama
2. **Generate Rules**: Membuat aturan asosiasi dari frequent itemsets
3. **Calculate Metrics**:
   - **Support**: P(A ∪ B) - Frekuensi kemunculan
   - **Confidence**: P(B|A) - Probabilitas B jika A dibeli
   - **Lift**: P(B|A) / P(B) - Kekuatan korelasi

**Interpretasi Lift:**
- Lift > 1: Items positively correlated (sering dibeli bersama)
- Lift = 1: Items independent (tidak ada hubungan)
- Lift < 1: Items negatively correlated (jarang dibeli bersama)

---

## 🧪 Testing

```bash
# Run all tests
php artisan test

# Run specific test
php artisan test --filter=AprioriServiceTest
```

---

## 📝 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

## 👨‍💻 Developer

Developed with ❤️ using Laravel, Tailwind CSS, and Alpine.js

For issues or feature requests, please open an issue on GitHub.
