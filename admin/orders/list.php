<?php
require_once __DIR__ . '/../../config/app.php';
require_once __DIR__ . '/../../backend/connection.php';

// Pagination & Filter
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page > 1) ? ($page * $limit) - $limit : 0;

$search = $_GET['search'] ?? '';
$status = $_GET['status'] ?? '';

$where = "WHERE 1=1";
if ($search) $where .= " AND (kd_invoice LIKE '%$search%' OR nm_user LIKE '%$search%')";
if ($status) $where .= " AND status_pembayaran = '$status'";

// Ambil Data
$query = "SELECT p.*, u.nm_user FROM penjualan p 
          JOIN user u ON p.id_user = u.id_user 
          $where ORDER BY p.tgl_penjualan DESC LIMIT $start, $limit";
$result = mysqli_query($conn, $query);

// Hitung Total untuk Pagination
$total_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM penjualan p JOIN user u ON p.id_user = u.id_user $where");
$total_data = mysqli_fetch_assoc($total_query)['total'];
$pages = ceil($total_data / $limit);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Pesanan - Pixel Part</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin:0; padding:0; }
        .admin-layout { display: grid; grid-template-columns: 260px 1fr; min-height: 100vh; }
        .sidebar-wrapper { background: #212529; }
        .main-wrapper { background: #f8f9fa; }
    </style>
</head>
<body>
<div class="admin-layout">
    <aside class="sidebar-wrapper"><?php include '../sidebar-admin.php'; ?></aside>
    <main class="main-wrapper">
        <nav class="navbar navbar-white bg-white border-bottom px-4 py-3">
            <h4 class="mb-0 fw-bold">Manajemen Pesanan</h4>
        </nav>

        <div class="p-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <form method="GET" class="row g-2">
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control" placeholder="Cari Invoice / Nama..." value="<?= $search ?>">
                        </div>
                        <div class="col-md-3">
                            <select name="status" class="form-select">
                                <option value="">Semua Status</option>
                                <option value="Pending" <?= $status == 'Pending' ? 'selected' : '' ?>>Pending</option>
                                <option value="Sudah Bayar" <?= $status == 'Sudah Bayar' ? 'selected' : '' ?>>Sudah Bayar</option>
                                <option value="Dikirim" <?= $status == 'Dikirim' ? 'selected' : '' ?>>Dikirim</option>
                                <option value="Selesai" <?= $status == 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-dark w-100">Filter</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Invoice</th>
                                <th>Pelanggan</th>
                                <th>Tanggal</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td class="ps-4 fw-bold text-primary"><?= $row['kd_invoice'] ?></td>
                                <td><?= $row['nm_user'] ?></td>
                                <td><?= date('d M Y', strtotime($row['tgl_penjualan'])) ?></td>
                                <td>Rp <?= number_format($row['total_harga'], 0, ',', '.') ?></td>
                                <td>
                                    <span class="badge rounded-pill bg-<?= $row['status_pembayaran'] == 'Selesai' ? 'success' : ($row['status_pembayaran'] == 'Pending' ? 'warning' : 'info') ?>">
                                        <?= $row['status_pembayaran'] ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="detail.php?id=<?= $row['id_penjualan'] ?>" class="btn btn-sm btn-outline-primary">Detail</a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <nav class="mt-4">
                <ul class="pagination justify-content-center">
                    <?php for($i=1; $i<=$pages; $i++): ?>
                        <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>&search=<?= $search ?>&status=<?= $status ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        </div>
    </main>
</div>
</body>
</html>