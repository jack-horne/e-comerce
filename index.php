<?php
require_once 'backend/connection.php';

// Ambil produk flash sale (diskon > 0) dengan limit 8
$flash_sale_query = "SELECT p.*, k.nm_kategori
                     FROM produk p
                     LEFT JOIN kat_produk k ON p.id_kategori = k.id_kategori
                     WHERE p.diskon > 0 AND p.kodisi = 1
                     ORDER BY p.diskon DESC, p.id_produk DESC
                     LIMIT 8";
$flash_sale_result = mysqli_query($conn, $flash_sale_query);

// Ambil semua kategori untuk section kategori
$categories_query = "SELECT * FROM kat_produk ORDER BY nm_kategori";
$categories_result = mysqli_query($conn, $categories_query);
?>

<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pixel Part</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet" href="public/css/simple-banner.css">
</head>
<body>
    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top shadow-sm">
  <div class="container-fluid px-4">

    <a class="navbar-brand fw-bold d-flex align-items-center" href="index.php">
      <img src="public/image/icons/logo.png" alt="Logo" width="35" height="35" class="me-2">
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
          <a class="nav-link text-white fw-semibold" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white fw-semibold" href="view/login.php">Login</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white fw-semibold" href="view/register.php">Register</a>
        </li>
        <li class="nav-item position-relative">
          <a class="nav-link text-white fw-semibold" href="view/template/chart.php">
            <i class="fas fa-shopping-cart"></i> Keranjang
            <span class="badge bg-danger position-absolute top-0 start-100 translate-middle" id="cart-count">0</span>
          </a>
        </li>
      </ul>

    </div>
  </div>
