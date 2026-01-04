<?php
session_start();
require_once '../../config/init.php';

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== TRUE) {
    header('Location: ../login.php');
    exit;
}

$user_id = $_SESSION['id_user'];

// Get cart items
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
                <!-- Cart Items -->
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Produk di Keranjang (<?php echo $item_count; ?> item)</h5>
                        </div>
                        <div class="card-body">
                            <?php foreach ($cart_items as $item): ?>
                                <div class="row mb-3 align-items-center">
                                    <div class="col-md-2">
                                        <img src="../../public/image/product/<?php echo htmlspecialchars($item['image'] ?: 'default.jpg'); ?>"
                                             alt="<?php echo htmlspecialchars($item['name']); ?>"
                                             class="img-fluid rounded">
                                    </div>
                                    <div class="col-md-4">
                                        <h6><?php echo htmlspecialchars($item['name']); ?></h6>
                                        <small class="text-muted">Stok: <?php echo $item['stock']; ?></small>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="input-group input-group-sm">
                                            <button class="btn btn-outline-secondary" onclick="updateQuantity(<?php echo $item['id']; ?>, <?php echo $item['quantity'] - 1; ?>)">-</button>
                                            <input type="number" class="form-control text-center" value="<?php echo $item['quantity']; ?>" min="1" max="<?php echo $item['stock']; ?>" onchange="updateQuantity(<?php echo $item['id']; ?>, this.value)">
                                            <button class="btn btn-outline-secondary" onclick="updateQuantity(<?php echo $item['id']; ?>, <?php echo $item['quantity'] + 1; ?>)">+</button>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <span class="fw-bold">Rp <?php echo number_format($item['price'], 0, ',', '.'); ?></span>
                                    </div>
                                    <div class="col-md-2 text-end">
                                        <span class="fw-bold text-primary">Rp <?php echo number_format($item['subtotal'], 0, ',', '.'); ?></span>
                                        <button class="btn btn-sm btn-outline-danger ms-2" onclick="removeItem(<?php echo $item['id']; ?>)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Ringkasan Pesanan</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Total Item:</span>
                                <span><?php echo $item_count; ?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="fw-bold">Total Harga:</span>
                                <span class="fw-bold text-primary">Rp <?php echo number_format($total, 0, ',', '.'); ?></span>
                            </div>
                            <button class="btn btn-success w-100 mb-2" onclick="checkout()">
                                <i class="fas fa-credit-card me-2"></i>Checkout
                            </button>
                            <a href="../../index.php" class="btn btn-outline-primary w-100">
                                <i class="fas fa-shopping-bag me-2"></i>Lanjut Belanja
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function updateQuantity(cartDetailId, newQuantity) {
            if (newQuantity < 1) return;

            fetch('../../backend/update_cart_quantity.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'cart_detail_id=' + cartDetailId + '&quantity=' + newQuantity
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat mengupdate jumlah');
            });
        }

        function removeItem(cartDetailId) {
            if (!confirm('Apakah Anda yakin ingin menghapus item ini dari keranjang?')) return;

            fetch('../../backend/remove_from_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'cart_detail_id=' + cartDetailId
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menghapus item');
            });
        }

        function checkout() {
            window.location.href = 'checkout.php';
        }
    </script>
</body>
</html>
