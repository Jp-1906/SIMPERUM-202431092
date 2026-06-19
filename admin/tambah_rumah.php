<?php
session_start();
include '../config/koneksi.php';

// Proteksi halaman admin
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: ../login.php");
    exit;
}

if(isset($_POST['simpan'])){
    $kode_rumah = $_POST['kode_rumah'];
    $alamat = $_POST['alamat'];
    $luas_tanah = $_POST['luas_tanah'];
    $luas_bangunan = $_POST['luas_bangunan'];
    $jumlah_kamar = $_POST['jumlah_kamar'];
    $jumlah_kamar_mandi = $_POST['jumlah_kamar_mandi'];
    $harga = $_POST['harga'];
    $status = $_POST['status'];
    $deskripsi = $_POST['deskripsi'];
    
    // FIX BUG: Ambil koordinat posisi X dan Y dari form input POST
    $posisi_x = $_POST['posisi_x'];
    $posisi_y = $_POST['posisi_y'];

    // FOTO RUMAH
    $foto_rumah = $_FILES['foto_rumah']['name'];
    $tmp_foto = $_FILES['foto_rumah']['tmp_name'];
    move_uploaded_file($tmp_foto, "../uploads/rumah/".$foto_rumah);

    // DENAH
    $denah_rumah = $_FILES['denah_rumah']['name'];
    $tmp_denah = $_FILES['denah_rumah']['tmp_name'];
    move_uploaded_file($tmp_denah, "../uploads/rumah/".$denah_rumah);

    // FIX BUG: Masukkan posisi_x dan posisi_y ke dalam query INSERT INTO
    mysqli_query($conn,"
        INSERT INTO rumah(
            kode_rumah, alamat, luas_tanah, luas_bangunan, 
            jumlah_kamar, jumlah_kamar_mandi, harga, status, 
            foto_rumah, denah_rumah, deskripsi, posisi_x, posisi_y
        )
        VALUES(
            '$kode_rumah', '$alamat', '$luas_tanah', '$luas_bangunan', 
            '$jumlah_kamar', '$jumlah_kamar_mandi', '$harga', '$status', 
            '$foto_rumah', '$denah_rumah', '$deskripsi', '$posisi_x', '$posisi_y'
        )
    ");

    header("Location: rumah.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Unit Rumah - SIMPERUM</title>
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
    select, input, textarea {
        width: 100%;
        box-sizing: border-box;
    }

    label {
        display: block;
        margin-bottom: 6px;
    }

    @media (max-width: 768px) {
        .content {
            padding: 85px 16px 25px 16px; /* Cegah benturan dengan mobile header topbar induk */
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
        <a href="rumah.php" style="text-decoration: none; color: #64748b;">Rumah</a>
        <span style="margin: 0 8px; color: #cbd5e1;">/</span> 
        <span style="color: #1e293b; font-weight: 600;">Tambah Rumah</span>
    </div>

    <h2 style="font-size: 28px; font-weight: 700; color: #1e293b; margin-bottom: 24px; letter-spacing: -0.5px;">
        Tambah Unit Properti Baru
    </h2>

    <div class="form-container">
        <form method="POST" enctype="multipart/form-data">
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 16px;">
                <div>
                    <label style="font-weight: 600; color: #1e293b; font-size: 14px;">Kode Rumah</label>
                    <input type="text" name="kode_rumah" placeholder="Contoh: R01" required>
                </div>
                <div>
                    <label style="font-weight: 600; color: #1e293b; font-size: 14px;">Harga Properti (Rupiah)</label>
                    <input type="number" name="harga" placeholder="Contoh: 500000000" required>
                </div>
                <div>
                    <label style="font-weight: 600; color: #1e293b; font-size: 14px;">Status Unit</label>
                    <select name="status">
                        <option value="tersedia">Tersedia</option>
                        <option value="dipesan">Dipesan</option>
                        <option value="dibangun">Dibangun</option>
                        <option value="terjual">Terjual</option>
                    </select>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(130px, 1fr)); gap: 20px; margin-bottom: 16px;">
                <div>
                    <label style="font-weight: 600; color: #1e293b; font-size: 14px;">Luas Tanah (m²)</label>
                    <input type="number" name="luas_tanah" required>
                </div>
                <div>
                    <label style="font-weight: 600; color: #1e293b; font-size: 14px;">Luas Bangunan (m²)</label>
                    <input type="number" name="luas_bangunan" required>
                </div>
                <div>
                    <label style="font-weight: 600; color: #1e293b; font-size: 14px;">Jumlah Kamar</label>
                    <input type="number" name="jumlah_kamar" required>
                </div>
                <div>
                    <label style="font-weight: 600; color: #1e293b; font-size: 14px;">Kamar Mandi</label>
                    <input type="number" name="jumlah_kamar_mandi" required>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 24px; background: #fafafa; padding: 16px; border-radius: var(--radius-md); border: 1px dashed var(--primary-gold);">
                <div>
                    <label style="font-weight: 700; color: var(--primary-gold); font-size: 14px;">Koordinat Peta: Posisi X (px)</label>
                    <input type="number" name="posisi_x" placeholder="Contoh: 120" required>
                </div>
                <div>
                    <label style="font-weight: 700; color: var(--primary-gold); font-size: 14px;">Koordinat Peta: Posisi Y (px)</label>
                    <input type="number" name="posisi_y" placeholder="Contoh: 250" required>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 16px;">
                <div>
                    <label style="font-weight: 600; color: #1e293b; font-size: 14px;">Foto Real Properti</label>
                    <input type="file" name="foto_rumah" style="border: 1px dashed #cbd5e1; padding: 8px;" required>
                </div>
                <div>
                    <label style="font-weight: 600; color: #1e293b; font-size: 14px;">Blueprint/Denah Rumah</label>
                    <input type="file" name="denah_rumah" style="border: 1px dashed #cbd5e1; padding: 8px;" required>
                </div>
            </div>

            <div style="margin-bottom: 16px;">
                <label style="font-weight: 600; color: #1e293b; font-size: 14px;">Alamat Lengkap</label>
                <textarea name="alamat" style="height: 80px; resize: vertical;" required></textarea>
            </div>

            <div style="margin-bottom: 32px;">
                <label style="font-weight: 600; color: #1e293b; font-size: 14px;">Deskripsi / Catatan Tambahan</label>
                <textarea name="deskripsi" style="height: 100px; resize: vertical;"></textarea>
            </div>

            <div class="btn-group" style="display: flex; gap: 12px; justify-content: flex-end;">
                <a href="rumah.php" class="btn" style="background: transparent; border: 1px solid #cbd5e1; color: #64748b; box-shadow: none;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='transparent'">Batal</a>
                <button type="submit" name="simpan" class="btn">Simpan Unit Rumah</button>
            </div>

        </form>
    </div>
</div>

</body>
</html>