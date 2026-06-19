<?php
session_start();
include '../config/koneksi.php';

// Proteksi halaman admin
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: ../login.php");
    exit;
}

$rumah = mysqli_query($conn, "SELECT * FROM rumah");
$tukang = mysqli_query($conn, "SELECT * FROM tukang");

if(isset($_POST['simpan'])){
    $id_rumah = $_POST['id_rumah'];
    $id_tukang = $_POST['id_tukang'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $status_kerja = $_POST['status_kerja'];

    mysqli_query($conn,"
        INSERT INTO penugasan_tukang(id_rumah, id_tukang, tanggal_mulai, status_kerja)
        VALUES('$id_rumah', '$id_tukang', '$tanggal_mulai', '$status_kerja')
    ");

    header("Location: penugasan.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Penugasan Tukang - SIMPERUM</title>
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
    select, input {
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
        <a href="penugasan.php" style="text-decoration: none; color: #64748b;">Penugasan</a>
        <span style="margin: 0 8px; color: #cbd5e1;">/</span> 
        <span style="color: #1e293b; font-weight: 600;">Tambah Penugasan</span>
    </div>

    <h2 style="font-size: 28px; font-weight: 700; color: #1e293b; margin-bottom: 24px; letter-spacing: -0.5px;">
        Tambah Penugasan Kerja Tukang
    </h2>

    <div class="form-container">
        <form method="POST">
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px; margin-bottom: 20px;">
                <div>
                    <label style="font-weight: 600; color: #1e293b; font-size: 14px;">Pilih Unit Rumah</label>
                    <select name="id_rumah" required style="cursor: pointer;">
                        <option value="">-- Pilih Kode Unit Rumah --</option>
                        <?php while($r = mysqli_fetch_assoc($rumah)){ ?>
                            <option value="<?= $r['id_rumah']; ?>">
                                <?= $r['kode_rumah']; ?> - Status Lapangan: <?= ucfirst($r['status']); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div>
                    <label style="font-weight: 600; color: #1e293b; font-size: 14px;">Pilih Tenaga Ahli (Tukang)</label>
                    <select name="id_tukang" required style="cursor: pointer;">
                        <option value="">-- Pilih Nama Tukang --</option>
                        <?php while($t = mysqli_fetch_assoc($tukang)){ ?>
                            <option value="<?= $t['id_tukang']; ?>">
                                <?= $t['nama_tukang']; ?> (Spesialisasi: <?= $t['spesialisasi']; ?>)
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 24px; margin-bottom: 32px;">
                <div>
                    <label style="font-weight: 600; color: #1e293b; font-size: 14px;">Tanggal Mulai Penugasan</label>
                    <input type="date" name="tanggal_mulai" required style="cursor: pointer;">
                </div>

                <div>
                    <label style="font-weight: 600; color: #1e293b; font-size: 14px;">Status Kerja Awal</label>
                    <select name="status_kerja" style="cursor: pointer;">
                        <option value="aktif">Aktif</option>
                        <option value="selesai">Selesai</option>
                    </select>
                </div>
            </div>

            <div class="btn-group" style="display: flex; gap: 12px; justify-content: flex-end;">
                <a href="penugasan.php" class="btn" style="background: transparent; border: 1px solid #cbd5e1; color: #64748b; box-shadow: none;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='transparent'">Batal</a>
                <button type="submit" name="simpan" class="btn">Simpan Penugasan</button>
            </div>

        </form>
    </div>
</div>

</body>
</html>