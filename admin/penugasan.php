<?php
session_start();
include '../config/koneksi.php';

// Proteksi halaman admin
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: ../login.php");
    exit;
}

$query = mysqli_query($conn,"
    SELECT
        penugasan_tukang.*,
        rumah.kode_rumah,
        tukang.nama_tukang,
        tukang.spesialisasi
    FROM penugasan_tukang
    INNER JOIN rumah ON penugasan_tukang.id_rumah = rumah.id_rumah
    INNER JOIN tukang ON penugasan_tukang.id_tukang = tukang.id_tukang
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penugasan Tukang - SIMPERUM</title>
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

    .table-responsive {
        background: white; 
        border-radius: var(--radius-lg); 
        box-shadow: var(--shadow-md); 
        border: 1px solid var(--border-color); 
        overflow-x: auto;
        -webkit-overflow-scrolling: touch; /* Scroll halus di perangkat iOS */
    }

    /* Memastikan tabel memiliki lebar minimum di layar kecil agar teks tidak berdesakan */
    table {
        width: 100%; 
        border-collapse: collapse; 
        text-align: left; 
        font-size: 14px;
        min-width: 900px; 
    }

    @media (max-width: 768px) {
        .content {
            padding: 85px 16px 25px 16px; /* Mencegah konten tertutup oleh topbar induk mobile */
        }

        .header-title {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 12px;
        }

        .header-title h2 {
            font-size: 24px !important;
        }

        .btn-group-header {
            width: 100%;
            justify-content: flex-start;
        }
        
        .btn-group-header a {
            flex: 1;
            text-align: center;
        }
    }
    </style>
</head>
<body>

<div class="content">
    
    <div class="breadcrumb">
        <a href="dashboard.php" style="text-decoration: none; color: #64748b;">Dashboard</a> 
        <span style="margin: 0 8px; color: #cbd5e1;">/</span> 
        <span style="color: #1e293b; font-weight: 600;">Penugasan</span>
    </div>

    <div class="header-title" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
        <h2 style="font-size: 28px; font-weight: 700; color: #1e293b; letter-spacing: -0.5px; margin: 0;">
            Penugasan Kerja Tukang
        </h2>
        <div class="btn-group-header" style="display: flex; gap: 12px; flex-wrap: wrap;">
            <a href="tukang.php" class="btn" style="text-decoration: none; background: transparent; border: 1px solid var(--primary-gold); color: var(--primary-gold); box-shadow: none; font-size: 13px;" onmouseover="this.style.background='var(--gold-light)'" onmouseout="this.style.background='transparent'">
                Kelola Data Tukang
            </a>
            <a href="tambah_penugasan.php" class="btn" style="text-decoration: none; font-size: 13px;">
                + Tambah Penugasan
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr style="background: #fafafa; border-bottom: 2px solid var(--border-color);">
                    <th style="padding: 16px 20px; color: #64748b; font-weight: 600; width: 60px; text-align: center;">No</th>
                    <th style="padding: 16px 20px; color: #64748b; font-weight: 600; width: 120px;">Unit Rumah</th>
                    <th style="padding: 16px 20px; color: #64748b; font-weight: 600;">Nama Tukang</th>
                    <th style="padding: 16px 20px; color: #64748b; font-weight: 600;">Keahlian</th>
                    <th style="padding: 16px 20px; color: #64748b; font-weight: 600; width: 140px;">Tanggal Mulai</th>
                    <th style="padding: 16px 20px; color: #64748b; font-weight: 600; width: 140px;">Tanggal Selesai</th>
                    <th style="padding: 16px 20px; color: #64748b; font-weight: 600; width: 130px; text-align: center;">Status</th>
                    <th style="padding: 16px 20px; color: #64748b; font-weight: 600; width: 140px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                while($data = mysqli_fetch_assoc($query)){
                    
                    // Logika pewarnaan dinamis untuk status kerja tukang
                    $statusKerja = strtolower($data['status_kerja']);
                    $badgeBg = "rgba(14, 165, 233, 0.15)"; // Default Sky Blue (proses/pending)
                    $badgeColor = "#0284c7";
                    
                    if($statusKerja == 'selesai') {
                        $badgeBg = "rgba(16, 185, 129, 0.15)"; // Emerald Green
                        $badgeColor = "#059669";
                    } elseif($statusKerja == 'istirahat' || $statusKerja == 'tertunda') {
                        $badgeBg = "rgba(244, 63, 94, 0.15)"; // Rose Red
                        $badgeColor = "#e11d48";
                    }
                ?>
                <tr style="border-bottom: 1px solid var(--border-color); transition: background 0.2s;" onmouseover="this.style.background='#fdfbf7'" onmouseout="this.style.background='transparent'">
                    
                    <td style="padding: 16px 20px; text-align: center; color: #94a3b8; font-weight: 500;"><?= $no++; ?></td>
                    
                    <td style="padding: 16px 20px; font-weight: 700; color: var(--primary-gold);"><?= $data['kode_rumah']; ?></td>
                    
                    <td style="padding: 16px 20px; font-weight: 600; color: #1e293b;"><?= $data['nama_tukang']; ?></td>
                    
                    <td style="padding: 16px 20px; color: #64748b;"><?= $data['spesialisasi']; ?></td>
                    
                    <td style="padding: 16px 20px; color: #1e293b; font-weight: 500;">
                        <?= !empty($data['tanggal_mulai']) ? date('d M Y', strtotime($data['tanggal_mulai'])) : '-'; ?>
                    </td>
                    
                    <td style="padding: 16px 20px; color: #1e293b; font-weight: 500;">
                        <?= !empty($data['tanggal_selesai']) ? date('d M Y', strtotime($data['tanggal_selesai'])) : '<span style="color:#94a3b8; font-style:italic; font-size:12px;">Dalam proses</span>'; ?>
                    </td>
                    
                    <td style="padding: 16px 20px; text-align: center;">
                        <span style="background: <?= $badgeBg; ?>; color: <?= $badgeColor; ?>; padding: 4px 12px; font-size: 12px; font-weight: 600; border-radius: 100px; display: inline-block; text-transform: capitalize;">
                            <?= $data['status_kerja']; ?>
                        </span>
                    </td>
                    
                    <td style="padding: 16px 20px; text-align: center;">
                        <div style="display: flex; gap: 12px; justify-content: center; align-items: center;">
                            <a href="edit_penugasan.php?id=<?= $data['id_penugasan']; ?>" style="text-decoration: none; color: var(--primary-gold); font-weight: 600; font-size: 13px; transition: opacity 0.2s;" onmouseover="this.style.opacity='0.7'" onmouseout="this.style.opacity='1'">
                                Edit
                            </a>
                            <span style="color: #cbd5e1; font-size: 12px;">|</span>
                            <a href="hapus_penugasan.php?id=<?= $data['id_penugasan']; ?>" style="text-decoration: none; color: #f43f5e; font-weight: 600; font-size: 13px; transition: opacity 0.2s;" onmouseover="this.style.opacity='0.7'" onmouseout="this.style.opacity='1'" onclick="return confirm('Yakin ingin menghapus penugasan <?= $data['nama_tukang']; ?> di unit <?= $data['kode_rumah']; ?>?')">
                                Hapus
                            </a>
                        </div>
                    </td>

                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>