# SIMPERUM - Sistem Informasi & Manajemen Perumahan Berbasis Web

SIMPERUM adalah aplikasi manajemen real estate berbasis web yang dirancang untuk mendigitalisasi pemetaan denah komplek perumahan, monitoring progres konstruksi unit secara berkala, serta mempermudah konsultasi pemasaran properti secara transparan dan responsif.

Aplikasi ini telah aktif dan dapat diakses secara daring melalui tautan berikut:
🔗 **[Situs Resmi SIMPERUM](http://simperum.site.je)**

---

## Akun Demo Sistem (Test Credentials)

Untuk mencoba fungsionalitas penuh aplikasi, Anda dapat menggunakan akun uji coba di bawah ini pada halaman login:

### 1. Hak Akses Admin (Admin Panel)
* **Email:** `admin@simperum.com`
* **Password:** `admin123`

### 2. Hak Akses Pengguna (User Panel)
* **Email:** `jp@gmail.com`
* **Password:** `123456`
* *Catatan: Anda juga dapat mendaftarkan akun baru secara mandiri melalui menu registrasi.*

---

## Fitur Utama & Antarmuka Sistem

### 1. Gerbang Masuk Autentikasi (`login.php`)
Sistem dilengkapi dengan pembatasan hak akses (*Role-Based Access Control*) menggunakan enkripsi basis data untuk memisahkan otoritas kerja antara akun Admin dan User. Desain boks dirancang minimalis dan elegan dengan aksen garis emas.

![Halaman Login SIMPERUM](image_1fad21.png)

### 2. Denah Komplek Interaktif (`user/denah.php`)
Peta visual tata letak blok perumahan berbasis sistem koordinat piksel X dan Y dinamis. Kotak unit rumah otomatis berubah warna berdasarkan status riil di database dan dapat diklik untuk meninjau data properti.
* **Hijau:** Tersedia
* **Merah:** Dipesan
* **Biru:** Dibangun
* **Abu-abu:** Terjual

![Denah Komplek Interaktif](image_1fb1b8.png)

### 3. Katalog Daftar Rumah (`user/rumah_user.php`)
Daftar inventaris properti siap huni maupun indent yang disajikan dalam bentuk *card grid* proporsional, lengkap dengan foto unit, kode blok, lencana (*badge*) status, serta potongan deskripsi bangunan.

![Katalog Daftar Rumah](image_1fb0e3.png)

### 4. Detail Unit & Hubungi Marketing (`user/detail_rumah.php`)
Menampilkan spesifikasi mendalam nilai investasi unit, alamat lokasi, riwayat rekam jejak pembangunan fisik lapangan, serta daftar pekerja konstruksi aktif. Dilengkapi formulir kirim pesan otomatis ke email developer (`naufalrizky.j.p@gmail.com`) serta tombol pintas WhatsApp dan Instagram Marketing.

![Detail Unit Properti](image_1fadfc.jpg)

### 5. Manajemen Data Admin (`admin/rumah.php`)
Panel kendali internal bagi pihak pengembang untuk memanipulasi data (*CRUD*), mengontrol titik koordinat denah, mendaftarkan tenaga ahli (tukang), membagikan penugasan kerja, serta memperbarui persentase progres fisik bangunan beserta unggah foto bukti lapangan.

![Tabel Manajemen Data Rumah](image_1fad9c.jpg)

---

## Struktur Direktori Proyek

```text
📂 simperum/
├── 📂 admin/
│   ├── dashboard.php         # Panel utama kendali data admin
│   ├── rumah.php             # Tabel manajemen properti & kontrol koordinat
│   ├── tambah_rumah.php      # Form input rumah & koordinat piksel denah
│   ├── edit_rumah.php        # Form pembaruan properti & berkas gambar
│   ├── tukang.php            # Tabel data master tenaga ahli konstruksi
│   ├── tambah_tukang.php     # Form registrasi pekerja baru
│   ├── edit_tukang.php       # Form pembaharuan profil tukang
│   ├── penugasan.php         # Manajemen alokasi kerja pekerja lapangan
│   ├── tambah_penugasan.php  # Form penugasan tukang ke unit rumah
│   ├── edit_penugasan.php    # Form update status kerja & tanggal selesai
│   ├── progress.php          # Monitor rekam jejak pembangunan fisik
│   ├── tambah_progress.php   # Form input persentase progres + foto bukti
│   └── edit_progress.php     # Form revisi log pembangunan fisik
├── 📂 user/
│   ├── dashboard.php         # Panel navigasi ringkas pengguna
│   ├── denah.php             # Peta interaktif denah komplek dinamis
│   ├── rumah_user.php        # Katalog daftar rumah komparatif
│   └── detail_rumah.php      # Informasi menyeluruh unit & form kontak
├── 📂 config/
│   └── koneksi.php           # Berkas konfigurasi basis data MySQLi
├── 📂 css/
│   └── style.css             # Lembar gaya arsitektur antarmuka global
├── 📂 uploads/
│   ├── 📂 rumah/             # Penyimpanan berkas foto & denah unit
│   ├── 📂 tukang/            # Penyimpanan foto profil pekerja
│   └── 📂 progress/          # Penyimpanan gambar bukti fisik lapangan
├── login.php                 # Gerbang masuk autentikasi sistem
├── register.php              # Form pendaftaran akun user mandiri
└── logout.php                # Pemutus sesi session & pembersih session login
