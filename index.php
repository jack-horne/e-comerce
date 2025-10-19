<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MyWebsite - E-commerce</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
        <div class="container-fluid px-4">
            <!-- Logo & Brand (Kiri) -->
            <a class="navbar-brand fw-bold d-flex align-items-center" href="index.php">
                <img src="public/image/logo.png" alt="Logo" width="35" height="35" class="me-2">
                MyWebsite
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Search Bar (Tengah) -->
            <form class="navbar-search" role="search">
                <div class="input-group">
                    <input class="form-control" type="search" placeholder="Search..." aria-label="Search">
                    <button class="btn btn-outline-light" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </form>

            <!-- Menu (Kanan) -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item d-none d-lg-block">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item d-none d-lg-block">
                        <a class="nav-link" href="./view/login.php">Login</a>
                    </li>
                    <li class="nav-item d-none d-lg-block">
                        <a class="nav-link" href="./view/register.php">Register</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link position-relative" href="./view/chart.php">
                            <i class="fas fa-shopping-cart"></i> Keranjang
                            <span class="badge bg-danger position-absolute top-0 start-100 translate-middle">0</span>
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
    </section>
    <!-- Hero Section End -->

    <!-- Promo Banner Start -->
    <div class="promo-banner">
        <div class="container-fluid px-4">
            <div class="row align-items-center g-4">
                <div class="col-lg-6">
                    <h2 class="banner-title">Malas belanja ke mal?</h2>
                    <p class="banner-subtitle">Coba Official Store, jaminan pasti ori!</p>
                    <a href="#" class="btn btn-promo">Cek Sekarang</a>
                </div>
                <div class="col-lg-6 text-center d-none d-lg-block">
                    <img src="public/image/banner-illustration.png" alt="Banner Illustration" class="banner-illustration" style="max-width: 400px; width: 100%; height: auto;">
                </div>
            </div>
        </div>
    </div>
    <!-- Promo Banner End -->

    <!-- Products Section Start -->
    <div class="products-container" id="produk">
        <div class="container-fluid px-4">
            <h2 class="section-title">Produk Terlaris</h2>

            <div class="row g-4">
                <!-- Product Card 1 -->
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="product-card">
                        <div class="product-image-container">
                            <img src="public/image/Gigabyte AORUS GeForce RTX™ 5090 MASTER ICE 32G GV-N5090AORUSM-ICE-32GD.jpg" alt="RTX 5090">
                        </div>
                        <div class="product-info">
                            <div class="product-discount">-15%</div>
                            <h5 class="product-title">Gigabyte AORUS GeForce RTX™ 5090</h5>
                            <p class="product-subtitle">MASTER ICE 32G</p>
                            <div class="product-rating"><i class="fas fa-star"></i> 4.8 (128)</div>
                            <div class="stock-badge in-stock">✓ Tersedia</div>
                            <p class="product-price">Rp 14.000.000</p>
                            <button class="btn-beli">Beli</button>
                        </div>
                    </div>
                </div>

                <!-- Product Card 2 -->
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="product-card">
                        <div class="product-image-container">
                            <img src="public/image/produk2.jpg" alt="Produk">
                        </div>
                        <div class="product-info">
                            <div class="product-discount">-20%</div>
                            <h5 class="product-title">Nama Produk Elektronik Premium</h5>
                            <p class="product-subtitle">Spesifikasi Produk</p>
                            <div class="product-rating"><i class="fas fa-star"></i> 4.5 (95)</div>
                            <div class="stock-badge low-stock">⚠ Terbatas</div>
                            <p class="product-price">Rp 8.500.000</p>
                            <button class="btn-beli">Beli</button>
                        </div>
                    </div>
                </div>

                <!-- Product Card 3 -->
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="product-card">
                        <div class="product-image-container">
                            <img src="public/image/produk3.jpg" alt="Produk">
                        </div>
                        <div class="product-info">
                            <h5 class="product-title">Produk Terbaru Elektronik</h5>
                            <p class="product-subtitle">Deskripsi Singkat</p>
                            <div class="product-rating"><i class="fas fa-star"></i> 5.0 (256)</div>
                            <div class="stock-badge in-stock">✓ Tersedia</div>
                            <p class="product-price">Rp 5.000.000</p>
                            <button class="btn-beli">Beli</button>
                        </div>
                    </div>
                </div>

                <!-- Product Card 4 -->
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="product-card">
                        <div class="product-image-container">
                            <img src="public/image/produk4.jpg" alt="Produk">
                        </div>
                        <div class="product-info">
                            <div class="product-discount">-10%</div>
                            <h5 class="product-title">Aksesori Elektronik Berkualitas</h5>
                            <p class="product-subtitle">Garansi Resmi 2 Tahun</p>
                            <div class="product-rating"><i class="fas fa-star"></i> 4.7 (142)</div>
                            <div class="stock-badge in-stock">✓ Tersedia</div>
                            <p class="product-price">Rp 3.500.000</p>
                            <button class="btn-beli">Beli</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Products Section End -->

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
</body>
</html>