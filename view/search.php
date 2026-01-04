<?php
require_once __DIR__ . '/../config/init.php';

$query = isset($_GET['q']) ? trim($_GET['q']) : '';

if (empty($query)) {
    header('Location: ' . BASE_URL . '/index.php');
    exit;
}

// Query untuk mencari produk berdasarkan nama
$search_query = "SELECT p.*, k.nm_kategori
                 FROM produk p
                 LEFT JOIN kat_produk k ON p.id_kategori = k.id_kategori
                 WHERE p.kodisi = 1 AND (p.nm_produk LIKE ? OR k.nm_kategori LIKE ?)
                 ORDER BY p.id_produk DESC";

$stmt = mysqli_prepare($conn, $search_query);
$search_term = '%' . $query . '%';
mysqli_stmt_bind_param($stmt, 'ss', $search_term, $search_term);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hasil Pencarian: <?php echo htmlspecialchars($query); ?> - Pixel Part</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../public/css/style.css?v=<?php echo time(); ?>">
</head>
<body>

    <?php include 'template/navbar.php'; ?>

    <div class="container-fluid px-4 py-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="../index.php" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Beranda
            </a>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="../index.php" class="text-info text-decoration-none">Home</a></li>
                    <li class="breadcrumb-item active text-white">Hasil Pencarian: "<?php echo htmlspecialchars($query); ?>"</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container-fluid px-4 mb-5">
        <h2 class="section-title text-start mb-4">Hasil Pencarian untuk "<?php echo htmlspecialchars($query); ?>"</h2>

        <div class="row g-4">
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="product-card">
                            <?php if ($row['diskon'] > 0): ?>
                                <div class="product-discount-badge">-<?php echo $row['diskon']; ?>%</div>
                            <?php endif; ?>

                            <div class="product-image-container">
                                <?php $gambar = !empty($row['gambar']) ? $row['gambar'] : 'default.jpg'; ?>
                                <img src="../public/image/product/<?php echo htmlspecialchars($gambar); ?>" alt="<?php echo htmlspecialchars($row['nm_produk']); ?>">
                            </div>

                            <div class="product-info">
                                <h5 class="product-title"><?php echo htmlspecialchars($row['nm_produk']); ?></h5>
                                <p class="product-subtitle"><?php echo htmlspecialchars($row['nm_kategori']); ?></p>

                                <div class="mb-2">
                                    <span class="text-warning small"><i class="fas fa-star"></i> <?php echo number_format($row['rate'] ?? 0, 1); ?></span>
                                </div>

                                <?php
                                    $stok = $row['qyt'];
                                    $stock_class = $stok > 10 ? 'in-stock' : ($stok > 0 ? 'low-stock' : 'out-stock');
                                    $stock_text = $stok > 10 ? '✓ Tersedia' : ($stok > 0 ? '⚠ Terbatas' : '✗ Habis');
                                ?>
                                <div class="mb-2"><span class="stock-badge <?php echo $stock_class; ?>"><?php echo $stock_text; ?></span></div>

                                <div class="price-container">
                                    <?php if ($row['diskon'] > 0): ?>
                                        <span class="price-old">Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></span>

                                        <span class="price-new">Rp <?php echo number_format($row['harga'] * (1 - $row['diskon']/100), 0, ',', '.'); ?></span>
                                    <?php else: ?>
                                        <span class="price-new">Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></span>
                                    <?php endif; ?>
                                </div>

                                <div class="btn-action-group">
                                    <button class="btn-beli-custom" onclick="beliProduk(<?php echo $row['id_produk']; ?>)">Beli Sekarang</button>
                                    <button class="btn-keranjang-custom" onclick="addToCart(<?php echo $row['id_produk']; ?>, '<?php echo addslashes($row['nm_produk']); ?>', <?php echo $row['harga']; ?>, '<?php echo addslashes($gambar); ?>')">
                                        <i class="fas fa-shopping-cart"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <p class="text-white-50">Tidak ada produk yang ditemukan untuk "<?php echo htmlspecialchars($query); ?>".</p>
                    <a href="../index.php" class="btn btn-primary">Kembali ke Beranda</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php include 'template/footer.php'; ?>

    <script>
        function addToCart(id, name, price, image) {
            fetch('../backend/add_to_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'product_id=' + id + '&quantity=1'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Produk berhasil ditambahkan ke keranjang!');
                    updateCartBadge();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menambahkan ke keranjang');
            });
        }

        function updateCartBadge() {
            // Implement cart count fetching if needed
        }

        function beliProduk(id) {
            window.location.href = `product_detail.php?id=${id}`;
        }
    </script>
</body>
</html>
