<?php
session_start();
require_once '../backend/connection.php';

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== TRUE) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['id_user'];

// Handle remove from wishlist
if (isset($_POST['remove_wishlist']) && isset($_POST['product_id'])) {
    $product_id = (int)$_POST['product_id'];

    $delete_query = "DELETE FROM wishlist WHERE user_id = ? AND product_id = ?";
    $stmt = mysqli_prepare($conn, $delete_query);
    mysqli_stmt_bind_param($stmt, "ii", $user_id, $product_id);
    mysqli_stmt_execute($stmt);

    header('Location: wishlist.php');
    exit;
}

// Fetch wishlist items
$wishlist_query = "SELECT w.*, p.nm_produk, p.harga, p.diskon, p.gambar, p.qyt, k.nm_kategori
                   FROM wishlist w
                   JOIN produk p ON w.product_id = p.id_produk
                   LEFT JOIN kat_produk k ON p.id_kategori = k.id_kategori
                   WHERE w.user_id = ? AND p.kodisi = 1
                   ORDER BY w.added_at DESC";

$stmt = mysqli_prepare($conn, $wishlist_query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$wishlist_result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishlist - Pixel Part</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body>
    <!-- Navbar -->
    <?php include 'navbar.php'; ?>

    <div class="container-fluid px-4 py-5">
        <div class="row">
            <div class="col-12">
                <h1 class="mb-4">
                    <i class="fas fa-heart text-danger me-2"></i>
                    Wishlist Saya
                </h1>

                <?php if (mysqli_num_rows($wishlist_result) > 0): ?>
                    <div class="row g-4">
                        <?php while ($item = mysqli_fetch_assoc($wishlist_result)): ?>
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                <div class="product-card">
                                    <div class="product-image-container">
                                        <?php if (!empty($item['gambar'])): ?>
                                            <img src="../public/image/product/<?php echo htmlspecialchars($item['gambar']); ?>"
                                                 alt="<?php echo htmlspecialchars($item['nm_produk']); ?>">
                                        <?php else: ?>
                                            <img src="../public/image/product/default.jpg" alt="No Image">
                                        <?php endif; ?>
                                    </div>
                                    <div class="product-info">
                                        <h5 class="product-title"><?php echo htmlspecialchars($item['nm_produk']); ?></h5>
                                        <p class="product-subtitle"><?php echo htmlspecialchars($item['nm_kategori']); ?></p>

                                        <?php
                                        $stok = $item['qyt'];
                                        $stock_class = $stok > 10 ? 'in-stock' : ($stok > 0 ? 'low-stock' : 'out-stock');
                                        $stock_text = $stok > 10 ? '✓ Tersedia' : ($stok > 0 ? '⚠ Terbatas' : '✗ Habis');
                                        ?>
                                        <div class="stock-badge <?php echo $stock_class; ?>"><?php echo $stock_text; ?></div>

                                        <p class="product-price">
                                            <?php if ($item['diskon'] > 0): ?>
                                                <span class="text-muted text-decoration-line-through">
                                                    Rp <?php echo number_format($item['harga'], 0, ',', '.'); ?>
                                                </span>
                                                <br>
                                                <span class="text-primary fw-bold">
                                                    Rp <?php echo number_format($item['harga'] * (1 - $item['diskon']/100), 0, ',', '.'); ?>
                                                </span>
                                            <?php else: ?>
                                                <span class="text-primary fw-bold">
                                                    Rp <?php echo number_format($item['harga'], 0, ',', '.'); ?>
                                                </span>
                                            <?php endif; ?>
                                        </p>

                                        <div class="d-flex gap-2">
                                            <button class="btn-beli flex-fill" onclick="beliProduk(<?php echo $item['product_id']; ?>)">
                                                <i class="fas fa-shopping-bag"></i> Beli
                                            </button>
                                            <button class="btn-keranjang flex-fill" onclick="addToCart(<?php echo $item['product_id']; ?>, '<?php echo addslashes($item['nm_produk']); ?>', <?php echo $item['harga'] * (1 - $item['diskon']/100); ?>, '<?php echo addslashes($item['gambar']); ?>')">
                                                <i class="fas fa-shopping-cart"></i> Keranjang
                                            </button>
                                        </div>

                                        <form method="POST" class="mt-2">
                                            <input type="hidden" name="product_id" value="<?php echo $item['product_id']; ?>">
                                            <button type="submit" name="remove_wishlist" class="btn btn-outline-danger btn-sm w-100">
                                                <i class="fas fa-trash"></i> Hapus dari Wishlist
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="fas fa-heart fa-4x text-muted mb-3"></i>
                        <h4 class="text-muted">Wishlist Kosong</h4>
                        <p class="text-muted">Belum ada produk favorit Anda. Mulai tambahkan produk ke wishlist!</p>
                        <a href="../index.php" class="btn btn-primary">Jelajahi Produk</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include 'footer.php'; ?>

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
            window.location.href = 'product_detail.php?id=' + id;
        }
    </script>
</body>
</html>
