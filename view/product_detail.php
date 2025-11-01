<?php
require_once '../backend/connection.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: ../index.php');
    exit;
}

$product_id = (int)$_GET['id'];

// Ambil detail produk
$query = "SELECT p.*, k.nm_kategori
          FROM produk p
          LEFT JOIN kat_produk k ON p.id_kategori = k.id_kategori
          WHERE p.id_produk = ? AND p.kodisi = 1";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $product_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) == 0) {
    header('Location: ../index.php');
    exit;
}

$product = mysqli_fetch_assoc($result);
?>

<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo htmlspecialchars($product['nm_produk']); ?> - MyWebsite</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body>
    <!-- Navbar Start -->
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

    <!-- Product Detail Section -->
    <div class="container-fluid px-4 py-5">
        <div class="row g-4">
            <!-- Product Image -->
            <div class="col-lg-6">
                <div class="product-image-container" style="height: 500px;">
                    <?php if (!empty($product['gambar'])): ?>
                        <img src="../public/image/product/<?php echo htmlspecialchars($product['gambar']); ?>"
                             alt="<?php echo htmlspecialchars($product['nm_produk']); ?>"
                             class="w-100 h-100 object-fit-contain">
                    <?php else: ?>
                        <img src="../public/image/product/default.jpg" alt="No Image" class="w-100 h-100 object-fit-contain">
                    <?php endif; ?>
                </div>
            </div>

            <!-- Product Info -->
            <div class="col-lg-6">
                <div class="product-info">
                    <?php if ($product['diskon'] > 0): ?>
                        <div class="product-discount">-<?php echo $product['diskon']; ?>%</div>
                    <?php endif; ?>

                    <h1 class="h2 mb-3"><?php echo htmlspecialchars($product['nm_produk']); ?></h1>
                    <p class="text-muted mb-3"><?php echo htmlspecialchars($product['nm_kategori']); ?></p>

                    <div class="product-rating mb-3">
                        <i class="fas fa-star text-warning"></i>
                        <?php echo number_format($product['rate'] ?? 0, 1); ?> (<?php echo rand(10, 200); ?> ulasan)
                    </div>

                    <?php
                    $stok = $product['qyt'];
                    $stock_class = $stok > 10 ? 'in-stock' : ($stok > 0 ? 'low-stock' : 'out-stock');
                    $stock_text = $stok > 10 ? '✓ Tersedia' : ($stok > 0 ? '⚠ Terbatas' : '✗ Habis');
                    ?>
                    <div class="stock-badge <?php echo $stock_class; ?> mb-3"><?php echo $stock_text; ?></div>

                    <div class="product-price mb-4">
                        <?php if ($product['diskon'] > 0): ?>
                            <span class="text-muted text-decoration-line-through h5 me-2">
                                Rp <?php echo number_format($product['harga'], 0, ',', '.'); ?>
                            </span>
                            <span class="text-primary h3 fw-bold">
                                Rp <?php echo number_format($product['harga'] * (1 - $product['diskon']/100), 0, ',', '.'); ?>
                            </span>
                        <?php else: ?>
                            <span class="text-primary h3 fw-bold">
                                Rp <?php echo number_format($product['harga'], 0, ',', '.'); ?>
                            </span>
                        <?php endif; ?>
                    </div>

                    <div class="d-grid gap-3">
                        <button class="btn btn-primary btn-lg" onclick="beliProduk(<?php echo $product['id_produk']; ?>)">
                            <i class="fas fa-shopping-bag me-2"></i>Beli Sekarang
                        </button>
                        <button class="btn btn-outline-primary btn-lg add-to-cart"
                                onclick="addToCart(<?php echo $product['id_produk']; ?>, '<?php echo addslashes($product['nm_produk']); ?>', <?php echo $product['harga'] * (1 - $product['diskon']/100); ?>, '<?php echo addslashes($product['gambar']); ?>')">
                            <i class="fas fa-shopping-cart me-2"></i>Tambah ke Keranjang
                        </button>
                    </div>

                    <div class="mt-4">
                        <h5 class="mb-2">Deskripsi Produk</h5>
                        <p class="text-muted"><?php echo nl2br(htmlspecialchars($product['deskripsi'] ?? 'Deskripsi produk tidak tersedia.')); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white py-5 mt-5">
        <div class="container-fluid px-4">
            <div class="row mb-4">
                <div class="col-md-4 mb-3 mb-md-0">
                    <h6 class="fw-bold mb-3">Tentang Kami</h6>
                    <p class="small text-white-50">MyWebsite adalah platform e-commerce terpercaya untuk elektronik berkualitas dengan jaminan harga terbaik.</p>
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
                    <p class="small text-white-50">📞 +62-XXX-XXX-XXX<br>📧 support@mywebsite.com</p>
                </div>
            </div>
            <hr class="bg-secondary">
            <p class="text-center small mb-0">&copy; 2025 MyWebsite. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Shopping cart functionality
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        updateCartBadge();

        function updateCartBadge() {
            const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
            const badge = document.getElementById('cart-count');
            if (badge) {
                badge.textContent = totalItems;
            }
        }

        function addToCart(id, name, price, image) {
            const product = {
                id: id,
                name: name,
                price: price,
                image: image,
                quantity: 1
            };

            const existingProduct = cart.find(item => item.id === product.id);
            if (existingProduct) {
                existingProduct.quantity += 1;
            } else {
                cart.push(product);
            }

            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartBadge();
            alert('Produk ditambahkan ke keranjang!');
        }

        function beliProduk(id) {
            // Redirect to checkout or order page
            window.location.href = 'template/order.php?id=' + id;
        }
    </script>
</body>
</html>
