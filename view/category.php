<?php
require_once '../backend/connection.php';

$id_kategori = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$nama_kategori = '';
if ($id_kategori > 0) {
    $kat_query = "SELECT nm_kategori FROM kat_produk WHERE id_kategori = $id_kategori";
    $kat_result = mysqli_query($conn, $kat_query);
    if ($kat_result && mysqli_num_rows($kat_result) > 0) {
        $nama_kategori = mysqli_fetch_assoc($kat_result)['nm_kategori'];
    }
}

$query = "SELECT p.*, k.nm_kategori
          FROM produk p
          LEFT JOIN kat_produk k ON p.id_kategori = k.id_kategori
          WHERE p.id_kategori = $id_kategori AND p.kodisi = 1
          ORDER BY p.id_produk DESC";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo htmlspecialchars($nama_kategori); ?> - Pixel Part</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../public/css/style.css?v=<?php echo time(); ?>">
</head>
<body>

    <?php include 'template/navbar.php'; ?>

    <div class="container-fluid px-4 py-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../index.php" class="text-info text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active text-white"><?php echo htmlspecialchars($nama_kategori); ?></li>
            </ol>
        </nav>
    </div>

    <div class="container-fluid px-4 mb-5">
        <h2 class="section-title text-start mb-4"><?php echo htmlspecialchars($nama_kategori); ?></h2>

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
                    <p class="text-white-50">Belum ada produk untuk kategori ini.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php include 'template/footer.php'; ?>

    <script>
        function addToCart(id, name, price, image) {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            cart.push({ id, name, price, image, quantity: 1 });
            localStorage.setItem('cart', JSON.stringify(cart));
            alert('Berhasil ditambah ke keranjang!');
        }
        function beliProduk(id) { window.location.href = `product_detail.php?id=${id}`; }
    </script>
</body>
</html>