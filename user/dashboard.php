<?php
session_start();
if($_SESSION['role'] != 'user'){
    header("Location: ../login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard User - SIMPERUM</title>
    <link rel="stylesheet" href="../css/style.css">

    <style>
    body {
        margin: 0;
        background: #f8f8f8;
        font-family: inherit;
    }

    /* --- MOBILE HEADER TOPBAR (Hanya aktif di mobile layar kecil) --- */
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

    .content {
        padding: 25px;
        box-sizing: border-box;
    }

    /* HERO WELCOME BOX */
    .hero {
        background: white;
        padding: 20px;
        border-radius: 15px;
        border-left: 5px solid #d4af37;
        box-shadow: 0 10px 25px rgba(0,0,0,0.06);
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-sizing: border-box;
    }

    .hero small {
        color: #64748b;
    }

    /* GRID MENU UTAMA (Menjaga boks tetap sejajar horizontal di PC) */
    .menu-grid {
        margin-top: 25px;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
    }

    /* KARTU MENU NAVIGASI */
    .menu-card {
        background: white;
        padding: 24px;
        border-radius: 15px;
        border-left: 5px solid #d4af37;
        box-shadow: 0 10px 25px rgba(0,0,0,0.06);
        transition: transform 0.3s, box-shadow 0.3s;
        text-decoration: none;
        color: inherit;
        box-sizing: border-box;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .menu-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }

    .menu-title {
        font-size: 18px;
        font-weight: bold;
        color: #1e293b;
    }

    .menu-desc {
        font-size: 13px;
        color: #64748b;
        margin-top: 6px;
        line-height: 1.4;
    }

    .logout-container {
        grid-column: 1 / -1; 
        text-align: left;
        margin-top: 15px;
    }

    /* --- BREAKPOINT MEDIA QUERIES (RESPONSIVE) --- */
    @media (max-width: 768px) {
        .mobile-header {
            display: flex;
        }

        .content {
            margin-left: 0 !important; /* FIX: Menghapus paksa ruang kosong di sebelah kiri */
            padding: 85px 16px 25px 16px !important; /* Mencegah tabrakan ruang dengan header mobile */
        }

        .hero {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
        }

        .hero div:last-child {
            align-self: flex-end;
            font-size: 13px;
        }

        .menu-grid {
            grid-template-columns: 1fr; /* Memaksa menyusun ke bawah secara rapi khusus di layar HP */
            gap: 16px;
        }

        .logout-container {
            text-align: center;
            margin-top: 24px;
        }

        .logout-btn {
            display: block !important;
            width: 100%;
            box-sizing: border-box;
            text-align: center;
        }
    }
    </style>
</head>
<body>

<div class="mobile-header">
    <div style="font-weight: 700; color: #d4af37; font-size: 18px;">SIMPERUM</div>
    <div style="color: #64748b; font-weight: 600; font-size: 12px; background: #f1f5f9; padding: 4px 10px; border-radius: 20px;">USER</div>
</div>

<div class="content">

    <div class="hero">
        <div>
            Halo, <b><?= $_SESSION['nama']; ?></b>
            <br>
            <small>Selamat datang di SIMPERUM - Sistem Informasi Perumahan</small>
        </div>

        <div style="color:#d4af37; font-weight:bold; background: rgba(212,175,55,0.1); padding: 4px 12px; border-radius: 20px; font-size: 13px;">
            USER PANEL
        </div>
    </div>

    <div class="menu-grid">

        <a href="denah.php" class="menu-card">
            <div class="menu-title">Denah Komplek</div>
            <div class="menu-desc">Lihat layout perumahan secara visual</div>
        </a>

        <a href="rumah_user.php" class="menu-card">
            <div class="menu-title">Daftar Rumah</div>
            <div class="menu-desc">Informasi semua rumah tersedia</div>
        </a>

        <div class="logout-container">
            <a href="../logout.php" class="logout-btn"
               style="
                    display: inline-block;
                    background: #fff;
                    border: 2px solid #d4af37;
                    color: #d4af37;
                    padding: 10px 24px;
                    border-radius: 10px;
                    font-weight: bold;
                    text-decoration: none;
                    transition: 0.3s;
               "
               onmouseover="this.style.background='#d4af37'; this.style.color='#fff';"
               onmouseout="this.style.background='#fff'; this.style.color='#d4af37';">
                Logout
            </a>
        </div>

    </div>

</div>

</body>
</html>