# CLAUDE.md — Init Project: apriori-sales-app (Laravel Version)

> Panduan inisialisasi proyek **apriori-sales-app**, sebuah aplikasi berbasis **Laravel** untuk analisis asosiasi menggunakan algoritma **Apriori**. Aplikasi ini memiliki sistem autentikasi multi-user, dashboard responsif, fitur import data penjualan, pembuatan project analisa, dan visualisasi hasil dalam bentuk tabel serta grafik.

---

## 1. Tujuan Proyek

* Membuat aplikasi berbasis **Laravel + Blade/Tailwind** (atau **Laravel + React/Inertia.js**) yang memungkinkan setiap user:

  1. Melakukan **registrasi dan login** secara aman.
  2. **Mengimpor data penjualan** (CSV/Excel) ke dalam database.
  3. Membuat **Project Analisa**, di mana setiap project memiliki dataset sendiri.
  4. Menjalankan **algoritma Apriori** untuk menemukan pola asosiasi dari data.
  5. Melihat hasil analisa dalam bentuk **tabel dan chart interaktif**.
* Data antar user **tidak boleh bercampur (multi-tenant)**.
* Aplikasi harus **responsif**, **aman**, dan **mudah dikembangkan**.

---

## 2. Teknologi & Library yang Digunakan

### Backend (Laravel)

* **Framework:** Laravel 11+
* **Auth:** Laravel Breeze / Jetstream (pilih sesuai kebutuhan UI)
* **Import Data:** [maatwebsite/excel](https://github.com/Maatwebsite/Laravel-Excel)
* **Algoritma Apriori:** Implementasi di service Laravel atau koneksi ke Python (via API)
* **Database:** MySQL / PostgreSQL
* **Queue / Job:** Laravel Queue (database/redis) untuk eksekusi Apriori async
* **Chart:** Laravel Charts (ConsoleTVs/Charts) atau frontend Chart.js

### Frontend

* **UI:** Tailwind CSS + Alpine.js
* **Charting:** Chart.js atau ApexCharts
* **Responsive Layout:** Tailwind + Grid/Flex

---

## 3. Struktur Folder

```
apriori-sales-app/
├─ app/
│  ├─ Http/Controllers/
│  │  ├─ Auth/
│  │  ├─ DashboardController.php
│  │  ├─ ImportController.php
│  │  ├─ ProjectController.php
│  │  └─ AprioriController.php
│  ├─ Models/
│  │  ├─ User.php
│  │  ├─ Project.php
│  │  ├─ Dataset.php
│  │  └─ Rule.php
│  ├─ Services/
│  │  └─ AprioriService.php
│  └─ Jobs/
│     └─ RunAprioriJob.php
├─ database/migrations/
├─ resources/views/
│  ├─ layouts/
│  ├─ dashboard.blade.php
│  ├─ projects/
│  └─ results/
├─ routes/web.php
├─ public/
│  └─ uploads/
└─ composer.json
```

---

## 4. Skema Database

### users

| Field      | Type      | Description   |
| ---------- | --------- | ------------- |
| id         | bigint    | Primary key   |
| name       | varchar   | Nama user     |
| email      | varchar   | Unique email  |
| password   | varchar   | Password hash |
| created_at | timestamp |               |
| updated_at | timestamp |               |

### projects

| Field          | Type      | Description          |
| -------------- | --------- | -------------------- |
| id             | bigint    | Primary key          |
| user_id        | bigint    | Foreign key ke users |
| name           | varchar   | Nama proyek          |
| description    | text      | Keterangan           |
| min_support    | float     | Minimum support      |
| min_confidence | float     | Minimum confidence   |
| created_at     | timestamp |                      |
| updated_at     | timestamp |                      |

### datasets

| Field        | Type     | Description       |
| ------------ | -------- | ----------------- |
| id           | bigint   | Primary key       |
| project_id   | bigint   | FK ke projects    |
| file_name    | varchar  | Nama file asli    |
| storage_path | varchar  | Path file upload  |
| row_count    | int      | Jumlah baris data |
| imported_at  | datetime | Waktu import      |

### rules

| Field      | Type      | Description         |
| ---------- | --------- | ------------------- |
| id         | bigint    | Primary key         |
| project_id | bigint    | FK ke projects      |
| antecedent | json      | Item sebelum aturan |
| consequent | json      | Item hasil aturan   |
| support    | float     | Nilai support       |
| confidence | float     | Nilai confidence    |
| lift       | float     | Nilai lift          |
| created_at | timestamp |                     |

---

## 5. Alur Aplikasi

1. **User Register & Login**  → masuk ke dashboard.
2. **Dashboard**  → menampilkan daftar project dan hasil analisa terakhir.
3. **Buat Project Baru**  → isi parameter min_support & min_confidence.
4. **Import Data Penjualan**  → upload CSV/Excel (kolom: `transaction_id`, `item_name`).
5. **Sistem Jalankan Apriori**  → dijalankan oleh job queue.
6. **Hasil Disimpan ke DB**  → tabel `rules`.
7. **Tampilan Hasil**  → tabel asosiasi + chart (support/confidence/lift).

---

## 6. Responsivitas UI

* Gunakan **Tailwind CSS** + layout grid.
* Pastikan semua tabel dan chart **auto-scroll horizontal** di layar kecil.
* Gunakan **daisyUI** atau **Flowbite** untuk komponen siap pakai (cards, nav, modal).

---

## 7. AI Enhancer Script (opsional)

> Folder `ai-enhancer/` digunakan untuk membantu sistem AI memahami arsitektur base Laravel dan mempercepat pembuatan boilerplate.

### ai-enhancer/blueprint.json

```json
{
  "framework": "laravel",
  "modules": ["auth", "dashboard", "project", "import", "apriori"],
  "models": ["User", "Project", "Dataset", "Rule"],
  "relations": {
    "User": ["hasMany:Project"],
    "Project": ["belongsTo:User", "hasMany:Dataset", "hasMany:Rule"],
    "Dataset": ["belongsTo:Project"],
    "Rule": ["belongsTo:Project"]
  },
  "features": {
    "responsive": true,
    "multi_tenant": true,
    "import_excel": true,
    "background_jobs": true,
    "chart_visualization": true
  }
}
```

---

## 8. Tahap Selanjutnya

* [ ] Setup Laravel + Breeze (auth dasar)
* [ ] Buat migration tabel `projects`, `datasets`, `rules`
* [ ] Buat service Apriori sederhana
* [ ] Implementasikan import Excel via Maatwebsite
* [ ] Buat tampilan dashboard responsif + chart
* [ ] Jalankan analisa dengan queue/job dan tampilkan hasil

---

**Output akhir:** aplikasi Laravel responsif dengan autentikasi, dashboard, import data penjualan per user, project analisa Apriori, dan hasil visual interaktif (tabel + chart).
