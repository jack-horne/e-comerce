<?php
require_once __DIR__ . "/../../config/init.php";
/*
// Proteksi Admin
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
    header("Location: " . BASE_URL . "/view/login.php");
    exit;
}
*/

// Cek ID dari URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die('ID pesanan tidak ditemukan. Kembali ke <a href="list.php">Daftar</a>');
}

$id = (int) $_GET['id'];

// --- UPDATE STATUS ---
if (isset($_POST['update_status'])) {
    $new_status = mysqli_real_escape_string($conn, $_POST['status_pembayaran']);
    mysqli_query($conn, "UPDATE penjualan SET status_pembayaran = '$new_status' WHERE id_penjualan = $id");
    header("Location: detail.php?id=$id&msg=updated");
    exit;
}

// --- DATA INVOICE ---
$q_penjualan = mysqli_query($conn, "SELECT p.*, u.nm_user, u.email 
                                    FROM penjualan p 
                                    JOIN user u ON p.id_user = u.id_user 
                                    WHERE p.id_penjualan = $id");
$data = mysqli_fetch_assoc($q_penjualan);

if (!$data) {
    die("Data pesanan #$id tidak ditemukan.");
}

// --- DATA ITEM (Sesuaikan nama kolom dengan image_6b5589.png) ---
$items = mysqli_query($conn, "SELECT dp.*, pr.nm_produk 
                              FROM detail_penjualan dp 
                              JOIN produk pr ON dp.id_produk = pr.id_produk 
                              WHERE dp.id_penjualan = $id");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail #<?= $data['kd_invoice'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <a href="list.php" class="btn btn-sm btn-secondary mb-3"> Kembali</a>
    
    <div class="row">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white fw-bold">Rincian Invoice: <?= $data['kd_invoice'] ?></div>
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
                            <?php 
                            $grand_total = 0;
                            while($item = mysqli_fetch_assoc($items)): 
                                $subtotal = $item['harga'] * $item['qty']; // Hitung subtotal
                                $grand_total += $subtotal;
                            ?>
                            <tr>
                                <td class="ps-3"><?= htmlspecialchars($item['nm_produk']) ?></td>
                                <td>Rp <?= number_format($item['harga'], 0, ',', '.') ?></td>
                                <td><?= $item['qty'] ?></td>
                                <td class="text-end pe-3">Rp <?= number_format($subtotal, 0, ',', '.') ?></td>
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
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white fw-bold">Status Pesanan</div>
                <div class="card-body">
                    <p class="small text-muted mb-1">Pelanggan:</p>
                    <h6><?= htmlspecialchars($data['nm_user']) ?></h6>
                    <hr>
                    <form method="POST">
                        <select name="status_pembayaran" class="form-select mb-3">
                            <option value="Pending" <?= $data['status_pembayaran'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="Sudah Bayar" <?= $data['status_pembayaran'] == 'Sudah Bayar' ? 'selected' : '' ?>>Sudah Bayar</option>
                            <option value="Selesai" <?= $data['status_pembayaran'] == 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                        </select>
                        <button type="submit" name="update_status" class="btn btn-primary w-100">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

