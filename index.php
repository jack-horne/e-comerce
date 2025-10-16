<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MyWebsite - E-commerce</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center me-auto" href="index.php">
                <img src="public/image/logo.png" alt="Logo" width="40" height="40" class="me-2">
                MyWebsite
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <form class="d-flex me-3" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search..." aria-label="Search">
                    <button class="btn btn-outline-light" type="submit">Search</button>
                </form>

                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./view/login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./view/register.php">Register</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./view/chart.php">🛒 Keranjang</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->

    <!-- Products Section Start -->
    <div class="products-container">
        <div class="container">
            <h2 class="section-title">Produk Terlaris</h2>

            <div class="row g-4">
                <!-- Product Card 1 -->
                <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                    <div class="product-card">
                        <div class="product-image-container">
                            <img src="public/image/Gigabyte AORUS GeForce RTX™ 5090 MASTER ICE 32G GV-N5090AORUSM-ICE-32GD.jpg" alt="RTX 5090">
                        </div>
                        <div class="product-info">
                            <div class="product-discount">-15%</div>
                            <h5 class="product-title">Gigabyte AORUS GeForce RTX™ 5090</h5>
                            <p class="product-subtitle">MASTER ICE 32G</p>
                            <div class="product-rating">⭐⭐⭐⭐⭐ (128 reviews)</div>
                            <div class="stock-badge in-stock">✓ Stok Tersedia</div>
                            <p class="product-price">Rp 14.000.000</p>
                            <button class="btn-beli">Beli Sekarang</button>
                        </div>
                    </div>
                </div>

                <!-- Product Card 2 -->
                <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                    <div class="product-card">
                        <div class="product-image-container">
                            <img src="public/image/INTEL PROCESSOR CORE I5 13400F - LGA1700.jpg" alt="Produk">
                        </div>
                        <div class="product-info">
                            <div class="product-discount">-20%</div>
                            <h5 class="product-title">INTEL PROCESSOR CORE I5 13400F - LGA1700</h5>
                            <p class="product-subtitle">Spesifikasi Produk</p>
                            <div class="product-rating">⭐⭐⭐⭐ (95 reviews)</div>
                            <div class="stock-badge low-stock">⚠ Stok Terbatas</div>
                            <p class="product-price">Rp 920.000</p>
                            <button class="btn-beli">Beli Sekarang</button>
                        </div>
                    </div>
                </div>

                <!-- Product Card 3 -->
                <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                    <div class="product-card">
                        <div class="product-image-container">
                            <img src="public/image/MOTHERBOARD GIGABYTE B450M .jpeg" alt="Produk">
                        </div>
                        <div class="product-info">
                            <h5 class="product-title">MOTHERBOARD GIGABYTE B450M / B450 AM4 DDR4 SUPPORT PROCESSOR AMD RYZEN 3 RYZEN 5 RYZEN 7 RYZEN 9</h5>
                            <p class="product-subtitle">Deskripsi Singkat</p>
                            <div class="product-rating">⭐⭐⭐⭐⭐ (256 reviews)</div>
                            <div class="stock-badge in-stock">✓ Stok Tersedia</div>
                            <p class="product-price">Rp 5.000.000</p>
                            <button class="btn-beli">Beli Sekarang</button>
                        </div>
                    </div>
                </div>

                <!-- Product Card 4 -->
                <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                    <div class="product-card">
                        <div class="product-image-container">
                            <img src="public/image/produk4.jpg" alt="Produk">
                        </div>
                        <div class="product-info">
                            <div class="product-discount">-10%</div>
                            <h5 class="product-title">Aksesori Elektronik Berkualitas</h5>
                            <p class="product-subtitle">Garansi Resmi 2 Tahun</p>
                            <div class="product-rating">⭐⭐⭐⭐ (142 reviews)</div>
                            <div class="stock-badge in-stock">✓ Stok Tersedia</div>
                            <p class="product-price">Rp 3.500.000</p>
                            <button class="btn-beli">Beli Sekarang</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Products Section End -->

    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <h6 class="fw-bold">Tentang Kami</h6>
                    <p class="small">MyWebsite adalah platform e-commerce terpercaya untuk elektronik berkualitas.</p>
                </div>
                <div class="col-md-4 mb-3">
                    <h6 class="fw-bold">Layanan</h6>
                    <ul class="list-unstyled small">
                        <li><a href="#" class="text-white-50 text-decoration-none">Pengiriman Gratis</a></li>
                        <li><a href="#" class="text-white-50 text-decoration-none">Garansi Resmi</a></li>
                        <li><a href="#" class="text-white-50 text-decoration-none">Cicilan 0%</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-3">
                    <h6 class="fw-bold">Hubungi Kami</h6>
                    <p class="small">📞 +62-XXX-XXX-XXX<br>📧 support@mywebsite.com</p>
                </div>
            </div>
            <hr class="bg-secondary">
            <p class="text-center small mb-0">&copy; 2025 MyWebsite. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>