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
        progress_pembangunan.*,
        rumah.kode_rumah
    FROM progress_pembangunan
    INNER JOIN rumah ON progress_pembangunan.id_rumah = rumah.id_rumah
    ORDER BY tanggal_progress DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progress Pembangunan - SIMPERUM</title>
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
        -webkit-overflow-scrolling: touch;
    }

    table {
        width: 100%; 
        border-collapse: collapse; 
        text-align: left; 
        font-size: 14px;
        min-width: 850px; /* Batas minimal lebar tabel agar tidak berdesakan di layar HP */
    }

    @media (max-width: 768px) {
        .content {
            padding: 85px 16px 25px 16px; /* Jarak atas agar tidak tertutup header mobile induk */
        }

        .header-title {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 12px;
        }

        .header-title h2 {
            font-size: 24px !important;
        }

        .header-title a {
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
        <span style="color: #1e293b; font-weight: 600;">Progress</span>
    </div>

    <div class="header-title" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
        <h2 style="font-size: 28px; font-weight: 700; color: #1e293b; letter-spacing: -0.5px; margin: 0;">
            Monitoring Progress Pembangunan
        </h2>
        <a href="tambah_progress.php" class="btn" style="text-decoration: none; font-size: 13px;">
            + Tambah Progress
        </a>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr style="background: #fafafa; border-bottom: 2px solid var(--border-color);">
                    <th style="padding: 16px 20px; color: #64748b; font-weight: 600; width: 60px; text-align: center;">No</th>
                    <th style="padding: 16px 20px; color: #64748b; font-weight: 600; width: 120px;">Unit Rumah</th>
                    <th style="padding: 16px 20px; color: #64748b; font-weight: 600; width: 220px;">Persentase Fisik</th>
                    <th style="padding: 16px 20px; color: #64748b; font-weight: 600;">Keterangan Status</th>
                    <th style="padding: 16px 20px; color: #64748b; font-weight: 600; width: 140px;">Tanggal Update</th>
                    <th style="padding: 16px 20px; color: #64748b; font-weight: 600; width: 120px; text-align: center;">Foto Lapangan</th>
                    <th style="padding: 16px 20px; color: #64748b; font-weight: 600; width: 140px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                while($data = mysqli_fetch_assoc($query)){
                    
                    $statusProg = strtolower(trim($data['status_progress']));
                    
                    $badgeBg = "rgba(212, 175, 55, 0.15)"; 
                    $badgeColor = "#b89322";
                    
                    if($statusProg == 'selesai' || $data['persentase'] == 100) {
                        $badgeBg = "rgba(16, 185, 129, 0.15)"; 
                        $badgeColor = "#059669";
                    } elseif($statusProg == 'berjalan') {
                        $badgeBg = "rgba(14, 165, 233, 0.15)"; 
                        $badgeColor = "#0284c7";
                    }
                ?>
                <tr style="border-bottom: 1px solid var(--border-color); transition: background 0.2s;" onmouseover="this.style.background='#fdfbf7'" onmouseout="this.style.background='transparent'">
                    
                    <td style="padding: 16px 20px; text-align: center; color: #94a3b8; font-weight: 500;"><?= $no++; ?></td>
                    
                    <td style="padding: 16px 20px; font-weight: 700; color: var(--primary-gold);"><?= $data['kode_rumah']; ?></td>
                    
                    <td style="padding: 16px 20px;">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <span style="font-weight: 700; color: #1e293b; min-width: 40px; text-align: right;">
                                <?= $data['persentase']; ?>%
                            </span>
                            <div style="flex-grow: 1; height: 8px; background: #f1f5f9; border-radius: 100px; overflow: hidden; border: 1px solid #e2e8f0;">
                                <div style="width: <?= $data['persentase']; ?>%; height: 100%; background: var(--gold-gradient); border-radius: 100px;"></div>
                            </div>
                        </div>
                    </td>
                    
                    <td style="padding: 16px 20px;">
                        <span style="background: <?= $badgeBg; ?>; color: <?= $badgeColor; ?>; padding: 4px 12px; font-size: 12px; font-weight: 600; border-radius: 100px; display: inline-block;">
                            <?= !empty($data['status_progress']) ? $data['status_progress'] : '-'; ?>
                        </span>
                    </td>
                    
                    <td style="padding: 16px 20px; color: #64748b; font-weight: 500;">
                        <?= date('d M Y', strtotime($data['tanggal_progress'])); ?>
                    </td>
                    
                    <td style="padding: 16px 20px; text-align: center;">
                        <div style="width: 70px; height: 50px; border-radius: var(--radius-sm); overflow: hidden; background: #f1f5f9; border: 1px solid var(--border-color); margin: 0 auto; box-shadow: 0 2px 6px rgba(0,0,0,0.04);">
                            <?php 
                            $img_path = "../uploads/progress/" . $data['foto_progress'];
                            if(!empty($data['foto_progress']) && file_exists($img_path)): 
                            ?>
                                <img src="<?= $img_path; ?>" style="width: 100%; height: 100%; object-fit: cover;">
                            <?php else: ?>
                                <img src="https://images.unsplash.com/photo-1541888946425-d81bb19240f5?auto=format&fit=crop&w=150&q=80" style="width: 100%; height: 100%; object-fit: cover;">
                            <?php endif; ?>
                        </div>
                    </td>
                    
                    <td style="padding: 16px 20px; text-align: center;">
                        <div style="display: flex; gap: 12px; justify-content: center; align-items: center;">
                            <a href="edit_progress.php?id=<?= $data['id_progress']; ?>" style="text-decoration: none; color: var(--primary-gold); font-weight: 600; font-size: 13px; transition: opacity 0.2s;" onmouseover="this.style.opacity='0.7'" onmouseout="this.style.opacity='1'">
                                Edit
                            </a>
                            <span style="color: #cbd5e1; font-size: 12px;">|</span>
                            <a href="hapus_progress.php?id=<?= $data['id_progress']; ?>" style="text-decoration: none; color: #f43f5e; font-weight: 600; font-size: 13px; transition: opacity 0.2s;" onmouseover="this.style.opacity='0.7'" onmouseout="this.style.opacity='1'" onclick="return confirm('Yakin ingin menghapus rekaman progress unit <?= $data['kode_rumah']; ?>?')">
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