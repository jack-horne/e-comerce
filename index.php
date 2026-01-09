<?php
// 1. Kunci akses
define('APP_INIT', true);

// 2. Panggil init (yang isinya memanggil base.php dan connection.php)
require_once 'config/init.php'; 

// 3. Baru panggil navbar
include 'view/template/navbar.php'; 

// Query untuk mengambil data kategori
$query_kategori = "SELECT id_kategori, nm_kategori FROM kat_produk ORDER BY id_kategori";
$result_kategori = mysqli_query($conn, $query_kategori);

// Query untuk mengambil featured products 
$query_featured = "SELECT p.*, k.nm_kategori
                   FROM produk p
                   LEFT JOIN kat_produk k ON p.id_kategori = k.id_kategori
                   WHERE p.kodisi = 1
                   ORDER BY p.id_produk DESC
                   LIMIT 3";
$result_featured = mysqli_query($conn, $query_featured);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pixel Part - Gaming Hardware Store</title>

    <!-- CSS -->
    <link rel="stylesheet" href="public/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

    <?php include 'view/template/navbar.php'; ?>
    
    <!-- HERO SECTION -->
    <section class="hero" id="home">
        <div class="hero-content">
            <h1>Asus ROG <br> MAXIMUS IX</h1>
            <p>Motherboard terbaik untuk extreme gaming.</p>
            <button class="btn">Beli Sekarang • $499</button>
        </div>
        <div class="hero-overlay"></div>
    </section>

    <!-- CATEGORY SECTION -->
    <section class="category-section" id="kategori">
        <?php if (mysqli_num_rows($result_kategori) > 0): ?>
            <?php while ($kategori = mysqli_fetch_assoc($result_kategori)): ?>
                <a href="view/category.php?id=<?php echo $kategori['id_kategori']; ?>" class="category-card">
                    <?php
                    $image_name = strtolower(str_replace(' ', '-', $kategori['nm_kategori']));
                    if ($kategori['nm_kategori'] == 'Cooling') {
                        $image_name = 'cooling-fan';
                    }
                    ?>
                    <img src="public/image/icons/<?php echo $image_name; ?>.jpeg" alt="<?php echo htmlspecialchars($kategori['nm_kategori']); ?>">
                    <span><?php echo htmlspecialchars($kategori['nm_kategori']); ?></span>
                </a>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Tidak ada kategori tersedia.</p>
        <?php endif; ?>
    </section>

    <!-- BUILD PC -->
    <section class="build">
        <h2>Build Your <span>New PC</span></h2>
        <p>Rakit PC kamu sendiri dengan komponen terbaik pilihan kami.</p>
        <button class="btn" onclick="window.location.href='view/pc_builder.php'">Build Sekarang</button>
    </section>

    <!-- PRODUCTS SECTION -->
    <section class="products-section" id="produk">
        <h2 class="section-title">Featured Products</h2>
        
        <div class="products-grid">
            <?php if (mysqli_num_rows($result_featured) > 0): ?>
                <?php while ($produk = mysqli_fetch_assoc($result_featured)): ?>
                    <div class="product-card">
                        <div class="product-image">
                            <?php if (!empty($produk['gambar'])): ?>
                                <img src="public/image/product/<?php echo htmlspecialchars($produk['gambar']); ?>" alt="<?php echo htmlspecialchars($produk['nm_produk']); ?>">
                            <?php else: ?>
                                <img src="public/image/product/default.jpg" alt="No Image">
                            <?php endif; ?>
                        </div>
                        <h3><?php echo htmlspecialchars($produk['nm_produk']); ?></h3>
                        <p><?php echo htmlspecialchars($produk['nm_kategori']); ?></p>
                        <div class="product-price">Rp <?php echo number_format($produk['harga'], 0, ',', '.'); ?></div>
                        <button class="btn" onclick="window.location.href='view/product_detail.php?id=<?php echo $produk['id_produk']; ?>'">View Details</button>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Tidak ada produk tersedia.</p>
            <?php endif; ?>
        </div>
    </section>

    <!-- ABOUT SECTION -->
    <section class="about" id="tentang">
        <div class="subtitle"></div>
        <h1>Pixel Part - Your Gaming Hardware Partner</h1>
        
        <div class="description">
            Kami menyediakan komponen PC gaming berkualitas tinggi dengan harga terbaik.
            Dari motherboard hingga graphics card, semua kebutuhan gaming Anda ada di sini.
        </div>

        <div class="bottom-text">
            Dengan pengalaman bertahun-tahun dalam industri komponen PC,
            kami berkomitmen untuk memberikan produk terbaik dengan layanan pelanggan yang prima.
        </div>

        <button class="btn">Learn More About Us</button>
    </section>

    <!-- CONTACT SECTION -->
    <section class="contact-section" id="kontak">
        <h2>Contact <span>Us</span></h2>
        <p>Hubungi kami untuk konsultasi PC gaming atau pertanyaan lainnya</p>
        
        <div class="contact-grid">
            <div class="contact-item">
                <i class="fas fa-phone"></i>
                <p>+62 812-3456-7890</p>
            </div>
            <div class="contact-item">
                <i class="fas fa-envelope"></i>
                <p>info@pixelpart.com</p>
            </div>
            <div class="contact-item">
                <i class="fas fa-map-marker-alt"></i>
                <p>Jakarta, Indonesia</p>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <?php include 'view/template/footer.php'; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="public/js/banner.js"></script>
</body>
</html>
