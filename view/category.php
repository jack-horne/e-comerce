<?php
require_once '../config/init.php';

$id_kategori = isset($_GET['id']) ? (int)$_GET['id'] : 0;

/** @var mysqli $conn */

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
    
    <style>
        /* Memastikan gambar seragam di halaman kategori */
        .img-wrapper {
            width: 100% !important;
            height: 220px !important; /* Sedikit lebih pendek untuk grid kategori */
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            background-color: #fff !important;
            border-radius: 12px !important;
            overflow: hidden !important;
            padding: 15px !important;
            border: 1px solid rgba(0,0,0,0.1) !important;
            margin-bottom: 15px !important;
        }

        .img-wrapper img {
            max-width: 100% !important;
            max-height: 100% !important;
            width: auto !important;
            height: auto !important;
            object-fit: contain !important;
        }

        .product-card {
            background: #fff;
            border-radius: 15px;
            padding: 15px;
            height: 100%;
            transition: all 0.3s ease;
            position: relative;
        }
        
        /* Tambahkan style untuk badge diskon agar tidak menabrak wrapper */
        .product-discount-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #ff4a4a;
            color: white;
            padding: 5px 10px;
            border-radius: 8px;
            font-weight: bold;
            z-index: 10;
        }
    </style>
</head>
<body>

    <div class="container-fluid px-4 py-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="../index.php" class="btn btn-outline-light">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Beranda
            </a>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="../index.php" class="text-info text-decoration-none">Home</a></li>
                    <li class="breadcrumb-item active text-white"><?php echo htmlspecialchars($nama_kategori); ?></li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container-fluid px-4 mb-5">
        <h2 class="section-title text-start mb-4 text-white"><?php echo htmlspecialchars($nama_kategori); ?></h2>

        <div class="row g-4">
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="product-card shadow-sm">
                            <?php if ($row['diskon'] > 0): ?>
                                <div class="product-discount-badge">-<?php echo $row['diskon']; ?>%</div>
                            <?php endif; ?>

                            <div class="img-wrapper">
                                <?php $gambar = !empty($row['gambar']) ? $row['gambar'] : 'default.jpg'; ?>
                                <img src="../public/image/product/<?php echo htmlspecialchars($gambar); ?>" alt="<?php echo htmlspecialchars($row['nm_produk']); ?>">
                            </div>

                            <div class="product-info text-center">
                                <h5 class="product-title fw-bold text-dark"><?php echo htmlspecialchars($row['nm_produk']); ?></h5>
                                <p class="text-muted small mb-1"><?php echo htmlspecialchars($row['nm_kategori']); ?></p>
                                
                                <div class="mb-2">
                                    <span class="text-warning small"><i class="fas fa-star"></i> 5.0</span>
                                </div>

                                <?php
                                    $stok = $row['qyt'];
                                    $stock_text = $stok > 0 ? '✓ Tersedia' : '✗ Habis';
                                    $stock_color = $stok > 0 ? 'text-success' : 'text-danger';
                                ?>
                                <div class="mb-2 small <?php echo $stock_color; ?> fw-bold"><?php echo $stock_text; ?></div>

                                <div class="price-container mb-3">
                                    <?php if ($row['diskon'] > 0): ?>
                                        <div class="text-muted text-decoration-line-through small">Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></div>
                                        <div class="text-primary fw-bold fs-5">Rp <?php echo number_format($row['harga'] * (1 - $row['diskon']/100), 0, ',', '.'); ?></div>
                                    <?php else: ?>
                                        <div class="text-primary fw-bold fs-5">Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></div>
                                    <?php endif; ?>
                                </div>

                                <div class="d-grid gap-2">
                                    <button class="btn btn-primary btn-sm" onclick="beliProduk(<?php echo $row['id_produk']; ?>)">Beli Sekarang</button>
                                    <button class="btn btn-outline-primary btn-sm" onclick="addToCart(<?php echo $row['id_produk']; ?>, '<?php echo addslashes($row['nm_produk']); ?>', <?php echo $row['harga']; ?>, '<?php echo addslashes($gambar); ?>')">
                                        <i class="fas fa-shopping-cart me-1"></i> + Keranjang
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
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menambahkan ke keranjang');
            });
        }

        function beliProduk(id) { window.location.href = `product_detail.php?id=${id}`; }
    </script>
</body>
</html>