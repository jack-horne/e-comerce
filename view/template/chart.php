<?php
// 1. Definisikan Kunci Akses (Paling Atas!)
if (!defined('APP_INIT')) {
    define('APP_INIT', true);
}

// 2. Panggil init.php (Naik 2 tingkat: keluar dari template, keluar dari view)
$init_path = __DIR__ . '/../../config/init.php';
if (file_exists($init_path)) {
    require_once $init_path;
} else {
    die("Error: File init.php tidak ditemukan di: " . $init_path);
}

/** @var mysqli $conn */ // Memberi tahu editor bahwa $conn adalah koneksi database

// 3. Cek Login
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== TRUE) {
    // Arahkan ke login (sesuaikan folder auth kamu)
    header('Location: ' . BASE_URL . 'view/login.php'); 
    exit;
}

$user_id = $_SESSION['id_user'];

// 4. Ambil data keranjang
$query = "SELECT dk.id_det_keranjang, p.nm_produk, p.gambar, dk.qty, dk.harga, p.diskon, p.qyt as stock
          FROM det_keranjang dk
          JOIN keranjang k ON dk.id_keranjang = k.id_keranjang
          JOIN produk p ON dk.id_produk = p.id_produk
          WHERE k.id_user = ? AND p.kodisi = 1
          ORDER BY dk.id_det_keranjang DESC";

$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$cart_items = [];
$total = 0;
$item_count = 0;

while ($row = mysqli_fetch_assoc($result)) {
    $price = $row['harga'] * (1 - $row['diskon']/100);
    $subtotal = $price * $row['qty'];
    $total += $subtotal;
    $item_count += $row['qty'];

    $cart_items[] = [
        'id' => $row['id_det_keranjang'],
        'name' => $row['nm_produk'],
        'image' => $row['gambar'],
        'quantity' => $row['qty'],
        'price' => $price,
        'subtotal' => $subtotal,
        'stock' => $row['stock']
    ];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - Pixel Part</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../public/css/style.css">
</head>
<body>

    <?php include 'navbar.php'; ?>

    <div class="container-fluid px-4 py-5">
        <h1 class="mb-4">Keranjang Belanja</h1>

        <?php if (empty($cart_items)): ?>
            <div class="text-center py-5">
                <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                <h3>Keranjang Kosong</h3>
                <p class="text-muted">Belum ada produk di keranjang Anda</p>
                <a href="../../index.php" class="btn btn-primary">Mulai Belanja</a>
            </div>
        <?php else: ?>
            <div class="row">
                <div class="col-lg-8">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Produk di Keranjang (<?php echo $item_count; ?> item)</h5>
                        </div>
                        <div class="card-body">
                            <?php foreach ($cart_items as $item): ?>
                                <div class="row mb-3 align-items-center border-bottom pb-3">
                                    <div class="col-md-2">
                                        <img src="../../public/image/product/<?php echo htmlspecialchars($item['image'] ?: 'default.jpg'); ?>"
                                             class="img-fluid rounded" alt="produk">
                                    </div>
                                    <div class="col-md-4">
                                        <h6 class="mb-1"><?php echo htmlspecialchars($item['name']); ?></h6>
                                        <small class="text-muted">Stok: <?php echo $item['stock']; ?></small>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="input-group input-group-sm">
                                            <button class="btn btn-outline-secondary" onclick="updateQuantity(<?php echo $item['id']; ?>, <?php echo $item['quantity'] - 1; ?>)">-</button>
                                            <input type="number" class="form-control text-center" value="<?php echo $item['quantity']; ?>" readonly>
                                            <button class="btn btn-outline-secondary" onclick="updateQuantity(<?php echo $item['id']; ?>, <?php echo $item['quantity'] + 1; ?>)">+</button>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <span class="fw-bold text-primary">Rp <?php echo number_format($item['subtotal'], 0, ',', '.'); ?></span>
                                        <button class="btn btn-sm btn-link text-danger ms-2" onclick="removeItem(<?php echo $item['id']; ?>)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Ringkasan Pesanan</h5>
                            <div class="d-flex justify-content-between mb-3">
                                <span>Total Harga</span>
                                <span class="fw-bold text-primary">Rp <?php echo number_format($total, 0, ',', '.'); ?></span>
                            </div>
                            <button onclick="window.location.href='checkout.php'" class="btn btn-success w-100 mb-2">Checkout</button>
                            <a href="../../index.php" class="btn btn-outline-primary w-100">Kembali Belanja</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Fungsi JS tetap sama seperti kode kamu
        function updateQuantity(id, qty) {
            if(qty < 1) return;
            // ... AJAX Fetch kamu ...
            location.reload(); 
        }
        function removeItem(id) {
            if(confirm('Hapus item?')) {
                // ... AJAX Fetch kamu ...
                location.reload();
            }
        }
    </script>
</body>
</html>