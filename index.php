<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pixel Part - E-commerce</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet" href="public/css/banner.css">
</head>
<body>
    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top shadow-sm">
        <div class="container-fluid px-4">
            <a class="navbar-brand fw-bold d-flex align-items-center" href="index.php">
                <img src="public/image/logo.png" alt="Logo" width="35" height="35" class="me-2">
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
                        <a class="nav-link text-white fw-semibold" href="./view/login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white fw-semibold" href="./view/register.php">Register</a>
                    </li>
                    <li class="nav-item position-relative">
                        <a class="nav-link text-white fw-semibold" href="./view/cart.php">
                            <i class="fas fa-shopping-cart"></i> Keranjang
                            <span class="badge bg-danger position-absolute top-0 start-100 translate-middle">0</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->

    <!-- Banner Carousel Section Start -->
    <section class="banner-section">
        <div class="container-fluid px-4 py-4">
            <div class="row g-3">
                <!-- Main Banner Carousel (Kiri - Besar) -->
                <div class="col-lg-8">
                    <div id="mainBannerCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#mainBannerCarousel" data-bs-slide-to="0" class="active"></button>
                            <button type="button" data-bs-target="#mainBannerCarousel" data-bs-slide-to="1"></button>
                            <button type="button" data-bs-target="#mainBannerCarousel" data-bs-slide-to="2"></button>
                        </div>
                        
                        <div class="carousel-inner">
                            <!-- Slide 1 -->
                            <div class="carousel-item active">
                                <img src="public/image/banners/banner1.jpg" class="d-block w-100" alt="Promo 1">
                                <div class="carousel-caption">
                                    <h5>PRE ORDER</h5>
                                    <p>ROG XBOX ALLY X - Periode 25-31 Oktober 2025</p>
                                </div>
                            </div>
                            
                            <!-- Slide 2 -->
                            <div class="carousel-item">
                                <img src="public/image/banners/banner2.jpg" class="d-block w-100" alt="Promo 2">
                                <div class="carousel-caption">
                                    <h5>FLASH SALE</h5>
                                    <p>Diskon hingga 50% untuk produk pilihan</p>
                                </div>
                            </div>
                            
                            <!-- Slide 3 -->
                            <div class="carousel-item">
                                <img src="public/image/banners/banner3.jpg" class="d-block w-100" alt="Promo 3">
                                <div class="carousel-caption">
                                    <h5>NEW ARRIVAL</h5>
                                    <p>RTX 5090 Series - Performa Maksimal</p>
                                </div>
                            </div>
                        </div>
                        
                        <button class="carousel-control-prev" type="button" data-bs-target="#mainBannerCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#mainBannerCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    </div>
                </div>
                
                <!-- Side Banners (Kanan - Kecil) -->
                <div class="col-lg-4">
                    <div class="row g-3">
                        <!-- Small Banner 1 -->
                        <div class="col-12">
                            <div class="side-banner">
                                <img src="public/image/banners/side-banner1.jpg" class="img-fluid rounded" alt="Side Banner 1">
                                <div class="side-banner-overlay">
                                    <h6>Intel Inside</h6>
                                    <p>Reliable Performance on the go</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Small Banner 2 -->
                        <div class="col-12">
                            <div class="side-banner">
                                <img src="public/image/banners/side-banner2.jpg" class="img-fluid rounded" alt="Side Banner 2">
                                <div class="side-banner-overlay">
                                    <h6>Cicilan 0%</h6>
                                    <p>Diskon 4% hingga 2JT</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Banner Carousel Section End -->


    <!-- Products Section Start -->
    <div class="products-container" id="produk">
        <div class="container-fluid px-4">
            <h2 class="section-title">Produk Terlaris</h2>
            
            <div class="row g-4">
                <!-- Product Card 1 -->
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="product-card">
                        <div class="product-image-container">
                            <img src="public/image/product/Gigabyte AORUS GeForce RTX™ 5090 MASTER ICE 32G GV-N5090AORUSM-ICE-32GD.jpg" alt="RTX 5090">
                        </div>
                        <div class="product-info">
                            <h5 class="product-title">Gigabyte AORUS GeForce RTX™ 5090</h5>
                            <p class="product-subtitle">MASTER ICE 32G</p>
                            <div class="product-rating"><i class="fas fa-star"></i> 4.8 (128)</div>
                            <div class="stock-badge in-stock">✓ Tersedia</div>
                            <p class="product-price">Rp 14.000.000</p>
                            <div class="d-flex gap-2">
                                <button class="btn-beli flex-fill">Beli</button>
                                <button class="btn-keranjang flex-fill"><i class="fas fa-shopping-cart"></i></button>
                            </div>
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
                            <h5 class="product-title">Nama Produk Elektronik Premium</h5>
                            <p class="product-subtitle">Spesifikasi Produk</p>
                            <div class="product-rating"><i class="fas fa-star"></i> 4.5 (95)</div>
                            <div class="stock-badge low-stock">⚠ Terbatas</div>
                            <p class="product-price">Rp 8.500.000</p>
                            <div class="d-flex gap-2">
                                <button class="btn-beli flex-fill">Beli</button>
                                <button class="btn-keranjang flex-fill"><i class="fas fa-shopping-cart"></i></button>
                            </div>
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
                            <div class="d-flex gap-2">
                                <button class="btn-beli flex-fill">Beli</button>
                                <button class="btn-keranjang flex-fill"><i class="fas fa-shopping-cart"></i></button>
                            </div>
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
                            <h5 class="product-title">Aksesori Elektronik Berkualitas</h5>
                            <p class="product-subtitle">Garansi Resmi 2 Tahun</p>
                            <div class="product-rating"><i class="fas fa-star"></i> 4.7 (142)</div>
                            <div class="stock-badge in-stock">✓ Tersedia</div>
                            <p class="product-price">Rp 3.500.000</p>
                            <div class="d-flex gap-2">
                                <button class="btn-beli flex-fill">Beli</button>
                                <button class="btn-keranjang flex-fill"><i class="fas fa-shopping-cart"></i></button>
                            </div>
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
    <script src="public/js/banner.js"></script>
</body>
</html>