<?php
require_once __DIR__ . '/../../config/app.php';
require_once __DIR__ . '/../../backend/connection.php';

$id = $_GET['id'];

// Update Status Logic
if (isset($_POST['update_status'])) {
    $new_status = $_POST['status_pembayaran'];
    mysqli_query($conn, "UPDATE penjualan SET status_pembayaran = '$new_status' WHERE id_penjualan = '$id'");
    header("Location: detail.php?id=$id&msg=updated");
}

// Ambil Data Penjualan
$q_penjualan = mysqli_query($conn, "SELECT p.*, u.nm_user, u.email FROM penjualan p JOIN user u ON p.id_user = u.id_user WHERE p.id_penjualan = '$id'");
$data = mysqli_fetch_assoc($q_penjualan);

// Ambil Detail Produk yang dibeli
$items = mysqli_query($conn, "SELECT dp.*, pr.nm_produk FROM detail_penjualan dp 
                              JOIN produk pr ON dp.id_produk = pr.id_produk 
                              WHERE dp.id_penjualan = '$id'");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Pesanan #<?= $data['kd_invoice'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin:0; padding:0; }
        .admin-layout { display: grid; grid-template-columns: 260px 1fr; min-height: 100vh; }
        .sidebar-wrapper { background: #212529; }
    </style>
</head>
<body>
<div class="admin-layout">
    <aside class="sidebar-wrapper"><?php include '../sidebar-admin.php'; ?></aside>
    <main class="p-4 bg-light">
        <a href="list.php" class="btn btn-sm btn-secondary mb-3"><i class="fas fa-arrow-left"></i> Kembali</a>
        
        <div class="row">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white fw-bold">Rincian Produk</div>
                    <div class="card-body p-0">
                        <table class="table mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3">Produk</th>
                                    <th>Harga</th>
                                    <th>Qty</th>
                                    <th class="text-end pe-3">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($item = mysqli_fetch_assoc($items)): ?>
                                <tr>
                                    <td class="ps-3"><?= $item['nm_produk'] ?></td>
                                    <td>Rp <?= number_format($item['harga_satuan'], 0, ',', '.') ?></td>
                                    <td><?= $item['jumlah'] ?></td>
                                    <td class="text-end pe-3">Rp <?= number_format($item['subtotal'], 0, ',', '.') ?></td>
                                </tr>
                                <?php endwhile; ?>
                                <tr class="table-dark">
                                    <td colspan="3" class="ps-3 fw-bold">TOTAL BAYAR</td>
                                    <td class="text-end pe-3 fw-bold">Rp <?= number_format($data['total_harga'], 0, ',', '.') ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white fw-bold">Info Pelanggan</div>
                    <div class="card-body">
                        <p class="mb-1 small text-muted">Nama:</p>
                        <h6 class="fw-bold"><?= $data['nm_user'] ?></h6>
                        <p class="mb-1 small text-muted">Email:</p>
                        <h6><?= $data['email'] ?></h6>
                        <hr>
                        <form method="POST">
                            <label class="form-label small fw-bold">Update Status Pesanan</label>
                            <select name="status_pembayaran" class="form-select mb-3">
                                <option value="Pending" <?= $data['status_pembayaran'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                                <option value="Sudah Bayar" <?= $data['status_pembayaran'] == 'Sudah Bayar' ? 'selected' : '' ?>>Sudah Bayar</option>
                                <option value="Dikirim" <?= $data['status_pembayaran'] == 'Dikirim' ? 'selected' : '' ?>>Dikirim</option>
                                <option value="Selesai" <?= $data['status_pembayaran'] == 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                            </select>
                            <button type="submit" name="update_status" class="btn btn-primary w-100">Simpan Perubahan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
</body>
</html>