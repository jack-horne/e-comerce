<?php
/** * @var mysqli $conn
 * @method string base_url(string $path = '')
 */

session_start();

//hapus stringnya jika sudah pny akun admin 

// Cek login admin
//if (!isset($_SESSION['admin_id'])) {
//header("Location: ../../index.php");
//    exit();
//}

require_once __DIR__ . "/../../config/init.php";

// Pagination
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;


// Gunakan $conn yang berasal dari init.php -> base.php
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$kategori_filter = isset($_GET['kategori']) ? (int)$_GET['kategori'] : 0;

// Query dengan filter
$where = "WHERE 1=1";
if ($search) {
    $where .= " AND p.nm_produk LIKE '%$search%'";
}
if ($kategori_filter > 0) {
    $where .= " AND p.id_kategori = $kategori_filter";
}

// Hitung total produk
$count_query = "SELECT COUNT(*) as total FROM produk p $where";
$count_result = mysqli_query($conn, $count_query);
$total_products = mysqli_fetch_assoc($count_result)['total'];
$total_pages = ceil($total_products / $limit);

// Ambil data produk
$query = "SELECT p.*, k.nm_kategori 
          FROM produk p 
          LEFT JOIN kat_produk k ON p.id_kategori = k.id_kategori 
          $where 
          ORDER BY p.id_produk DESC 
          LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $query);

// Ambil semua kategori untuk filter
$kategori_query = "SELECT * FROM kat_produk ORDER BY nm_kategori";
$kategori_result = mysqli_query($conn, $kategori_query);

