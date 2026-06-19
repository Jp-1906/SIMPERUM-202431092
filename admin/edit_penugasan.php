<?php
session_start();
include '../config/koneksi.php';

// Proteksi halaman admin
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: ../login.php");
    exit;
}

$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM penugasan_tukang WHERE id_penugasan='$id'");
$data = mysqli_fetch_assoc($query);

$rumah = mysqli_query($conn, "SELECT * FROM rumah");
$tukang = mysqli_query($conn, "SELECT * FROM tukang");

if(isset($_POST['update'])){
    $id_rumah = $_POST['id_rumah'];
    $id_tukang = $_POST['id_tukang'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_selesai = !empty($_POST['tanggal_selesai']) ? "'" . $_POST['tanggal_selesai'] . "'" : "NULL";
    $status_kerja = $_POST['status_kerja'];

    mysqli_query($conn, "
        UPDATE penugasan_tukang SET
            id_rumah='$id_rumah',
            id_tukang='$id_tukang',
            tanggal_mulai='$tanggal_mulai',
            tanggal_selesai=$tanggal_selesai,
            status_kerja='$status_kerja'
        WHERE id_penugasan='$id'
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
    <title>Edit Penugasan Tukang - SIMPERUM</title>
    <link rel="stylesheet" href="../css/style.css">
    
    <style>
    body { margin: 0; background: #f8f8f8; font-family: inherit; }
    .mobile-header { display: none; background: white; padding: 15px 20px; align-items: center; justify-content: space-between; border-bottom: 2px solid #d4af37; box-shadow: 0 2px 10px rgba(0,0,0,0.05); position: fixed; top: 0; left: 0; right: 0; z-index: 999; }
    .hamburger-btn { background: none; border: none; font-size: 24px; color: #d4af37; cursor: pointer; }
    .sidebar { width: 240px; height: 100vh; position: fixed; top: 0; left: 0; background: white; border-right: 2px solid #d4af37; padding: 20px; box-shadow: 5px 0 20px rgba(0,0,0,0.05); box-sizing: border-box; transition: transform 0.3s ease-in-out; z-index: 1000; }
    .sidebar h2 { color: #d4af37; margin: 0 0 25px 0; }
    .sidebar a { display: block; padding: 12px 15px; margin-top: 8px; text-decoration: none; color: #333; border-radius: 8px; transition: 0.3s; font-weight: 500; }
    .sidebar a:hover { background: #d4af37; color: white; transform: translateX(5px); }
    .sidebar-overlay { display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.4); z-index: 998; }
    
    .content { margin-left: 240px; padding: 25px; box-sizing: border-box; transition: margin-left 0.3s ease-in-out; }
    .form-container { background: white; padding: 32px; border-radius: var(--radius-lg); box-shadow: var(--shadow-md); }
    select, input { width: 100%; box-sizing: border-box; }
    label { display: block; margin-bottom: 6px; }

    @media (max-width: 768px) {
        .mobile-header { display: flex; }
        .sidebar { transform: translateX(-100%); }
        .sidebar.active { transform: translateX(0); }
        .content { margin-left: 0 !important; padding: 85px 16px 25px 16px !important; }
        .form-container { padding: 24px 16px; }
        .btn-group { flex-direction: column-reverse; gap: 10px; }
        .btn-group a, .btn-group button { width: 100%; text-align: center; box-sizing: border-box; }
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
                    <label style="font-weight: 600; color: #1e293b; font-size: 14px;">Unit Rumah</label>
                    <select name="id_rumah" required style="cursor: pointer;">
                        <?php while($r = mysqli_fetch_assoc($rumah)){ ?>
                            <option value="<?= $r['id_rumah']; ?>" <?= ($data['id_rumah'] == $r['id_rumah']) ? 'selected' : ''; ?>>
                                <?= $r['kode_rumah']; ?> - Status Lapangan: <?= ucfirst($r['status']); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div>
                    <label style="font-weight: 600; color: #1e293b; font-size: 14px;">Tenaga Ahli (Tukang)</label>
                    <select name="id_tukang" required style="cursor: pointer;">
                        <?php while($t = mysqli_fetch_assoc($tukang)){ ?>
                            <option value="<?= $t['id_tukang']; ?>" <?= ($data['id_tukang'] == $t['id_tukang']) ? 'selected' : ''; ?>>
                                <?= $t['nama_tukang']; ?> (Spesialisasi: <?= $t['spesialisasi']; ?>)
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 24px; margin-bottom: 32px;">
                <div>
                    <label style="font-weight: 600; color: #1e293b; font-size: 14px;">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" value="<?= $data['tanggal_mulai']; ?>" required style="cursor: pointer;">
                </div>

                <div>
                    <label style="font-weight: 600; color: #1e293b; font-size: 14px;">Tanggal Selesai <span style="font-size:12px; color:#94a3b8; font-weight:400;">(Kosongkan jika aktif)</span></label>
                    <input type="date" name="tanggal_selesai" value="<?= $data['tanggal_selesai']; ?>" style="cursor: pointer;">
                </div>

                <div>
                    <label style="font-weight: 600; color: #1e293b; font-size: 14px;">Status Kerja</label>
                    <select name="status_kerja" style="cursor: pointer;">
                        <option value="aktif" <?= ($data['status_kerja'] == 'aktif') ? 'selected' : ''; ?>>Aktif</option>
                        <option value="selesai" <?= ($data['status_kerja'] == 'selesai') ? 'selected' : ''; ?>>Selesai</option>
                        <option value="istirahat" <?= ($data['status_kerja'] == 'istirahat') ? 'selected' : ''; ?>>Istirahat</option>
                        <option value="tertunda" <?= ($data['status_kerja'] == 'tertunda') ? 'selected' : ''; ?>>Tertunda</option>
                    </select>
                </div>
            </div>

            <div class="btn-group" style="display: flex; gap: 12px; justify-content: flex-end;">
                <a href="penugasan.php" class="btn" style="background: transparent; border: 1px solid #cbd5e1; color: #64748b; box-shadow: none;">Batal</a>
                <button type="submit" name="update" class="btn">Perbarui Penugasan</button>
            </div>
        </form>
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