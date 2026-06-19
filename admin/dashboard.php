<?php
session_start();
if($_SESSION['role'] != 'admin'){
    header("Location: ../login.php");
    exit;
}

include '../config/koneksi.php';

$rumah = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) as total FROM rumah"));
$tukang = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) as total FROM tukang"));
$progress = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) as total FROM progress_pembangunan"));
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - SIMPERUM</title>
    <link rel="stylesheet" href="../css/style.css">
    
    <style>
    body {
        margin: 0;
        background: #f8f8f8;
        font-family: inherit;
    }

    /* --- MOBILE HEADER TOPBAR (Hanya muncul di mobile) --- */
    .mobile-header {
        display: none;
        background: white;
        padding: 15px 20px;
        align-items: center;
        justify-content: space-between;
        border-bottom: 2px solid #d4af37;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 999;
    }

    .hamburger-btn {
        background: none;
        border: none;
        font-size: 24px;
        color: #d4af37;
        cursor: pointer;
    }

    /* --- SIDEBAR LAYOUT --- */
    .sidebar {
        width: 240px;
        height: 100vh;
        position: fixed;
        top: 0;
        left: 0;
        background: white;
        border-right: 2px solid #d4af37;
        padding: 20px;
        box-shadow: 5px 0 20px rgba(0,0,0,0.05);
        box-sizing: border-box;
        transition: transform 0.3s ease-in-out;
        z-index: 1000;
    }

    .sidebar h2 {
        color: #d4af37;
        margin-bottom: 25px;
        margin-top: 0;
    }

    .sidebar a {
        display: block;
        padding: 12px 15px;
        margin-top: 8px;
        text-decoration: none;
        color: #333;
        border-radius: 8px;
        transition: 0.3s;
        font-weight: 500;
    }

    .sidebar a:hover {
        background: #d4af37;
        color: white;
        transform: translateX(5px);
    }

    /* --- OVERLAY BACKDROP MOBILE --- */
    .sidebar-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.4);
        z-index: 998;
    }

    /* --- CONTENT AREA --- */
    .content {
        margin-left: 240px;
        padding: 25px;
        box-sizing: border-box;
        transition: margin-left 0.3s ease-in-out;
    }

    /* PANEL SELAMAT DATANG ATAS */
    .topbar {
        background: white;
        padding: 18px 20px;
        border-radius: 15px;
        border-left: 5px solid #d4af37;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }

    .title {
        margin-top: 24px;
        font-size: 22px;
        font-weight: bold;
        color: #1e293b;
    }

    /* KARTU STATISTIK GRID RESPONSIF */
    .stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }

    .stat-card {
        background: white;
        padding: 20px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        gap: 15px;
        border-left: 5px solid #d4af37;
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        transition: 0.3s;
    }

    .stat-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }

    .icon {
        font-size: 40px;
    }

    .stat-text {
        display: flex;
        flex-direction: column;
    }

    .stat-text small {
        color: #64748b;
        font-size: 13px;
    }

    .number {
        font-size: 28px;
        font-weight: bold;
        color: #d4af37;
        margin-top: 2px;
    }

    /* TOMBOL QUICK ACTION */
    .quick {
        margin-top: 30px;
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .quick a {
        padding: 12px 20px;
        background: linear-gradient(45deg, #d4af37, #f1e08a);
        color: #1e293b;
        border-radius: 10px;
        text-decoration: none;
        font-weight: bold;
        transition: 0.3s;
        font-size: 14px;
        box-shadow: 0 4px 10px rgba(212,175,53,0.2);
    }

    .quick a:hover {
        transform: scale(1.03);
        box-shadow: 0 6px 15px rgba(212,175,53,0.3);
    }

    /* ==========================================
       ⚡ BREAKPOINT MEDIA QUERIES (RESPONSIVE)
       ========================================== */
    @media (max-width: 768px) {
        .mobile-header {
            display: flex; /* Memunculkan header atas di HP */
        }

        .sidebar {
            transform: translateX(-100%); /* Sembunyikan sidebar ke kiri di HP */
        }

        /* Class bantu JavaScript untuk memunculkan sidebar mobile */
        .sidebar.active {
            transform: translateX(0);
        }

        .content {
            margin-left: 0; /* Lebarkan konten penuhin layar di HP */
            padding: 85px 16px 25px 16px; /* Tambah padding atas agar tidak ketutupan mobile-header */
        }

        .topbar {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
        }

        .topbar div:last-child {
            align-self: flex-end;
        }
        
        .quick {
            display: grid;
            grid-template-columns: 1fr 1fr; /* Tombol aksi jadi berjejer 2 kolom di HP */
            gap: 10px;
            width: 100%;
        }
        
        .quick a {
            text-align: center;
            padding: 12px 10px;
        }
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

    <a href="dashboard.php"> Dashboard</a>
    <a href="rumah.php"> Rumah</a>
    <a href="tukang.php"> Tukang</a>
    <a href="penugasan.php"> Penugasan</a>
    <a href="progress.php"> Progress</a>

    <hr style="border: 0; border-top: 1px solid #f1f5f9; margin: 20px 0;">

    <a href="../logout.php" style="color: #ef4444;">Logout</a>
</div>

<div class="content">

    <div class="topbar">
        <div>
            Selamat datang, <b><?= $_SESSION['nama']; ?></b>
            <br>
            <small style="color:#64748b;">Manage your property system efficiently</small>
        </div>
        <div style="color:#d4af37; font-weight:bold; background: rgba(212,175,55,0.1); padding: 4px 12px; border-radius: 20px; font-size: 13px;">
            ADMIN PANEL
        </div>
    </div>

    <div class="title">
        Dashboard Overview
    </div>

    <div class="stats">
        <div class="stat-card">
            <div class="icon"></div>
            <div class="stat-text">
                <small>Total Rumah</small>
                <div class="number"><?= $rumah['total']; ?></div>
            </div>
        </div>

        <div class="stat-card">
            <div class="icon"></div>
            <div class="stat-text">
                <small>Total Tukang</small>
                <div class="number"><?= $tukang['total']; ?></div>
            </div>
        </div>

        <div class="stat-card">
            <div class="icon"></div>
            <div class="stat-text">
                <small>Progress Pembangunan</small>
                <div class="number"><?= $progress['total']; ?></div>
            </div>
        </div>
    </div>

    <div class="quick">
        <a href="rumah.php">+ Tambah Rumah</a>
        <a href="tukang.php">+ Tambah Tukang</a>
        <a href="penugasan.php">Assign Tukang</a>
        <a href="progress.php">Update Progress</a>
    </div>

</div>

<script>
function toggleSidebar() {
    var sidebar = document.getElementById('sidebarMenu');
    var overlay = document.getElementById('sidebarOverlay');
    
    // Toggle class 'active' untuk slide-in / slide-out sidebar
    sidebar.classList.toggle('active');
    
    // Atur visibilitas backdrop gelap di luar boks menu
    if (sidebar.classList.contains('active')) {
        overlay.style.display = 'block';
    } else {
        overlay.style.display = 'none';
    }
}
</script>

</body>
</html>