<?php
require_once '../../backend/connection.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: ../../index.php');
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
    header('Location: ../../index.php');
    exit;
}

$product = mysqli_fetch_assoc($result);

// Proses form jika disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Simpan order ke database (contoh sederhana)
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $telepon = mysqli_real_escape_string($conn, $_POST['telepon']);
    $quantity = (int)$_POST['quantity'];
    $total_harga = $quantity * ($product['harga'] * (1 - $product['diskon']/100));

    $order_query = "INSERT INTO orders (id_produk, nama_pembeli, email, alamat, telepon, quantity, total_harga, tanggal_order)
                    VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
    $stmt_order = mysqli_prepare($conn, $order_query);
    mysqli_stmt_bind_param($stmt_order, "issssii", $product_id, $nama, $email, $alamat, $telepon, $quantity, $total_harga);

    if (mysqli_stmt_execute($stmt_order)) {
        $order_id = mysqli_insert_id($conn);
        header('Location: ../../index.php?order_success=1&order_id=' . $order_id);
        exit;
    } else {
        $error = "Gagal memproses pesanan. Silakan coba lagi.";
    }
}
?>

<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checkout - <?php echo htmlspecialchars($product['nm_produk']); ?> - Pixel Part</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../public/css/style.css">
</head>
<body>
    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top shadow-sm">
        <div class="container-fluid px-4">
            <a class="navbar-brand fw-bold d-flex align-items-center" href="../../index.php">
                <img src="../../public/image/icons/logo.png" alt="Logo" width="35" height="35" class="me-2">
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
                        <a class="nav-link text-white fw-semibold" href="../../index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white fw-semibold" href="../login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white fw-semibold" href="../register.php">Register</a>
                    </li>
                    <li class="nav-item position-relative">
                        <a class="nav-link text-white fw-semibold" href="chart.php">
                            <i class="fas fa-shopping-cart"></i> Keranjang
                            <span class="badge bg-danger position-absolute top-0 start-100 translate-middle" id="cart-count">0</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Checkout Section -->
    <div class="container-fluid px-4 py-5">
        <div class="row g-4">
            <!-- Product Summary -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Ringkasan Produk</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex">
                            <img src="../../public/image/product/<?php echo htmlspecialchars($product['gambar']); ?>"
                                 alt="<?php echo htmlspecialchars($product['nm_produk']); ?>"
                                 class="img-fluid me-3" style="width: 100px; height: 100px; object-fit: contain;">
                            <div>
                                <h6><?php echo htmlspecialchars($product['nm_produk']); ?></h6>
                                <p class="text-muted"><?php echo htmlspecialchars($product['nm_kategori']); ?></p>
                                <div class="product-price">
                                    <?php if ($product['diskon'] > 0): ?>
                                        <span class="text-muted text-decoration-line-through">
                                            Rp <?php echo number_format($product['harga'], 0, ',', '.'); ?>
                                        </span>
                                        <span class="text-primary fw-bold">
                                            Rp <?php echo number_format($product['harga'] * (1 - $product['diskon']/100), 0, ',', '.'); ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-primary fw-bold">
                                            Rp <?php echo number_format($product['harga'], 0, ',', '.'); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Checkout Form -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Informasi Pembelian</h5>
                    </div>
                    <div class="card-body">
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>

                        <form method="POST">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="nama" name="nama" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="telepon" class="form-label">Nomor Telepon</label>
                                <input type="tel" class="form-control" id="telepon" name="telepon" required>
                            </div>
                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat Lengkap</label>
                                <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Jumlah</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1" max="<?php echo $product['qyt']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Total Harga</label>
                                <div class="h5 text-primary" id="total-price">
                                    Rp <?php echo number_format($product['harga'] * (1 - $product['diskon']/100), 0, ',', '.'); ?>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg w-100">
                                <i class="fas fa-credit-card me-2"></i>Bayar Sekarang
                            </button>
                        </form>
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
        // Update total price when quantity changes
        document.getElementById('quantity').addEventListener('input', function() {
            const quantity = parseInt(this.value) || 1;
            const price = <?php echo $product['harga'] * (1 - $product['diskon']/100); ?>;
            const total = quantity * price;
            document.getElementById('total-price').textContent = 'Rp ' + total.toLocaleString('id-ID');
        });

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
    </script>
</body>
</html>
