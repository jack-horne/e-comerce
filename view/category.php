<?php
require_once '../backend/connection.php';

// Ambil ID kategori dari URL
$id_kategori = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Ambil nama kategori
$nama_kategori = '';
if ($id_kategori > 0) {
    $kat_query = "SELECT nm_kategori FROM kat_produk WHERE id_kategori = $id_kategori";
    $kat_result = mysqli_query($conn, $kat_query);
    if ($kat_result && mysqli_num_rows($kat_result) > 0) {
        $nama_kategori = mysqli_fetch_assoc($kat_result)['nm_kategori'];
    }
}

// Ambil produk berdasarkan kategori
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="stylesheet" href="../public/css/simple-banner.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top shadow-sm">
        <div class="container-fluid px-4">
            <a class="navbar-brand fw-bold d-flex align-items-center" href="../index.php">
                <img src="../public/image/icons/logo.png" alt="Logo" width="35" height="35" class="me-2">
                Pixel Part
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
                <form class="d-flex flex-grow-1 justify-content-center mx-lg-4 my-2 my-lg-0" role="search">
                    <div class="input-group w-75 w-lg-50">
                        <input class="form-control border-0" type="search" placeholder="Search..." aria-label="Search">
                        <button class="btn btn-light border-0" type="submit">
                            <i class="fas fa-search text-primary"></i>
                        </button>
                    </div>
                </form>

                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link text-white fw-semibold" href="../index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white fw-semibold" href="login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white fw-semibold" href="register.php">Register</a>
                    </li>
                    <li class="nav-item position-relative">
                        <a class="nav-link text-white fw-semibold" href="template/chart.php">
                            <i class="fas fa-shopping-cart"></i> Keranjang
                            <span class="badge bg-danger position-absolute top-0 start-100 translate-middle" id="cart-count">0</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Breadcrumb -->
    <div class="container-fluid px-4 py-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($nama_kategori); ?></li>
            </ol>
        </nav>
    </div>

    <!-- Products Section -->
    <div class="products-container">
        <div class="container-fluid px-4">
            <h2 class="section-title"><?php echo htmlspecialchars($nama_kategori); ?></h2>

            <div class="row g-4">
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                            <div class="product-card" data-id="<?php echo $row['id_produk']; ?>" data-name="<?php echo htmlspecialchars($row['nm_produk']); ?>" data-price="<?php echo $row['harga']; ?>" data-image="../public/image/product/<?php echo htmlspecialchars($row['gambar']); ?>">
                                <div class="product-image-container">
                                    <?php if (!empty($row['gambar'])): ?>
                                        <img src="../public/image/product/<?php echo htmlspecialchars($row['gambar']); ?>" alt="<?php echo htmlspecialchars($row['nm_produk']); ?>">
                                    <?php else: ?>
                                        <img src="../public/image/product/default.jpg" alt="No Image">
                                    <?php endif; ?>
                                </div>
                                <div class="product-info">
                                    <?php if ($row['diskon'] > 0): ?>
                                        <div class="product-discount">-<?php echo $row['diskon']; ?>%</div>
                                    <?php endif; ?>
                                    <h5 class="product-title"><?php echo htmlspecialchars($row['nm_produk']); ?></h5>
                                    <p class="product-subtitle"><?php echo htmlspecialchars($row['nm_kategori']); ?></p>
                                    <div class="product-rating">
                                        <i class="fas fa-star"></i> <?php echo number_format($row['rate'] ?? 0, 1); ?> (<?php echo rand(10, 200); ?>)
                                    </div>
                                    <?php
                                    $stok = $row['qyt'];
                                    $stock_class = $stok > 10 ? 'in-stock' : ($stok > 0 ? 'low-stock' : 'out-stock');
                                    $stock_text = $stok > 10 ? '✓ Tersedia' : ($stok > 0 ? '⚠ Terbatas' : '✗ Habis');
                                    ?>
                                    <div class="stock-badge <?php echo $stock_class; ?>"><?php echo $stock_text; ?></div>
                                    <p class="product-price">
                                        <?php if ($row['diskon'] > 0): ?>
                                            <span class="text-muted text-decoration-line-through">Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></span>
                                            Rp <?php echo number_format($row['harga'] * (1 - $row['diskon']/100), 0, ',', '.'); ?>
                                        <?php else: ?>
                                            Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?>
                                        <?php endif; ?>
                                    </p>
                                    <div class="d-flex gap-2">
                                        <button class="btn-beli flex-fill" onclick="beliProduk(<?php echo $row['id_produk']; ?>)">
                                            <i class="fas fa-shopping-bag"></i> Beli
                                        </button>
                                        <button class="btn-keranjang flex-fill add-to-cart" onclick="addToCart(<?php echo $row['id_produk']; ?>, '<?php echo addslashes($row['nm_produk']); ?>', <?php echo $row['harga']; ?>, '<?php echo addslashes($row['gambar']); ?>')">
                                            <i class="fas fa-shopping-cart"></i> Keranjang
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="col-12 text-center py-5">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">Tidak ada produk dalam kategori ini</h4>
                        <p class="text-muted">Produk akan segera ditambahkan.</p>
                        <a href="../index.php" class="btn btn-primary">Kembali ke Home</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white py-5 mt-5">
        <div class="container-fluid px-4">
            <div class="row mb-4">
                <div class="col-md-4 mb-3 mb-md-0">
                    <h6 class="fw-bold mb-3">Tentang Kami</h6>
                    <p class="small text-white-50">Pixel Part adalah platform e-commerce terpercaya untuk elektronik berkualitas dengan jaminan harga terbaik.</p>
                </div>
                <div class="col-md-4 mb-3 mb-md-0">
                    <h6 class="fw-bold mb-3">Layanan</h6>
                    <ul class="list-unstyled small">
                        <li><a href="#" class="text-white-50 text-decoration-none">Pengiriman Gratis</a></li>
                        <li><a href="#" class="text-white-50 text-decoration-none">Garansi Resmi</a></li>
                        <li><a href="#" class="text-white-50 text-decoration-none">Cicilan 0%</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h6 class="fw-bold mb-3">Hubungi Kami</h6>
                    <p class="small text-white-50">📞 +62-XXX-XXX-XXX<br>📧 support@pixelpart.com</p>
                </div>
            </div>
            <hr class="bg-secondary">
            <p class="text-center small mb-0">&copy; 2025 Pixel Part. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Shopping cart functionality
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        updateCartBadge();

        function addToCart(id, name, price, image) {
            const existingProduct = cart.find(item => item.id === id);
            if (existingProduct) {
                existingProduct.quantity += 1;
            } else {
                cart.push({
                    id: id,
                    name: name,
                    price: price,
                    image: image,
                    quantity: 1
                });
            }

            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartBadge();
            alert('Produk ditambahkan ke keranjang!');
        }

        function beliProduk(id) {
            // Redirect to product detail or checkout
            window.location.href = `product-detail.php?id=${id}`;
        }

        function updateCartBadge() {
            const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
            const badge = document.getElementById('cart-count');
            if (badge) {
                badge.textContent = totalItems;
            }
        }
    </script>
</body>
</html>
