<?php
session_start();
include '../config/koneksi.php';

// Proteksi halaman admin
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: ../login.php");
    exit;
}

// Mengambil ID Penugasan dari parameter URL
$id = $_GET['id'];

// Query mengambil data penugasan yang sedang dipilih
$query_penugasan = mysqli_query($conn, "SELECT * FROM penugasan_tukang WHERE id_penugasan='$id'");
$data = mysqli_fetch_assoc($query_penugasan);

// Master data untuk pilihan dropdown relasi
$rumah = mysqli_query($conn, "SELECT * FROM rumah");
$tukang = mysqli_query($conn, "SELECT * FROM tukang");

if(isset($_POST['update'])){
    $id_rumah = $_POST['id_rumah'];
    $id_tukang = $_POST['id_tukang'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_selesai = !empty($_POST['tanggal_selesai']) ? $_POST['tanggal_selesai'] : NULL;
    $status_kerja = $_POST['status_kerja'];

    // Jika tanggal selesai kosong, set ke NULL di query database
    if($tanggal_selesai) {
        $update_query = "UPDATE penugasan_tukang SET 
                            id_rumah='$id_rumah', 
                            id_tukang='$id_tukang', 
                            tanggal_mulai='$tanggal_mulai', 
                            tanggal_selesai='$tanggal_selesai', 
                            status_kerja='$status_kerja' 
                         WHERE id_penugasan='$id'";
    } else {
        $update_query = "UPDATE penugasan_tukang SET 
                            id_rumah='$id_rumah', 
                            id_tukang='$id_tukang', 
                            tanggal_mulai='$tanggal_mulai', 
                            tanggal_selesai=NULL, 
                            status_kerja='$status_kerja' 
                         WHERE id_penugasan='$id'";
    }

    mysqli_query($conn, $update_query);

    header("Location: penugasan.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Penugasan Tukang - SIMPERUM</title>
    <link rel="stylesheet" href="../css/style.css">
    
    <style>
    body {
        margin: 0;
        background: #f8f8f8;
        font-family: inherit;
    }

    /* --- CONTENT WRAPPER DENGAN BREAKPOINT MOBILE --- */
    .content {
        margin-left: 0; /* Diatur dinamis jika menempel pada file induk index sidebar */
        padding: 25px;
        box-sizing: border-box;
    }

    /* Penyesuaian responsif untuk form wrapper container */
    .form-container {
        background: white; 
        padding: 32px; 
        border-radius: var(--radius-lg); 
        box-shadow: var(--shadow-md);
    }

    /* Menangani lebar dinamis pembungkus kolom status kerja */
    .status-field {
        margin-bottom: 32px; 
        width: 50%;
    }

    @media (max-width: 768px) {
        .content {
            padding: 85px 16px 25px 16px; /* Tambah jarak atas agar tidak tertabrak mobile header topbar */
        }
        
        .form-container {
            padding: 24px 16px; /* Perkecil padding kontainer di layar HP */
        }

        .status-field {
            width: 100%; /* Melebarkan dropdown status kerja penuhin layar di HP */
        }
        
        /* Mengubah orientasi tombol aksi menjadi penuh ke bawah di mobile */
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
        <span style="color: #1e293b; font-weight: 600;">Edit Penugasan</span>
    </div>

    <h2 style="font-size: 28px; font-weight: 700; color: #1e293b; margin-bottom: 24px; letter-spacing: -0.5px;">
        Edit Penugasan Kerja Tukang
    </h2>

    <div class="form-container">
        <form method="POST">
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px; margin-bottom: 20px;">
                <div>
                    <label style="font-weight: 600; color: #1e293b; font-size: 14px; display: block; margin-bottom: 6px;">Pilih Unit Rumah</label>
                    <select name="id_rumah" required style="cursor: pointer; width: 100%;">
                        <?php while($r = mysqli_fetch_assoc($rumah)){ ?>
                            <option value="<?= $r['id_rumah']; ?>" <?= ($r['id_rumah'] == $data['id_rumah']) ? 'selected' : ''; ?>>
                                <?= $r['kode_rumah']; ?> - Status Lapangan: <?= ucfirst($r['status']); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div>
                    <label style="font-weight: 600; color: #1e293b; font-size: 14px; display: block; margin-bottom: 6px;">Pilih Tenaga Ahli (Tukang)</label>
                    <select name="id_tukang" required style="cursor: pointer; width: 100%;">
                        <?php while($t = mysqli_fetch_assoc($tukang)){ ?>
                            <option value="<?= $t['id_tukang']; ?>" <?= ($t['id_tukang'] == $data['id_tukang']) ? 'selected' : ''; ?>>
                                <?= $t['nama_tukang']; ?> (Spesialisasi: <?= $t['spesialisasi']; ?>)
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 24px; margin-bottom: 20px;">
                <div>
                    <label style="font-weight: 600; color: #1e293b; font-size: 14px; display: block; margin-bottom: 6px;">Tanggal Mulai Penugasan</label>
                    <input type="date" name="tanggal_mulai" value="<?= $data['tanggal_mulai']; ?>" required style="cursor: pointer; width: 100%; box-sizing: border-box;">
                </div>

                <div>
                    <label style="font-weight: 600; color: #1e293b; font-size: 14px; display: block; margin-bottom: 6px;">Tanggal Selesai Penugasan <span style="font-size:12px; color:#94a3b8; font-weight:400;">(Kosongkan jika aktif)</span></label>
                    <input type="date" name="tanggal_selesai" value="<?= $data['tanggal_selesai']; ?>" style="cursor: pointer; width: 100%; box-sizing: border-box;">
                </div>
            </div>

            <div class="status-field">
                <label style="font-weight: 600; color: #1e293b; font-size: 14px; display: block; margin-bottom: 6px;">Status Kerja Terkini</label>
                <select name="status_kerja" style="cursor: pointer; width: 100%;">
                    <option value="aktif" <?= ($data['status_kerja'] == 'aktif') ? 'selected' : ''; ?>>Aktif</option>
                    <option value="selesai" <?= ($data['status_kerja'] == 'selesai') ? 'selected' : ''; ?>>Selesai</option>
                </select>
            </div>

            <div class="btn-group" style="display: flex; gap: 12px; justify-content: flex-end;">
                <a href="penugasan.php" class="btn" style="background: transparent; border: 1px solid #cbd5e1; color: #64748b; box-shadow: none;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='transparent'">Batal</a>
                <button type="submit" name="update" class="btn">Perbarui Penugasan</button>
            </div>

        </form>
    </div>
</div>

</body>
</html>