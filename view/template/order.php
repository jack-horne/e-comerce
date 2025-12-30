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

    <nav class="navbar navbar-expand-lg custom-navbar">
  <div class="container">

    <!-- LOGO -->
    <a class="navbar-brand logo" href="home.php">
      <img src="public/image/logo.png" alt="PixelPart" width="40" height="40"> 
      PixelPart
    </a>

    <!-- TOGGLER (Mobile) -->
    <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
      <i class="fa-solid fa-bars"></i>
    </button>

    <!-- NAV MENU -->
    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
        
        <!-- HOME -->
        <li class="nav-item">
          <a class="nav-link" href="index.php">
            <i class="fa-solid fa-house"></i> Home
          </a>
        </li>

        <!-- DROPDOWN KATEGORI -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
            <i class="fa-solid fa-box"></i> Kategori
          </a>
          <ul class="dropdown-menu dropdown-menu-dark">
            <li><a class="dropdown-item" href="produk.php?cat=gpu">VGA</a></li>
            <li><a class="dropdown-item" href="produk.php?cat=cpu">Processor</a></li>
            <li><a class="dropdown-item" href="produk.php?cat=motherboard">Motherboard</a></li>
            <li><a class="dropdown-item" href="produk.php?cat=ram">RAM</a></li>
            <li><a class="dropdown-item" href="produk.php?cat=storage">Storage</a></li>
            <li><a class="dropdown-item" href="produk.php?cat=psu">Power Supply</a></li>
            <li><a class="dropdown-item" href="produk.php?cat=cooling">Cooling</a></li>
          </ul>
        </li>

        <!-- TENTANG KAMI -->
        <li class="nav-item">
          <a class="nav-link" href="view/template/about.php">
            <i class="fa-solid fa-address-card"></i> Tentang Kami
          </a>
        </li>

        <!-- DIVIDER (Optional) -->
        <li class="nav-divider d-none d-lg-block"></li>

        <!-- SEARCH ICON -->
        <li class="nav-item">
          <a class="nav-link nav-icon" href="#" data-bs-toggle="modal" data-bs-target="#searchModal">
            <i class="fa-solid fa-search"></i>
          </a>
        </li>

        <!-- CART ICON -->
        <li class="nav-item position-relative">
          <a class="nav-link nav-icon" href="C:\laragon\www\e-comerce\view\template\chart.php">
            <i class="fa-solid fa-cart-shopping"></i>
            <span class="badge bg-danger position-absolute top-0 start-100 translate-middle">0</span>
          </a>
        </li>

        <!-- USER DROPDOWN -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
            <i class="fa-solid fa-user"></i> Akun
          </a>
          <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end">
            <li><a class="dropdown-item" href="view/login.php">
              <i class="fa-solid fa-right-to-bracket me-2"></i>Masuk
            </a></li>
            <li><a class="dropdown-item" href="view/register.php">
              <i class="fa-solid fa-user-plus me-2"></i>Daftar
            </a></li>
          </ul>
        </li>

      </ul>
    </div>
  </div>
</nav>

<!-- Search Modal -->
<div class="modal fade" id="searchModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-dark text-white">
      <div class="modal-header border-secondary">
        <h5 class="modal-title">Search Products</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form action="search.php" method="GET">
          <div class="input-group">
            <input type="text" class="form-control" name="q" placeholder="Cari produk...">
            <button class="btn btn-danger" type="submit">
              <i class="fa-solid fa-search"></i> Cari
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<style>
/* BACKGROUND + BLUR */
.custom-navbar {
    background: rgba(0, 0, 0, 0.65);
    backdrop-filter: blur(6px);
    padding: 15px 0;
    position: fixed;
    width: 100%;
    z-index: 99;
    top: 0;
}

