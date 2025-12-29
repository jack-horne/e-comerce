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

    <?php include 'C:\laragon\www\e-comerce\view\template\navbar.php'; ?>

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
    <?php include 'C:\laragon\www\e-comerce\view\template\footer.php'; ?>

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