// Handle pesan sukses/error
$message = '';
if (isset($_GET['success'])) {
    if ($_GET['success'] == 'add') $message = '<div class="alert alert-success">Produk berhasil ditambahkan!</div>';
    if ($_GET['success'] == 'edit') $message = '<div class="alert alert-success">Produk berhasil diupdate!</div>';
    if ($_GET['success'] == 'delete') $message = '<div class="alert alert-success">Produk berhasil dihapus!</div>';
}
if (isset($_GET['error'])) {
    $message = '<div class="alert alert-danger">Terjadi kesalahan!</div>';
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Produk - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            min-height: 100vh;
        }
        .product-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
        }
        .badge-status {
            font-size: 0.85rem;
        }
        .action-btns a {
            margin: 0 2px;
        }
        .card {
            border-radius: 15px;
            border: none;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
            border-radius: 8px;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        h2 {
            color: white;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }
        .table {
            background: white;
            border-radius: 10px;
        }
        .alert {
            border-radius: 10px;
            border: none;
        }
    </style>
</head>
<body>
    
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2">
                <?php include '../sidebar-admin.php'; ?>
            </div>
            
            <div class="col-md-10 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2><i class="fas fa-box"></i> Daftar Produk</h2>
                    <a href="add.php" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Produk
                    </a>
                </div>

                <?php echo $message; ?>

                <div class="card mb-3">
                    <div class="card-body">
                        <form method="GET" class="row g-3">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="Cari produk..." value="<?php echo htmlspecialchars($search); ?>">
                            </div>
                            <div class="col-md-3">
                                <select name="kategori" class="form-select">
                                    <option value="0">Semua Kategori</option>
                                    <?php while ($kat = mysqli_fetch_assoc($kategori_result)): ?>
                                        <option value="<?php echo $kat['id_kategori']; ?>" 
                                            <?php echo ($kategori_filter == $kat['id_kategori']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($kat['nm_kategori']); ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-secondary w-100">
                                    <i class="fas fa-search"></i> Search
                                </button>
                            </div>
                            <div class="col-md-2">
                                <a href="list.php" class="btn btn-outline-secondary w-100">
                                    <i class="fas fa-redo"></i> Reset
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Gambar</th>
                                        <th>Nama Produk</th>
                                        <th>Kategori</th>
                                        <th>Harga</th>
                                        <th>Stok</th>
                                        <th>Diskon</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (mysqli_num_rows($result) > 0): ?>
                                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                            <tr>
                                                <td><?php echo $row['id_produk']; ?></td>
                                                <td>
                                                    <?php if (!empty($row['gambar'])): ?>
                                                        <img src="<?php echo base_url('public/image/product/' . htmlspecialchars($row['gambar'])); ?>"
                                                             class="product-img" alt="Produk">
                                                    <?php else: ?>
                                                        <div class="product-img bg-secondary d-flex align-items-center justify-content-center">
                                                            <i class="fas fa-image text-white"></i>
                                                        </div>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <strong><?php echo htmlspecialchars($row['nm_produk']); ?></strong>
                                                    <br>
                                                    <small class="text-muted">
                                                        <i class="fas fa-star text-warning"></i> 
                                                        <?php echo number_format($row['rate'] ?? 0, 1); ?>
                                                    </small>
                                                </td>
                                                <td>
                                                    <span class="badge bg-info">
                                                        <?php echo htmlspecialchars($row['nm_kategori'] ?? 'Tanpa Kategori'); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <strong>Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></strong>
                                                </td>
                                                <td>
                                                    <?php 
                                                    $stok = $row['qyt'];
                                                    $badge_color = $stok > 10 ? 'success' : ($stok > 0 ? 'warning' : 'danger');
                                                    ?>
                                                    <span class="badge bg-<?php echo $badge_color; ?>">
                                                        <?php echo $stok; ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <?php if ($row['diskon'] > 0): ?>
                                                        <span class="badge bg-danger">-<?php echo $row['diskon']; ?>%</span>
                                                    <?php else: ?>
                                                        <span class="text-muted">-</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php 
                                                    $kodisi = $row['kodisi'];
                                                    $status_badge = [
                                                        '1' => ['text' => 'Tersedia', 'color' => 'success'],
                                                        '0' => ['text' => 'Habis', 'color' => 'danger']
                                                    ];
                                                    $status = $status_badge[$kodisi] ?? ['text' => 'Tidak Diketahui', 'color' => 'secondary'];
                                                    ?>
                                                    <span class="badge bg-<?php echo $status['color']; ?> badge-status">
                                                        <?php echo $status['text']; ?>
                                                    </span>
                                                </td>
                                                <td class="action-btns">
                                                    <a href="edit.php?id=<?php echo $row['id_produk']; ?>" 
                                                       class="btn btn-sm btn-warning" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="delete.php?id=<?php echo $row['id_produk']; ?>" 
                                                       class="btn btn-sm btn-danger" 
                                                       onclick="return confirm('Yakin ingin menghapus produk ini?')" 
                                                       title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="9" class="text-center py-4">
                                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                                <p class="text-muted">Tidak ada produk ditemukan</p>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <?php if ($total_pages > 1): ?>
                            <nav>
                                <ul class="pagination justify-content-center mt-3">
                                    <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                                        <a class="page-link" href="?page=<?php echo $page-1; ?>&search=<?php echo urlencode($search); ?>&kategori=<?php echo $kategori_filter; ?>">
                                            Previous
                                        </a>
                                    </li>
                                    
                                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                        <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                                            <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>&kategori=<?php echo $kategori_filter; ?>">
                                                <?php echo $i; ?>
                                            </a>
                                        </li>
                                    <?php endfor; ?>
                                    
                                    <li class="page-item <?php echo ($page >= $total_pages) ? 'disabled' : ''; ?>">
                                        <a class="page-link" href="?page=<?php echo $page+1; ?>&search=<?php echo urlencode($search); ?>&kategori=<?php echo $kategori_filter; ?>">
                                            Next
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        <?php endif; ?>

                        <div class="text-center text-muted mt-2">
                            Menampilkan <?php echo min($offset + 1, $total_products); ?> - 
                            <?php echo min($offset + $limit, $total_products); ?> dari 
                            <?php echo $total_products; ?> produk
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>