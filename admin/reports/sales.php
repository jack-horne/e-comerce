<?php
require_once __DIR__ . '/../../config/app.php';
require_once __DIR__ . '/../../backend/connection.php';

// Filter Tanggal
$tgl_mulai = $_GET['tgl_mulai'] ?? date('Y-m-01');
$tgl_selesai = $_GET['tgl_selesai'] ?? date('Y-m-d');

// 1. Ringkasan Data
$q_total = mysqli_query($conn, "SELECT SUM(total_harga) as total FROM penjualan 
           WHERE status_pembayaran = 'Sudah Bayar' 
           AND DATE(tgl_penjualan) BETWEEN '$tgl_mulai' AND '$tgl_selesai'");
$row_total = mysqli_fetch_assoc($q_total);
$total_all = $row_total['total'] ?? 0;

$q_transaksi = mysqli_query($conn, "SELECT COUNT(*) as jml FROM penjualan 
               WHERE DATE(tgl_penjualan) BETWEEN '$tgl_mulai' AND '$tgl_selesai'");
$row_trans = mysqli_fetch_assoc($q_transaksi);
$jml_trans = $row_trans['jml'] ?? 0;

// 2. Query Detail
$query = "SELECT p.*, u.nm_user 
          FROM penjualan p 
          JOIN user u ON p.id_user = u.id_user 
          WHERE DATE(p.tgl_penjualan) BETWEEN '$tgl_mulai' AND '$tgl_selesai'
          ORDER BY p.tgl_penjualan DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan - Pixel Part</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/admin.css">
    <style>
        /* RESET TOTAL */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { overflow-x: hidden; background-color: #f8f9fa; }

        /* LAYOUT UTAMA */
        .admin-container {
            display: grid;
            grid-template-columns: 250px 1fr; /* Sidebar tetap 250px, Sisanya Konten */
            min-height: 100vh;
        }

        /* SIDEBAR AREA */
        .sidebar-area {
            background-color: #212529; /* Warna Hitam Sidebar */
        }

        /* CONTENT AREA */
        .content-area {
            background-color: #f8f9fa; /* Warna Abu-abu Konten */
        }

        .bg-success-soft { background-color: #e8fadf; color: #198754; border-radius: 5px; }
        .bg-warning-soft { background-color: #fff8e1; color: #ffc107; border-radius: 5px; }
        
        @media print {
            .sidebar-area, .navbar, .btn, .filter-card { display: none !important; }
            .admin-container { grid-template-columns: 1fr; }
            .content-area { padding: 0 !important; }
        }
    </style>
</head>
<body>

    <div class="admin-container">
        <div class="sidebar-area">
            <?php include '../sidebar-admin.php'; ?>
        </div>

        <main class="content-area">
            <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm">
                <div class="container-fluid px-4">
                    <h4 class="mb-0 fw-bold">Laporan Penjualan</h4>
                    <button onclick="window.print()" class="btn btn-primary btn-sm ms-auto">
                        <i class="fas fa-print me-1"></i> Cetak PDF
                    </button>
                </div>
            </nav>

            <div class="p-4">
                <div class="card border-0 shadow-sm mb-4 filter-card">
                    <div class="card-body">
                        <form method="GET" class="row g-3 align-items-end">
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">Dari Tanggal</label>
                                <input type="date" name="tgl_mulai" class="form-control" value="<?= $tgl_mulai ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">Sampai Tanggal</label>
                                <input type="date" name="tgl_selesai" class="form-control" value="<?= $tgl_selesai ?>">
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-dark w-100">Filter Data</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm bg-primary text-white p-3">
                            <small class="opacity-75">Total Omzet</small>
                            <h3 class="fw-bold mb-0">Rp <?= number_format($total_all, 0, ',', '.') ?></h3>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm bg-white p-3 border-start border-4 border-info">
                            <small class="text-muted">Jumlah Transaksi</small>
                            <h3 class="fw-bold mb-0"><?= $jml_trans ?> Pesanan</h3>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-body p-0">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr class="small text-muted text-uppercase">
                                    <th class="ps-4">No</th>
                                    <th>Tanggal</th>
                                    <th>Invoice</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Status</th>
                                    <th class="pe-4">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; while($row = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td class="ps-4"><?= $no++ ?></td>
                                    <td><?= date('d/m/Y', strtotime($row['tgl_penjualan'])) ?></td>
                                    <td class="fw-bold text-primary"><?= $row['kd_invoice'] ?></td>
                                    <td><?= $row['nm_user'] ?></td>
                                    <td>
                                        <span class="badge <?= $row['status_pembayaran'] == 'Sudah Bayar' ? 'bg-success-soft' : 'bg-warning-soft' ?> px-3">
                                            <?= $row['status_pembayaran'] ?>
                                        </span>
                                    </td>
                                    <td class="fw-bold pe-4">Rp <?= number_format($row['total_harga'], 0, ',', '.') ?></td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

</body>
</html>