</nav>

    <!-- Navbar End -->


        <!-- Floating Elements -->
        <div class="hero-floating-shapes">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            <div class="shape shape-3"></div>
        </div>
    </nav>

    <!-- Promo Banner Section -->
     <br>
        <section class="promo-banner">
        <div class="container-fluid px-4">
            <div id="promoCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#promoCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#promoCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#promoCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="simple-banner-slide">
                        <div class="simple-banner-content">
                            <h2>Diskon Hingga 50%</h2>
                            <p>Untuk Semua Komponen PC Gaming Terbaru</p>
                            <a href="#produk" class="btn btn-primary btn-lg">Belanja Sekarang</a>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="simple-banner-slide">
                        <div class="simple-banner-content">
                            <h2>Garansi Resmi 2 Tahun</h2>
                            <p>Semua Produk Elektronik Berkualitas</p>
                            <a href="#produk" class="btn btn-primary btn-lg">Lihat Produk</a>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="simple-banner-slide">
                        <div class="simple-banner-content">
                            <h2>Pengiriman Gratis</h2>
                            <p>Untuk Pembelian Minimal Rp 1.000.000</p>
                            <a href="#produk" class="btn btn-primary btn-lg">Order Sekarang</a>
                        </div>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#promoCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#promoCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
            </div>
        </div>
    </section>

    <!-- Products Section Start -->
    <div class="products-container" id="produk">
        <div class="container-fluid px-4">
            <h2 class="section-title">Flash Sale</h2>

            <div class="row g-4">
                <?php if (mysqli_num_rows($flash_sale_result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($flash_sale_result)): ?>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                            <div class="product-card" data-id="<?php echo $row['id_produk']; ?>" data-name="<?php echo htmlspecialchars($row['nm_produk']); ?>" data-price="<?php echo $row['harga'] * (1 - $row['diskon']/100); ?>" data-image="public/image/product/<?php echo htmlspecialchars($row['gambar']); ?>">
                                <div class="product-image-container">
                                    <?php if (!empty($row['gambar'])): ?>
                                        <img src="public/image/product/<?php echo htmlspecialchars($row['gambar']); ?>" alt="<?php echo htmlspecialchars($row['nm_produk']); ?>">
                                    <?php else: ?>
                                        <img src="public/image/product/default.jpg" alt="No Image">
                                    <?php endif; ?>
                                </div>
                                <div class="product-info">
                                    <div class="product-discount">-<?php echo $row['diskon']; ?>%</div>
                                    <h5 class="product-title"><?php echo htmlspecialchars($row['nm_produk']); ?></h5>
                                    <p class="product-subtitle"><?php echo htmlspecialchars($row['nm_kategori']); ?></p>
                                    <div class="product-rating"><i class="fas fa-star"></i> <?php echo number_format($row['rate'] ?? 0, 1); ?> (<?php echo rand(10, 200); ?>)</div>
                                    <?php
                                    $stok = $row['qyt'];
                                    $stock_class = $stok > 10 ? 'in-stock' : ($stok > 0 ? 'low-stock' : 'out-stock');
                                    $stock_text = $stok > 10 ? '✓ Tersedia' : ($stok > 0 ? '⚠ Terbatas' : '✗ Habis');
                                    ?>
                                    <div class="stock-badge <?php echo $stock_class; ?>"><?php echo $stock_text; ?></div>
                                    <p class="product-price">
                                        <span class="text-muted text-decoration-line-through">Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></span>
                                        Rp <?php echo number_format($row['harga'] * (1 - $row['diskon']/100), 0, ',', '.'); ?>
                                    </p>
                                    <div class="d-flex gap-2">
                                        <button class="btn-beli flex-fill" onclick="beliProduk(<?php echo $row['id_produk']; ?>)"><i class="fas fa-shopping-bag"></i> Beli</button>
                                        <button class="btn-keranjang flex-fill add-to-cart" onclick="addToCart(<?php echo $row['id_produk']; ?>, '<?php echo addslashes($row['nm_produk']); ?>', <?php echo $row['harga'] * (1 - $row['diskon']/100); ?>, '<?php echo addslashes($row['gambar']); ?>')"><i class="fas fa-shopping-cart"></i> Keranjang</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="col-12 text-center py-5">
                        <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">Tidak ada produk flash sale saat ini</h4>
                        <p class="text-muted">Produk flash sale akan segera hadir.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!-- Products Section End -->

    <!-- Kategori sections-->
    <div class="products-container" id="produk">
        <div class="container-fluid px-4">
            <h2 class="section-title">Kategori Produk</h2>

        <section class="product-category container my-5">
            <div class="category-scroll-container">
                <div class="category-scroll-wrapper">
                    <?php if (mysqli_num_rows($categories_result) > 0): ?>
                        <?php
                        $category_icons = [
                            1 => 'coliing fan.jpeg',
                            2 => 'motherboard.jpeg',
                            3 => 'psu.jpeg',
                            4 => 'prosesor.jpeg',
                            5 => 'ram.jpeg',
                            6 => 'storage.jpeg',
                            7 => 'vga.jpeg'
                        ];
                        $count = 0;
                        while ($kat = mysqli_fetch_assoc($categories_result)):
                            $count++;
                            $icon = isset($category_icons[$count]) ? $category_icons[$count] : 'cpu.svg';
                        ?>
                            <div class="category-item">
                                <a href="view/category.php?id=<?php echo $kat['id_kategori']; ?>" class="text-decoration-none text-center">
                                    <img src="public/image/icons/<?php echo $icon; ?>" alt="<?php echo htmlspecialchars($kat['nm_kategori']); ?>"
                                        class="img-fluid rounded-circle shadow-sm border mb-2"
                                        style="width: 120px; height: 120px; object-fit: cover;">
                                    <p class="fw-semibold mb-0 text-dark"><?php echo htmlspecialchars($kat['nm_kategori']); ?></p>
                                </a>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="text-center">
                            <p class="text-muted">Tidak ada kategori tersedia</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>


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
                    <p class="small text-white-50">📞 +62-XXX-XXX-XXX<br>📧 support@mywebsite.com</p>
                </div>
            </div>
            <hr class="bg-secondary">
            <p class="text-center small mb-0">&copy; 2025 MyWebsite. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="public/js/banner.js"></script>
    <script>
        // Shopping cart functionality
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        updateCartBadge();

        // Add to cart event listeners
        document.querySelectorAll('.add-to-cart').forEach(button => {
            button.addEventListener('click', function() {
                const productCard = this.closest('.product-card');
                const product = {
                    id: productCard.dataset.id,
                    name: productCard.dataset.name,
                    price: parseInt(productCard.dataset.price),
                    image: productCard.dataset.image,
                    quantity: 1
                };

                // Check if product already in cart
                const existingProduct = cart.find(item => item.id === product.id);
                if (existingProduct) {
                    existingProduct.quantity += 1;
                } else {
                    cart.push(product);
                }

                localStorage.setItem('cart', JSON.stringify(cart));
                updateCartBadge();
                alert('Produk ditambahkan ke keranjang!');
            });
        });

        function updateCartBadge() {
            const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
            const badge = document.getElementById('cart-count');
            if (badge) {
                badge.textContent = totalItems;
            }
        }

        // Function to add to cart
        function addToCart(id, name, price, image) {
            const product = {
                id: id,
                name: name,
                price: price,
                image: image,
                quantity: 1
            };

            // Check if product already in cart
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

        // Function to buy product
        function beliProduk(id) {
            // Redirect to product detail or checkout
            window.location.href = 'view/product_detail.php?id=' + id;
        }
    </script>
    
</body>
</html>