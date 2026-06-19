<?php
session_start();
include '../config/koneksi.php';

// Proteksi halaman admin
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: ../login.php");
    exit;
}

$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM progress_pembangunan WHERE id_progress='$id'");
$data = mysqli_fetch_assoc($query);

$rumah = mysqli_query($conn, "SELECT * FROM rumah");

if(isset($_POST['update'])){
    $id_rumah = $_POST['id_rumah'];
    $persentase = $_POST['persentase'];
    $status_progress = $_POST['status_progress'];
    $deskripsi = $_POST['deskripsi'];
    $tanggal_progress = $_POST['tanggal_progress'];

    if(!empty($_FILES['foto_progress']['name'])) {
        $foto_progress = $_FILES['foto_progress']['name'];
        $tmp = $_FILES['foto_progress']['tmp_name'];
        move_uploaded_file($tmp, "../uploads/progress/".$foto_progress);
        $sql_foto = ", foto_progress='$foto_progress'";
    } else {
        $sql_foto = "";
    }

    mysqli_query($conn, "
        UPDATE progress_pembangunan SET
            id_rumah='$id_rumah',
            persentase='$persentase',
            status_progress='$status_progress',
            deskripsi='$deskripsi',
            tanggal_progress='$tanggal_progress'
            $sql_foto
        WHERE id_progress='$id'
    ");

    header("Location: progress.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Progress Pembangunan - SIMPERUM</title>
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
    select, input, textarea { width: 100%; box-sizing: border-box; }
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
        <a href="progress.php" style="text-decoration: none; color: #64748b;">Progress</a>
        <span style="margin: 0 8px; color: #cbd5e1;">/</span> 
        <span style="color: #1e293b; font-weight: 600;">Edit Progress</span>
    </div>

    <h2 style="font-size: 28px; font-weight: 700; color: #1e293b; margin-bottom: 24px; letter-spacing: -0.5px;">
        Edit Progress Pembangunan Lapangan
    </h2>

    <div class="form-container">
        <form method="POST" enctype="multipart/form-data">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 24px; margin-bottom: 20px;">
                <div>
                    <label style="font-weight: 600; color: #1e293b; font-size: 14px;">Unit Rumah</label>
                    <select name="id_rumah" required style="cursor: pointer;">
                        <?php while($r = mysqli_fetch_assoc($rumah)){ ?>
                            <option value="<?= $r['id_rumah']; ?>" <?= ($data['id_rumah'] == $r['id_rumah']) ? 'selected' : ''; ?>>
                                <?= $r['kode_rumah']; ?> (<?= ucfirst($r['status']); ?>)
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div>
                    <label style="font-weight: 600; color: #1e293b; font-size: 14px;">Persentase Kerja (%)</label>
                    <input type="number" name="persentase" min="0" max="100" value="<?= $data['persentase']; ?>" required>
                </div>
                <div>
                    <label style="font-weight: 600; color: #1e293b; font-size: 14px;">Keterangan Status</label>
                    <select name="status_progress" required style="cursor: pointer;">
                        <option value="Berjalan" <?= ($data['status_progress'] == 'Berjalan') ? 'selected' : ''; ?>>Berjalan</option>
                        <option value="Selesai" <?= ($data['status_progress'] == 'Selesai') ? 'selected' : ''; ?>>Selesai</option>
                    </select>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 24px; margin-bottom: 24px;">
                <div>
                    <label style="font-weight: 600; color: #1e293b; font-size: 14px;">Tanggal Pencatatan Progress</label>
                    <input type="date" name="tanggal_progress" value="<?= $data['tanggal_progress']; ?>" required style="cursor: pointer;">
                </div>
                <div>
                    <label style="font-weight: 600; color: #1e293b; font-size: 14px;">Ganti Foto Lapangan <span style="font-size:12px; color:#94a3b8; font-weight:400;">(Kosongkan jika tetap)</span></label>
                    <input type="file" name="foto_progress" style="border: 1px dashed #cbd5e1; padding: 8px;">
                    <p style="font-size: 12px; color: #64748b; margin-top: 6px; margin-bottom: 0;">Berkas aktif: <code><?= $data['foto_progress']; ?></code></p>
                </div>
            </div>

            <div style="margin-bottom: 32px;">
                <label style="font-weight: 600; color: #1e293b; font-size: 14px;">Keterangan / Catatan Detail</label>
                <textarea name="deskripsi" style="height: 120px; resize: vertical;"><?= $data['deskripsi']; ?></textarea>
            </div>

            <div class="btn-group" style="display: flex; gap: 12px; justify-content: flex-end;">
                <a href="progress.php" class="btn" style="background: transparent; border: 1px solid #cbd5e1; color: #64748b; box-shadow: none;">Batal</a>
                <button type="submit" name="update" class="btn">Perbarui Progress</button>
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