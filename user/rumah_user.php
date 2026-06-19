<?php
include '../config/koneksi.php';

$data = mysqli_query($conn, "SELECT * FROM rumah");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Rumah - SIMPERUM</title>
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

    /* Memastikan susunan grid katalog tetap proporsional di berbagai resolusi layar */
    .katalog-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 24px;
        margin-top: 20px;
    }

    /* Memastikan gambar dalam katalog memnuhi boks dan tidak distorsi */
    .img-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    @media (max-width: 768px) {
        .content {
            padding: 85px 16px 25px 16px; /* Jarak aman atas dari komponen topbar header mobile */
        }

        .katalog-grid {
            grid-template-columns: 1fr; /* Menjadi satu kolom penuh di layar HP */
            gap: 16px;
        }
        
        .card {
            min-height: auto !important; /* Membebaskan tinggi boks agar teks tidak terpotong di mobile */
            padding: 16px !important;
        }
    }
    </style>
</head>
<body>

<div class="content">

    <div class="breadcrumb">
        <a href="dashboard.php" style="text-decoration: none; color: #64748b;">Dashboard</a> 
        <span style="margin: 0 8px; color: #cbd5e1;">/</span> 
        <span style="color: #1e293b; font-weight: 600;">Daftar Rumah</span>
    </div>

    <h2 style="font-size: 28px; font-weight: 700; color: #1e293b; margin-bottom: 24px; letter-spacing: -0.5px;">
        Daftar Properti Rumah
    </h2>

    <div class="katalog-grid">

    <?php while($r = mysqli_fetch_assoc($data)) { 
        $status = strtolower($r['status']);
        
        // Logika pewarnaan badge dinamis
        $badgeBg = "rgba(148, 163, 184, 0.15)"; $badgeColor = "#64748b";
        if($status == 'tersedia') { $badgeBg = "rgba(16, 185, 129, 0.15)"; $badgeColor = "#059669"; }
        elseif($status == 'dipesan') { $badgeBg = "rgba(244, 63, 94, 0.15)"; $badgeColor = "#e11d48"; }
        elseif($status == 'dibangun') { $badgeBg = "rgba(14, 165, 233, 0.15)"; $badgeColor = "#0284c7"; }
    ?>

        <div class="card" style="display: flex; flex-direction: column; justify-content: space-between; min-height: 420px; background: white; margin: 0; box-sizing: border-box; padding: 20px;">
            
            <div>
                <div class="img-box" style="margin-bottom: 20px; background: #f1f5f9; display: flex; align-items: center; justify-content: center; height: 180px; border-radius: var(--radius-md); overflow: hidden; border: 1px solid var(--border-color);">
                    <?php 
                    $target_foto = "../uploads/rumah/" . $r['foto_rumah'];
                    if(!empty($r['foto_rumah']) && file_exists($target_foto)): 
                    ?>
                        <img src="<?= $target_foto; ?>" alt="Foto Rumah">
                    <?php else: ?>
                        <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=600&q=80" alt="Default House Image">
                    <?php endif; ?>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; gap: 12px;">
                    <h3 style="font-size: 20px; font-weight: 700; color: #1e293b; margin: 0;">
                        <?= $r['kode_rumah']; ?>
                    </h3>
                    <span class="badge" style="background: <?= $badgeBg; ?>; color: <?= $badgeColor; ?>; padding: 4px 12px; border-radius: 100px; font-size: 11px; font-weight: 600; text-transform: uppercase; display: inline-block; letter-spacing: 0.3px;">
                        <?= $r['status']; ?>
                    </span>
                </div>

                <p style="font-size: 14px; color: #64748b; margin-bottom: 24px; line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; height: 63px;">
                    <?php 
                    echo !empty($r['deskripsi']) ? $r['deskripsi'] : "Unit properti eksklusif SIMPERUM dengan desain arsitektur modern dan material premium."; 
                    ?>
                </p>
            </div>

            <a href="detail_rumah.php?id=<?= $r['id_rumah']; ?>" class="btn" style="text-align: center; justify-content: center; text-transform: uppercase; font-size: 12px; letter-spacing: 0.5px; display: flex; width: 100%; box-sizing: border-box; text-decoration: none;">
                Lihat Detail Unit
            </a>

        </div>

    <?php } ?>

    </div>
</div>

</body>
</html>