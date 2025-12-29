<?php
require_once __DIR__ . '/../../config/app.php';
require_once __DIR__ . '/../../backend/connection.php';

/**
 * QUERY PENJELASAN:
 * Kita mengambil data dari tabel 'penjualan'
 * JOIN ke tabel 'user' untuk mendapatkan nama pembeli (nm_user)
 * Karena 'penjualan' tidak punya id_produk langsung (adanya di detail_penjualan),
 * kita akan menampilkan info utama penjualannya dulu di list ini.
 */
$query = "SELECT penjualan.*, user.nm_user 
          FROM penjualan 
          JOIN user ON penjualan.id_user = user.id_user 
          ORDER BY penjualan.id_penjualan DESC";

$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query Error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Pesanan - Pixel Part</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/admin.css">
</head>
<body>
    <div class="wrapper d-flex">
        <?php include '../sidebar-admin.php'; ?>
        
        <main class="main-content flex-grow-1">
            <?php include '../navbar-admin.php'; ?>
            
            <div class="p-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold"><i class="fas fa-shopping-cart me-2 text-primary"></i>Daftar Penjualan</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>No. Invoice</th>
                                    <th>Pelanggan</th>
                                    <th>Total Harga</th>
                                    <th>Status Bayar</th>
                                    <th>Status Kirim</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (mysqli_num_rows($result) > 0) : ?>
                                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                                    <tr>
                                        <td><strong><?= $row['kd_invoice'] ?></strong></td>
                                        <td><?= htmlspecialchars($row['nm_user']) ?></td>
                                        <td>Rp <?= number_format($row['total_harga'], 0, ',', '.') ?></td>
                                        <td>
                                            <span class="badge <?= $row['status_pembayaran'] == 'Sudah Bayar' ? 'bg-success' : 'bg-warning text-dark' ?>">
                                                <?= $row['status_pembayaran'] ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-info text-white"><?= $row['status_pengiriman'] ?></span>
                                        </td>
                                        <td class="text-center">
                                            <a href="detail.php?id=<?= $row['id_penjualan'] ?>" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i> Detail
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">Belum ada transaksi penjualan.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>