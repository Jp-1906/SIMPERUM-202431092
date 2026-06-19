<?php
session_start();
include '../config/koneksi.php';

// Proteksi halaman admin
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: ../login.php");
    exit;
}

$query = mysqli_query($conn, "SELECT * FROM rumah");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Rumah - SIMPERUM</title>
    <link rel="stylesheet" href="../css/style.css">
    
    <style>
    body {
        margin: 0;
        background: #f8f8f8;
        font-family: inherit;
    }

    /* --- LAYOUT MOBILE NAVIGATION --- */
    .mobile-header {
        display: none;
        background: white;
        padding: 15px 20px;
        align-items: center;
        justify-content: space-between;
        border-bottom: 2px solid #d4af37;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        position: fixed;
        top: 0; left: 0; right: 0;
        z-index: 999;
    }

    .hamburger-btn {
        background: none;
        border: none;
        font-size: 24px;
        color: #d4af37;
        cursor: pointer;
    }

    .sidebar {
        width: 240px;
        height: 100vh;
        position: fixed;
        top: 0; left: 0;
        background: white;
        border-right: 2px solid #d4af37;
        padding: 20px;
        box-shadow: 5px 0 20px rgba(0,0,0,0.05);
        box-sizing: border-box;
        transition: transform 0.3s ease-in-out;
        z-index: 1000;
    }

    .sidebar h2 { color: #d4af37; margin: 0 0 25px 0; }
    .sidebar a { display: block; padding: 12px 15px; margin-top: 8px; text-decoration: none; color: #333; border-radius: 8px; transition: 0.3s; font-weight: 500; }
    .sidebar a:hover { background: #d4af37; color: white; transform: translateX(5px); }
    .sidebar-overlay { display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.4); z-index: 998; }

    .content {
        margin-left: 240px;
        padding: 25px;
        box-sizing: border-box;
        transition: margin-left 0.3s ease-in-out;
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
        min-width: 750px; 
    }

    @media (max-width: 768px) {
        .mobile-header { display: flex; }
        .sidebar { transform: translateX(-100%); }
        .sidebar.active { transform: translateX(0); }
        .content { margin-left: 0 !important; padding: 85px 16px 25px 16px !important; }
        .header-title { flex-direction: column; align-items: flex-start !important; gap: 12px; }
        .header-title h2 { font-size: 24px !important; }
        .header-title a { width: 100%; text-align: center; box-sizing: border-box; }
    }
    </style>
</head>
<body>

<div class="mobile-header">
    <div style="font-weight: 700; color: #d4af37; font-size: 18px;">SIMPERUM</div>
    <button class="hamburger-btn" onclick="toggleSidebar()">☰</button>
</div>

<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

<div class="sidebar" id="sidebarMenu">
    <h2>SIMPERUM</h2>
    <a href="dashboard.php">Dashboard</a>
    <a href="rumah.php">Rumah</a>
    <a href="tukang.php">Tukang</a>
    <a href="penugasan.php">Penugasan</a>
    <a href="progress.php">Progress</a>
    <hr style="border: 0; border-top: 1px solid #f1f5f9; margin: 20px 0;">
    <a href="../logout.php" style="color: #ef4444;">Logout</a>
</div>

<div class="content">
    <div class="breadcrumb">
        <a href="dashboard.php" style="text-decoration: none; color: #64748b;">Dashboard</a> 
        <span style="margin: 0 8px; color: #cbd5e1;">/</span> 
        <span style="color: #1e293b; font-weight: 600;">Rumah</span>
    </div>

    <div class="header-title" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
        <h2 style="font-size: 28px; font-weight: 700; color: #1e293b; letter-spacing: -0.5px; margin: 0;">
            Manajemen Data Rumah
        </h2>
        <a href="tambah_rumah.php" class="btn" style="text-decoration: none; gap: 6px; font-size: 13px;">
            + Tambah Rumah
        </a>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr style="background: #fafafa; border-bottom: 2px solid var(--border-color);">
                    <th style="padding: 16px 20px; color: #64748b; font-weight: 600; width: 60px; text-align: center;">No</th>
                    <th style="padding: 16px 20px; color: #64748b; font-weight: 600; width: 120px; text-align: center;">Foto Unit</th>
                    <th style="padding: 16px 20px; color: #64748b; font-weight: 600;">Kode Rumah</th>
                    <th style="padding: 16px 20px; color: #64748b; font-weight: 600;">Harga Properti</th>
                    <th style="padding: 16px 20px; color: #64748b; font-weight: 600; width: 130px;">Status</th>
                    <th style="padding: 16px 20px; color: #64748b; font-weight: 600; width: 160px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                while($data = mysqli_fetch_assoc($query)){
                    $status = strtolower($data['status']);
                    $badgeBg = "rgba(148, 163, 184, 0.15)"; $badgeColor = "#64748b";
                    if($status == 'tersedia') { $badgeBg = "rgba(16, 185, 129, 0.15)"; $badgeColor = "#059669"; }
                    elseif($status == 'dipesan') { $badgeBg = "rgba(244, 63, 94, 0.15)"; $badgeColor = "#e11d48"; }
                    elseif($status == 'dibangun') { $badgeBg = "rgba(14, 165, 233, 0.15)"; $badgeColor = "#0284c7"; }
                ?>
                <tr style="border-bottom: 1px solid var(--border-color); transition: background 0.2s;" onmouseover="this.style.background='#fdfbf7'" onmouseout="this.style.background='transparent'">
                    <td style="padding: 16px 20px; text-align: center; color: #94a3b8; font-weight: 500;"><?= $no++; ?></td>
                    <td style="padding: 16px 20px; text-align: center;">
                        <div style="width: 70px; height: 50px; border-radius: var(--radius-sm); overflow: hidden; background: #f1f5f9; border: 1px solid var(--border-color); margin: 0 auto;">
                            <?php 
                            $img_path = "../uploads/rumah/" . $data['foto_rumah'];
                            if(!empty($data['foto_rumah']) && file_exists($img_path)): 
                            ?>
                                <img src="<?= $img_path; ?>" style="width: 100%; height: 100%; object-fit: cover;">
                            <?php else: ?>
                                <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=150&q=80" style="width: 100%; height: 100%; object-fit: cover;">
                            <?php endif; ?>
                        </div>
                    </td>
                    <td style="padding: 16px 20px; font-weight: 600; color: #1e293b;"><?= $data['kode_rumah']; ?></td>
                    <td style="padding: 16px 20px; font-weight: 600; color: var(--primary-gold);">Rp <?= number_format($data['harga'], 0, ',', '.'); ?></td>
                    <td style="padding: 16px 20px;">
                        <span style="background: <?= $badgeBg; ?>; color: <?= $badgeColor; ?>; padding: 4px 12px; font-size: 12px; font-weight: 600; border-radius: 100px; display: inline-block; text-transform: capitalize;">
                            <?= $data['status']; ?>
                        </span>
                    </td>
                    <td style="padding: 16px 20px; text-align: center;">
                        <div style="display: flex; gap: 12px; justify-content: center; align-items: center;">
                            <a href="edit_rumah.php?id=<?= $data['id_rumah']; ?>" style="text-decoration: none; color: var(--primary-gold); font-weight: 600; font-size: 13px;">Edit</a>
                            <span style="color: #cbd5e1; font-size: 12px;">|</span>
                            <a href="hapus_rumah.php?id=<?= $data['id_rumah']; ?>" style="text-decoration: none; color: #f43f5e; font-weight: 600; font-size: 13px;" onclick="return confirm('Yakin ingin menghapus unit <?= $data['kode_rumah']; ?>?')">Hapus</a>
                        </div>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function toggleSidebar() {
    var sidebar = document.getElementById('sidebarMenu');
    var overlay = document.getElementById('sidebarOverlay');
    sidebar.classList.toggle('active');
    overlay.style.display = sidebar.classList.contains('active') ? 'block' : 'none';
}
</script>
</body>
</html>