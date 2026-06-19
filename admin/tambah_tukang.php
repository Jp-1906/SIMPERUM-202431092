<?php
session_start();
include '../config/koneksi.php';

// Proteksi halaman admin
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: ../login.php");
    exit;
}

if(isset($_POST['simpan'])){
    $nama_tukang = $_POST['nama_tukang'];
    $spesialisasi = $_POST['spesialisasi'];
    $no_hp = $_POST['no_hp'];
    $alamat = $_POST['alamat'];

    // FOTO PROFIL TUKANG
    $foto_profil = $_FILES['foto_profil']['name'];
    $tmp_foto = $_FILES['foto_profil']['tmp_name'];

    move_uploaded_file($tmp_foto, "../uploads/tukang/".$foto_profil);

    mysqli_query($conn,"
        INSERT INTO tukang(nama_tukang, spesialisasi, no_hp, alamat, foto_profil)
        VALUES('$nama_tukang', '$spesialisasi', '$no_hp', '$alamat', '$foto_profil')
    ");

    header("Location: tukang.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Tukang - SIMPERUM</title>
    <link rel="stylesheet" href="../css/style.css">
    
    <style>
    body {
        margin: 0;
        background: #f8f8f8;
        font-family: inherit;
    }

    .content {
        padding: 25px;
        box-sizing: border-box;
    }

    .form-container {
        background: white; 
        padding: 32px; 
        border-radius: var(--radius-lg); 
        box-shadow: var(--shadow-md);
    }

    /* Penataan global form agar tidak overflow di mobile */
    input[type="text"], input[type="file"], textarea {
        width: 100%;
        box-sizing: border-box;
    }

    label {
        display: block;
        margin-bottom: 6px;
    }

    @media (max-width: 768px) {
        .content {
            padding: 85px 16px 25px 16px; /* Jarak atas aman dari mobile header topbar induk */
        }

        .form-container {
            padding: 24px 16px;
        }

        .btn-group {
            flex-direction: column-reverse;
            gap: 10px;
        }

        .btn-group a, .btn-group button {
            width: 100%;
            text-align: center;
            box-sizing: border-box;
        }
    }
    </style>
</head>
<body>

<div class="content">
    <div class="breadcrumb">
        <a href="dashboard.php" style="text-decoration: none; color: #64748b;">Dashboard</a> 
        <span style="margin: 0 8px; color: #cbd5e1;">/</span> 
        <a href="tukang.php" style="text-decoration: none; color: #64748b;">Tukang</a>
        <span style="margin: 0 8px; color: #cbd5e1;">/</span> 
        <span style="color: #1e293b; font-weight: 600;">Tambah Tukang</span>
    </div>

    <h2 style="font-size: 28px; font-weight: 700; color: #1e293b; margin-bottom: 24px; letter-spacing: -0.5px;">
        Registrasi Data Tukang Baru
    </h2>

    <div class="form-container">
        <form method="POST" enctype="multipart/form-data">
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-bottom: 16px;">
                <div>
                    <label style="font-weight: 600; color: #1e293b; font-size: 14px;">Nama Lengkap Tukang</label>
                    <input type="text" name="nama_tukang" placeholder="Nama Lengkap" required>
                </div>
                <div>
                    <label style="font-weight: 600; color: #1e293b; font-size: 14px;">Nomor HP / WhatsApp</label>
                    <input type="text" name="no_hp" placeholder="Contoh: 08123456789" required>
                </div>
                <div>
                    <label style="font-weight: 600; color: #1e293b; font-size: 14px;">Spesialisasi Ahli</label>
                    <input type="text" name="spesialisasi" placeholder="Contoh: Cat, Pondasi, Kusen" required>
                </div>
            </div>

            <div style="margin-bottom: 16px;">
                <label style="font-weight: 600; color: #1e293b; font-size: 14px;">Foto Profil Resmi</label>
                <input type="file" name="foto_profil" style="border: 1px dashed #cbd5e1; padding: 8px;" required>
            </div>

            <div style="margin-bottom: 32px;">
                <label style="font-weight: 600; color: #1e293b; font-size: 14px;">Alamat Tinggal</label>
                <textarea name="alamat" style="height: 100px; resize: vertical;" placeholder="Tuliskan alamat lengkap tinggal saat ini..."></textarea>
            </div>

            <div class="btn-group" style="display: flex; gap: 12px; justify-content: flex-end;">
                <a href="tukang.php" class="btn" style="background: transparent; border: 1px solid #cbd5e1; color: #64748b; box-shadow: none;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='transparent'">Batal</a>
                <button type="submit" name="simpan" class="btn">Simpan Data Tukang</button>
            </div>

        </form>
    </div>
</div>

</body>
</html>