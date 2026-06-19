<?php
include '../config/koneksi.php';
$data = mysqli_query($conn, "SELECT * FROM rumah");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Denah Komplek - SIMPERUM</title>
    <link rel="stylesheet" href="../css/style.css">
    
    <style>
    body {
        margin: 0;
        background: #f8f8f8;
        font-family: inherit;
    }

    /* --- MOBILE HEADER TOPBAR --- */
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

    .denah-responsive-container {
        background: white; 
        padding: 24px; 
        border-radius: var(--radius-lg); 
        box-shadow: var(--shadow-md); 
        border: 1px solid var(--border-color); 
        margin-bottom: 24px;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .denah-canvas {
        position: relative;
        width: 100%;
        max-width: 900px;
        min-width: 900px; 
        height: 500px;
        margin: auto;
        background: #fdfdfd;
        border: 3px solid #dfba48;
        box-shadow: inset 0 0 20px rgba(212, 175, 55, 0.05), 0 0 15px rgba(212, 175, 55, 0.1);
        border-radius: 20px;
        overflow: hidden;
    }

    .legenda-container {
        background: white; 
        padding: 16px 24px; 
        border-radius: var(--radius-md); 
        box-shadow: var(--shadow-sm); 
        border: 1px solid var(--border-color); 
        display: inline-flex; 
        gap: 24px; 
        align-items: center; 
        flex-wrap: wrap;
    }

    @media (max-width: 768px) {
        .mobile-header {
            display: flex;
        }

        .content {
            margin-left: 0 !important; /* FIX: Menghapus paksa ruang kosong sisa sidebar di sebelah kiri */
            padding: 85px 16px 25px 16px !important; 
        }

        .denah-responsive-container {
            padding: 16px 8px; 
        }

        .legenda-container {
            display: flex;
            width: 100%;
            flex-direction: column;
            align-items: flex-start;
            gap: 16px;
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

    <div class="breadcrumb">
        <a href="dashboard.php" style="text-decoration: none; color: #64748b;">Dashboard</a> 
        <span style="margin: 0 8px; color: #cbd5e1;">/</span> 
        <span style="color: #1e293b; font-weight: 600;">Denah Komplek</span>
    </div>

    <h2 style="font-size: 28px; font-weight: 700; color: #1e293b; margin-bottom: 6px; letter-spacing: -0.5px;">
        Layout Denah Komplek Perumahan
    </h2>
    <p style="color: #64748b; font-size: 14px; margin-bottom: 24px;">
        Arahkan kursor atau klik unit rumah untuk melihat informasi detail spesifik properti.
    </p>

    <div class="denah-responsive-container">
        <div class="denah-canvas">
            <div style="
                position: absolute;
                width: 100%;
                height: 100%;
                background-image:
                linear-gradient(to right, rgba(212, 175, 55, 0.03) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(212, 175, 55, 0.03) 1px, transparent 1px);
                background-size: 30px 30px;
                pointer-events: none;
                z-index: 1;
            "></div>

            <div style="
                position: absolute;
                top: 115px; 
                left: 0;
                width: 100%;
                height: 44px; 
                background: #e2e8f0; 
                border-top: 2px solid #cbd5e1;
                border-bottom: 2px solid #cbd5e1;
                z-index: 2;
                display: flex;
                align-items: center;
            ">
                <div style="width: 100%; height: 0; border-top: 2px dashed #94a3b8;"></div>
                <span style="position: absolute; left: 30px; font-size: 9px; color: #94a3b8; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; background: #e2e8f0; padding: 0 8px;">Jl. Utama Simperum</span>
            </div>

            <div style="
                position: absolute;
                top: 115px; 
                left: 235px; 
                width: 44px; 
                height: 385px;
                background: #e2e8f0;
                border-left: 2px solid #cbd5e1;
                border-right: 2px solid #cbd5e1;
                z-index: 2;
                display: flex;
                justify-content: center;
            ">
                <div style="width: 0; height: 100%; border-left: 2px dashed #94a3b8;"></div>
            </div>

            <?php while($r = mysqli_fetch_assoc($data)) { 
                $status = strtolower($r['status']);
                $statusGradient = "linear-gradient(135deg, #94a3b8, #64748b)"; 
                if($status == 'tersedia') { $statusGradient = "linear-gradient(135deg, #10b981, #059669)"; }
                elseif($status == 'dipesan') { $statusGradient = "linear-gradient(135deg, #f43f5e, #e11d48)"; }
                elseif($status == 'dibangun') { $statusGradient = "linear-gradient(135deg, #0ea5e9, #0284c7)"; }
            ?>
                <a href="detail_rumah.php?id=<?= $r['id_rumah']; ?>" style="text-decoration: none;">
                    <div style="
                        position: absolute;
                        left: <?= $r['posisi_x']; ?>px;
                        top: <?= $r['posisi_y']; ?>px;
                        width: 64px;
                        height: 64px;
                        background: <?= $statusGradient; ?>;
                        color: white;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        font-weight: 700;
                        font-size: 13px;
                        letter-spacing: 0.5px;
                        border-radius: 14px;
                        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
                        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                        cursor: pointer;
                        z-index: 10; 
                    "
                    onmouseover="this.style.transform='scale(1.18) translateY(-3px)'; this.style.zIndex='99'; this.style.boxShadow='0 12px 24px rgba(0,0,0,0.2)';"
                    onmouseout="this.style.transform='scale(1) translateY(0)'; this.style.zIndex='10'; this.style.boxShadow='0 8px 16px rgba(0, 0, 0, 0.15)';"
                    title="<?= $r['kode_rumah']; ?> (<?= ucfirst($r['status']); ?>)">
                        <?= $r['kode_rumah']; ?>
                    </div>
                </a>
            <?php } ?>
        </div>
    </div>

    <div class="legenda-container">
        <span style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 1px;">
            Status Unit:
        </span>
        <div style="display: flex; gap: 16px; flex-wrap: wrap;">
            <div style="display: flex; align-items: center; gap: 8px;">
                <span style="width: 12px; height: 12px; background: linear-gradient(135deg, #10b981, #059669); border-radius: 4px;"></span>
                <span style="font-size: 14px; font-weight: 500; color: #1e293b;">Tersedia</span>
            </div>
            <div style="display: flex; align-items: center; gap: 8px;">
                <span style="width: 12px; height: 12px; background: linear-gradient(135deg, #f43f5e, #e11d48); border-radius: 4px;"></span>
                <span style="font-size: 14px; font-weight: 500; color: #1e293b;">Dipesan</span>
            </div>
            <div style="display: flex; align-items: center; gap: 8px;">
                <span style="width: 12px; height: 12px; background: linear-gradient(135deg, #0ea5e9, #0284c7); border-radius: 4px;"></span>
                <span style="font-size: 14px; font-weight: 500; color: #1e293b;">Dibangun</span>
            </div>
            <div style="display: flex; align-items: center; gap: 8px;">
                <span style="width: 12px; height: 12px; background: linear-gradient(135deg, #94a3b8, #64748b); border-radius: 4px;"></span>
                <span style="font-size: 14px; font-weight: 500; color: #1e293b;">Terjual</span>
            </div>
        </div>
    </div>

</div>
</body>
</html>