/* LOGO */
.logo {
    font-size: 24px;
    font-weight: bold;
    color: #fff !important;
    letter-spacing: 1px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.logo img {
    filter: brightness(1.2);
}

/* NAV LINKS */
.navbar-nav .nav-link {
    color: #ccc !important;
    margin-left: 15px;
    font-size: 15px;
    transition: 0.3s;
    padding: 8px 12px;
}

.navbar-nav .nav-link:hover {
    color: #fff !important;
    text-shadow: 0 0 8px #ff4a4a;
}

/* NAV ICONS */
.nav-link.nav-icon {
    font-size: 18px;
    padding: 8px 12px;
}

/* DIVIDER */
.nav-divider {
    width: 1px;
    height: 25px;
    background: rgba(255, 255, 255, 0.2);
    margin: 0 10px;
}

/* DROPDOWN */
.dropdown-menu-dark {
    background: rgba(0, 0, 0, 0.9);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 8px;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
}

.dropdown-menu-dark .dropdown-item {
    padding: 10px 20px;
    transition: 0.2s;
}

.dropdown-menu-dark .dropdown-item:hover {
    background: #e84343;
    color: white;
    padding-left: 25px;
}

/* CART BADGE */
.navbar-nav .badge {
    font-size: 10px;
    padding: 3px 6px;
    min-width: 18px;
}

/* TOGGLER (Mobile) */
.navbar-toggler {
    border: none;
    font-size: 24px;
    color: #fff;
}

.navbar-toggler:focus {
    box-shadow: none;
}

/* SEARCH MODAL */
.modal-content.bg-dark {
    background-color: rgba(0, 0, 0, 0.95) !important;
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.modal-content .form-control {
    background-color: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: #fff;
}

.modal-content .form-control:focus {
    background-color: rgba(255, 255, 255, 0.15);
    border-color: #e84343;
    color: #fff;
    box-shadow: 0 0 0 0.25rem rgba(232, 67, 67, 0.25);
}

.modal-content .form-control::placeholder {
    color: rgba(255, 255, 255, 0.5);
}

/* RESPONSIVE */
@media (max-width: 992px) {
    .navbar-nav {
        padding: 15px 0;
    }

    .navbar-nav .nav-link {
        margin-left: 0;
        padding: 10px 15px;
    }

    .nav-divider {
        display: none !important;
    }

    .dropdown-menu-end {
        right: auto !important;
    }
}
</style>

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
        <div class="checkout-glass">
        <div class="checkout-header">
            <h4>Informasi Pembelian</h4>
            <p>Lengkapi data Anda untuk melanjutkan pembayaran</p>
        </div>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" class="checkout-form">
            <div class="form-group">
                <input type="text" name="nama" required>
                <label>Nama Lengkap</label>
            </div>

            <div class="form-group">
                <input type="email" name="email" required>
                <label>Email</label>
            </div>

            <div class="form-group">
                <input type="tel" name="telepon" required>
                <label>Nomor Telepon</label>
            </div>

            <div class="form-group">
                <textarea name="alamat" rows="3" required></textarea>
                <label>Alamat Lengkap</label>
            </div>

            <div class="form-group">
                <input type="number" id="quantity" name="quantity"
                    value="1"
                    min="1"
                    max="<?php echo $product['qyt']; ?>"
                    required>
                <label>Jumlah</label>
            </div>

            <div class="total-box">
                <span>Total Harga</span>
                <strong id="total-price">
                    Rp <?php echo number_format($product['harga'] * (1 - $product['diskon']/100), 0, ',', '.'); ?>
                </strong>
            </div>

            <button type="submit" class="btn-pay">
                <i class="fas fa-credit-card"></i>
                Bayar Sekarang
            </button>
        </form>
    </div>
</div>


    <!-- FOOTER -->
    <!-- FOOTER -->
    <footer style="background: #000; padding: 40px 50px; text-align: center; border-top: 1px solid #004c75;">
        <div style="max-width: 1200px; margin: 0 auto;">
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 30px; margin-bottom: 30px;">
                <div>
                    <h4 style="color: #00caff; margin-bottom: 15px;">Pixel Part</h4>
                    <p style="color: #ccc; font-size: 14px;">Your trusted partner for gaming hardware components.</p>
                </div>
                <div>
                    <h4 style="color: #00caff; margin-bottom: 15px;">Quick Links</h4>
                    <ul style="list-style: none; padding: 0;">
                        <li><a href="#home" style="color: #ccc; text-decoration: none; display: block; margin-bottom: 8px;">Home</a></li>
                        <li><a href="#kategori" style="color: #ccc; text-decoration: none; display: block; margin-bottom: 8px;">Categories</a></li>
                        <li><a href="#produk" style="color: #ccc; text-decoration: none; display: block; margin-bottom: 8px;">Products</a></li>
                        <li><a href="#kontak" style="color: #ccc; text-decoration: none; display: block; margin-bottom: 8px;">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h4 style="color: #00caff; margin-bottom: 15px;">Categories</h4>
                    <ul style="list-style: none; padding: 0;">
                        <li style="color: #ccc; margin-bottom: 8px;">Graphics Cards</li>
                        <li style="color: #ccc; margin-bottom: 8px;">Processors</li>
                        <li style="color: #ccc; margin-bottom: 8px;">Motherboards</li>
                        <li style="color: #ccc; margin-bottom: 8px;">Memory</li>
                    </ul>
                </div>
                <div>
                    <h4 style="color: #00caff; margin-bottom: 15px;">Follow Us</h4>
                    <div style="display: flex; gap: 15px; justify-content: center;">
                        <a href="#" style="color: #ccc; font-size: 20px;"><i class="fab fa-facebook"></i></a>
                        <a href="#" style="color: #ccc; font-size: 20px;"><i class="fab fa-twitter"></i></a>
                        <a href="#" style="color: #ccc; font-size: 20px;"><i class="fab fa-instagram"></i></a>
                        <a href="#" style="color: #ccc; font-size: 20px;"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>
            <div style="border-top: 1px solid #333; padding-top: 20px;">
                <p style="color: #666; font-size: 14px;">&copy; 2024 Pixel Part. All rights reserved.</p>
            </div>
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
        
            const quantityInput = document.getElementById('quantity');
            const totalPrice = document.getElementById('total-price');

            const price = <?php echo $product['harga'] * (1 - $product['diskon']/100); ?>;

            quantityInput.addEventListener('input', () => {
                let qty = parseInt(quantityInput.value) || 1;
                let total = price * qty;
                totalPrice.innerText = 'Rp ' + total.toLocaleString('id-ID');
            });

    </script>
</body>
</html>
