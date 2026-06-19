<?php
session_start();
include '../config/koneksi.php';

$id = $_GET['id'];

// Ambil data spesifik rumah
$rumah = mysqli_query($conn,"
    SELECT * FROM rumah 
    WHERE id_rumah='$id'
");
$data = mysqli_fetch_assoc($rumah);

// Ambil riwayat progress pembangunan
$progress = mysqli_query($conn,"
    SELECT * FROM progress_pembangunan 
    WHERE id_rumah='$id' 
    ORDER BY tanggal_progress DESC
");

// Ambil daftar tukang yang bekerja
$tukang = mysqli_query($conn,"
    SELECT tukang.* FROM penugasan_tukang 
    JOIN tukang ON penugasan_tukang.id_tukang = tukang.id_tukang 
    WHERE penugasan_tukang.id_rumah='$id'
");

$status = strtolower($data['status']);

// Deteksi otomatis file induk (rumah.php atau rumah_user.php) berdasarkan folder lokasi
$current_dir = basename(dirname($_SERVER['PHP_SELF']));
$back_link = ($current_dir == 'user') ? 'rumah_user.php' : 'rumah.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Unit <?= $data['kode_rumah']; ?> - SIMPERUM</title>
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

    .detail-grid-top {
        display: grid; 
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); 
        gap: 24px; 
        margin-bottom: 24px;
    }

    .detail-grid-bottom {
        display: grid; 
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); 
        gap: 24px;
    }

    @media (max-width: 768px) {
        .mobile-header {
            display: flex;
        }

        .content {
            margin-left: 0 !important; /* FIX: Menghapus paksa ruang kosong sisa sidebar di sebelah kiri */
            padding: 85px 16px 25px 16px !important; /* Ruang atas aman dari mobile header */
        }

        .detail-grid-top, .detail-grid-bottom {
            grid-template-columns: 1fr; /* Kolom tunggal penuhin layar di HP */
            gap: 16px;
        }

        .header-title-container {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 12px;
        }
        
        .marketing-card textarea, .marketing-card button, .marketing-card a {
            width: 100% !important;
            box-sizing: border-box;
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
        <a href="<?= $back_link; ?>" style="text-decoration: none; color: #64748b;">Daftar Rumah</a>
        <span style="margin: 0 8px; color: #cbd5e1;">/</span> 
        <span style="color: #1e293b; font-weight: 600;">Detail Unit</span>
    </div>

    <div class="header-title-container" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
        <div>
            <h2 style="font-size: 28px; font-weight: 700; color: #1e293b; letter-spacing: -0.5px; margin: 0;">
                Detail Rumah <?= $data['kode_rumah']; ?>
            </h2>
        </div>
        
        <?php
        $badgeBg = "rgba(148, 163, 184, 0.15)"; $badgeColor = "#64748b";
        if($status == 'tersedia') { $badgeBg = "rgba(16, 185, 129, 0.15)"; $badgeColor = "#059669"; }
        elseif($status == 'dipesan') { $badgeBg = "rgba(244, 63, 94, 0.15)"; $badgeColor = "#e11d48"; }
        elseif($status == 'dibangun') { $badgeBg = "rgba(14, 165, 233, 0.15)"; $badgeColor = "#0284c7"; }
        ?>
        <span class="badge" style="background: <?= $badgeBg; ?>; color: <?= $badgeColor; ?>; padding: 6px 16px; font-size: 13px; text-transform: uppercase;">
            <?= $data['status']; ?>
        </span>
    </div>

    <div class="detail-grid-top">
        
        <div class="card" style="padding: 16px; background: white; display: flex; align-items: center; justify-content: center; min-height: 300px; box-sizing: border-box; margin: 0;">
            <div style="width: 100%; height: 100%; min-height: 250px; border-radius: var(--radius-md); overflow: hidden; background: #f1f5f9;">
                <?php if(!empty($data['foto_rumah']) && file_exists("../uploads/rumah/".$data['foto_rumah'])): ?>
                    <img src="../uploads/rumah/<?= $data['foto_rumah']; ?>" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                <?php else: ?>
                    <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=800&q=80" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                <?php endif; ?>
            </div>
        </div>

        <div style="display: flex; flex-direction: column; gap: 24px;">
            
            <div class="card" style="background: white; padding: 24px; margin: 0; height: auto !important; box-sizing: border-box;">
                <span style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Nilai Investasi Unit</span>
                <h3 style="font-size: 28px; font-weight: 700; color: var(--primary-gold); margin: 4px 0 20px 0;">
                    Rp <?= number_format($data['harga'], 0, ',', '.'); ?>
                </h3>

                <div style="margin-bottom: 16px; border-bottom: 1px solid var(--border-color); padding-bottom: 12px;">
                    <span style="font-size: 13px; color: #64748b; display: block; margin-bottom: 2px;">Alamat Lokasi:</span>
                    <p style="font-size: 14px; color: #1e293b; margin: 0; font-weight: 500; line-height: 1.4;"><?= $data['alamat']; ?></p>
                </div>

                <div>
                    <span style="font-size: 13px; color: #64748b; display: block; margin-bottom: 2px;">Spesifikasi Keterangan:</span>
                    <p style="font-size: 14px; color: #64748b; margin: 0; line-height: 1.5;"><?= !empty($data['deskripsi']) ? $data['deskripsi'] : 'Unit properti eksklusif SIMPERUM.'; ?></p>
                </div>
            </div>

            <div class="marketing-card" style="background: #1e293b; color: white; padding: 24px 24px 32px 24px; margin: 0; border-left: 4px solid #d4af37; box-sizing: border-box; height: auto !important; min-height: fit-content; border-radius: var(--radius-md); box-shadow: var(--shadow-md);">
                <h4 style="margin: 0 0 4px 0; font-size: 16px; font-weight: 700; color: white;">Konsultasi & Hubungi Marketing:</h4>
                
                <?php if($status == 'tersedia' || $status == 'dibangun'): ?>
                    <p style="color: #94a3b8; font-size: 12px; margin: 0 0 16px 0;">Silakan hubungi kontak resmi atau kirimkan pesan langsung melalui form di bawah.</p>
                    
                    <div style="background: rgba(255,255,255,0.05); padding: 14px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.1); margin-bottom: 20px; box-sizing: border-box;">
                        <label style="font-size: 11px; color: #cbd5e1; display: block; font-weight: 600; margin-bottom: 6px;">Tulis Pesan Email Anda:</label>
                        <textarea id="pesanEmail" style="width: 100%; height: 65px; background: rgba(0,0,0,0.2); border: 1px solid #475569; color: white; border-radius: 6px; padding: 8px; font-size: 13px; margin: 0 0 8px 0; font-family: inherit; resize: none; box-sizing: border-box;" placeholder="Halo, saya tertarik dengan unit <?= $data['kode_rumah']; ?>..."></textarea>
                        <button type="button" class="btn" style="width: 100%; font-size: 12px; padding: 10px; background: var(--gold-gradient); color: white; border: none; font-weight: 600; cursor: pointer; display: block; box-sizing: border-box;" onclick="kirimEmailKeDeveloper('<?= $data['kode_rumah']; ?>')">
                            Kirim Pesan ke Developer
                        </button>
                    </div>

                    <div style="display: block; margin-top: 10px; clear: both;">
                        <a href="https://wa.me/6282154745874" target="_blank" style="display: block; width: 100%; background: #16a34a; color: white; text-align: center; font-size: 13px; font-weight: 600; padding: 10px 0; text-decoration: none; border-radius: 6px; margin-bottom: 12px; border: none; box-sizing: border-box; font-family: inherit;">
                            WhatsApp Marketing (082154745874)
                        </a>
                        <a href="https://instagram.com/nkyyjp" target="_blank" style="display: block; width: 100%; background: linear-gradient(45deg, #f09433, #e1306c, #bc1888); color: white; text-align: center; font-size: 13px; font-weight: 600; padding: 10px 0; text-decoration: none; border-radius: 6px; border: none; box-sizing: border-box; font-family: inherit;">
                            Instagram (@nkyyjp)
                        </a>
                    </div>

                <?php else: ?>
                    <p style="color: #94a3b8; font-size: 12px; margin: 0 0 12px 0;">Pemasaran unit ini resmi ditutup oleh pengembang properti.</p>
                    <div style="background: rgba(244,63,94,0.1); padding: 12px 14px; border-radius: 6px; border: 1px solid rgba(244,63,94,0.2);">
                        <p style="font-size: 12px; color: #f43f5e; font-weight: 600; margin: 0; line-height: 1.4;">
                            Maaf, konsultasi dan pemesanan dinonaktifkan karena unit ini sudah sukses dipesan atau terjual.
                        </p>
                    </div>
                <?php endif; ?>

            </div> 
        </div>
    </div>

    <?php if($status != 'tersedia' && $status != 'terjual'): ?>
        
        <div class="detail-grid-bottom">
            
            <div class="card" style="background: white; padding: 20px; box-sizing: border-box; margin: 0;">
                <h3 style="font-size: 16px; font-weight: 700; color: #1e293b; margin-top: 0; margin-bottom: 16px; border-bottom: 2px solid #f1f5f9; padding-bottom: 8px;">
                    Rekam Jejak Lapangan
                </h3>
                
                <?php 
                if(mysqli_num_rows($progress) > 0) {
                    while($p = mysqli_fetch_assoc($progress)) { 
                ?>
                    <div style="margin-bottom: 16px; padding-bottom: 16px; border-bottom: 1px dashed var(--border-color); display: flex; justify-content: space-between; align-items: flex-start; gap: 16px;">
                        
                        <div style="flex: 1;">
                            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px;">
                                <span style="font-weight: 700; color: var(--primary-gold); font-size: 15px;"><?= $p['persentase']; ?>%</span>
                                <span style="font-size: 11px; background: rgba(212,175,55,0.1); color: #b89322; padding: 2px 8px; border-radius: 20px; font-weight: 600;">
                                    <?= isset($p['tanggal_progress']) ? date('d M Y', strtotime($p['tanggal_progress'])) : 'Log'; ?>
                                </span>
                            </div>
                            <p style="font-size: 13px; color: #64748b; margin: 0; line-height: 1.4; word-break: break-word;"><?= $p['deskripsi']; ?></p>
                        </div>

                        <div style="width: 90px; height: 65px; border-radius: 6px; overflow: hidden; border: 1px solid var(--border-color); background: #f1f5f9; flex-shrink: 0; box-shadow: var(--shadow-sm);">
                            <?php 
                            $log_img_path = "../uploads/progress/" . $p['foto_progress'];
                            if(!empty($p['foto_progress']) && file_exists($log_img_path)): 
                            ?>
                                <img src="<?= $log_img_path; ?>" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                            <?php else: ?>
                                <img src="https://images.unsplash.com/photo-1541888946425-d81bb19240f5?auto=format&fit=crop&w=100&q=80" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                            <?php endif; ?>
                        </div>

                    </div>
                <?php 
                    } 
                } else {
                    echo '<p style="font-size:13px; color:#94a3b8; font-style:italic; margin:0;">Belum ada update progress.</p>';
                }
                ?>
            </div>

            <div class="card" style="background: white; padding: 20px; box-sizing: border-box; margin: 0;">
                <h3 style="font-size: 16px; font-weight: 700; color: #1e293b; margin-top: 0; margin-bottom: 16px; border-bottom: 2px solid #f1f5f9; padding-bottom: 8px;">
                    Tenaga Ahli Konstruksi
                </h3>
                
                <div style="display: flex; flex-direction: column; gap: 10px;">
                <?php 
                if(mysqli_num_rows($tukang) > 0) {
                    while($t = mysqli_fetch_assoc($tukang)) { 
                ?>
                    <div style="display: flex; align-items: center; justify-content: space-between; background: #fafafa; padding: 10px 14px; border-radius: var(--radius-sm); border: 1px solid var(--border-color);">
                        <div>
                            <strong style="font-size: 14px; color: #1e293b; display: block;"><?= $t['nama_tukang']; ?></strong>
                            <span style="font-size: 12px; color: #64748b;">Keahlian: <?= $t['spesialisasi']; ?></span>
                        </div>
                    </div>
                <?php 
                    } 
                } else {
                    echo '<p style="font-size:13px; color:#94a3b8; font-style:italic; margin:0;">Tidak ada penugasan pekerja aktif.</p>';
                }
                ?>
                </div>
            </div>

        </div>

    <?php endif; ?>

</div>

<script>
function kirimEmailKeDeveloper(kodeRumah) {
    var isiPesan = document.getElementById('pesanEmail').value;
    if(isiPesan.trim() === "") {
        alert("Silakan tulis pesan Anda terlebih dahulu sebelum mengirim!");
        return;
    }
    
    var emailDeveloper = "naufalrizky.j.p@gmail.com";
    var subjekEmail = encodeURIComponent("Tanya Unit Properti SIMPERUM: " + kodeRumah);
    var bodyEmail = encodeURIComponent(isiPesan);
    
    window.location.href = "mailto:" + emailDeveloper + "?subject=" + subjekEmail + "&body=" + bodyEmail;
}
</script>

</body>
</html>