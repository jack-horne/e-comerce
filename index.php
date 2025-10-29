<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MyWebsite - E-commerce</title>
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
                <!-- Product Card 1 -->
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="product-card" data-id="1" data-name="Gigabyte AORUS GeForce RTX™ 5090" data-price="14000000" data-image="public/image/product/Gigabyte AORUS GeForce RTX™ 5090 MASTER ICE 32G GV-N5090AORUSM-ICE-32GD.jpg">
                        <div class="product-image-container">
                            <img src="public/image/product/Gigabyte AORUS GeForce RTX™ 5090 MASTER ICE 32G GV-N5090AORUSM-ICE-32GD.jpg" alt="RTX 5090">
                        </div>
                        <div class="product-info">
                            <div class="product-discount">-15%</div>
                            <h5 class="product-title">Gigabyte AORUS GeForce RTX™ 5090</h5>
                            <p class="product-subtitle">MASTER ICE 32G</p>
                            <div class="product-rating"><i class="fas fa-star"></i> 4.8 (128)</div>
                            <div class="stock-badge in-stock">✓ Tersedia</div>
                            <p class="product-price">Rp 14.000.000</p>
                            <div class="d-flex gap-2">
                                <button class="btn-beli flex-fill"><i class="fas fa-shopping-bag"></i> Beli</button>
                                <button class="btn-keranjang flex-fill add-to-cart"><i class="fas fa-shopping-cart"></i> Keranjang</button>
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
                                <button class="btn-beli flex-fill"><i class="fas fa-shopping-bag"></i> Beli</button>
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
                        <div class="product-discount">-8%</div>
                            <h5 class="product-title">Produk Terbaru Elektronik</h5>
                            <p class="product-subtitle">Deskripsi Singkat</p>
                            <div class="product-rating"><i class="fas fa-star"></i> 5.0 (256)</div>
                            <div class="stock-badge in-stock">✓ Tersedia</div>
                            <p class="product-price">Rp 5.000.000</p>
                            <div class="d-flex gap-2">
                                <button class="btn-beli flex-fill"><i class="fas fa-shopping-bag"></i> Beli</button>
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
                            <div class="product-discount">-10%</div>
                            <h5 class="product-title">Aksesori Elektronik Berkualitas</h5>
                            <p class="product-subtitle">Garansi Resmi 2 Tahun</p>
                            <div class="product-rating"><i class="fas fa-star"></i> 4.7 (142)</div>
                            <div class="stock-badge in-stock">✓ Tersedia</div>
                            <p class="product-price">Rp 3.500.000</p>
                            <div class="d-flex gap-2">
                                <button class="btn-beli flex-fill"><i class="fas fa-shopping-bag"></i> Beli</button>
                                <button class="btn-keranjang flex-fill"><i class="fas fa-shopping-cart"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Products Section End -->

    <!-- Kategori sections-->
    <div class="products-container" id="produk">
        <div class="container-fluid px-4">
            <h2 class="section-title">Kategori Produk</h2>

        <section class="product-category container my-5">
            <div class="row justify-content-center g-4 text-center align-items-center">
                <!-- Item 1 -->
                <div class="col-6 col-md-2 d-flex flex-column align-items-center">
                    <a href="view/category.php?id=1" class="text-decoration-none text-center">
                        <img src="public/image/icons/prosesor.jpeg" alt="Prosesor"
                            class="img-fluid rounded-circle shadow-sm border mb-2"
                            style="width: 120px; height: 120px; object-fit: cover;">
                        <p class="fw-semibold mb-0 text-dark">Prosesor</p>
                    </a>
                </div>

                <!-- Item 2 -->
                <div class="col-6 col-md-2 d-flex flex-column align-items-center">
                    <a href="view/category.php?id=2" class="text-decoration-none text-center">
                        <img src="public/image/icons/motherboard.jpeg" alt="Motherboard"
                            class="img-fluid rounded-circle shadow-sm border mb-2"
                            style="width: 120px; height: 120px; object-fit: cover;">
                        <p class="fw-semibold mb-0 text-dark">Motherboard</p>
                    </a>
                </div>

                <!-- Item 3 -->
                <div class="col-6 col-md-2 d-flex flex-column align-items-center">
                    <a href="view/category.php?id=3" class="text-decoration-none text-center">
                        <img src="public/image/icons/psu.jpeg" alt="Power Supply Unit"
                            class="img-fluid rounded-circle shadow-sm border mb-2"
                            style="width: 120px; height: 120px; object-fit: cover;">
                        <p class="fw-semibold mb-0 text-dark">Power Supply Unit</p>
                    </a>
                </div>

                <!-- Item 4 -->
                <div class="col-6 col-md-2 d-flex flex-column align-items-center">
                    <a href="view/category.php?id=4" class="text-decoration-none text-center">
                        <img src="public/image/icons/ram.jpeg" alt="RAM"
                            class="img-fluid rounded-circle shadow-sm border mb-2"
                            style="width: 120px; height: 120px; object-fit: cover;">
                        <p class="fw-semibold mb-0 text-dark">RAM</p>
                    </a>
                </div>

                <!-- Item 5 -->
                <div class="col-6 col-md-2 d-flex flex-column align-items-center">
                    <a href="view/category.php?id=5" class="text-decoration-none text-center">
                        <img src="public/image/icons/storage.jpeg" alt="Storage"
                            class="img-fluid rounded-circle shadow-sm border mb-2"
                            style="width: 120px; height: 120px; object-fit: cover;">
                        <p class="fw-semibold mb-0 text-dark">Storage</p>
                    </a>
                </div>

                <!-- Item 6 -->
                <div class="col-6 col-md-2 d-flex flex-column align-items-center">
                    <a href="view/category.php?id=6" class="text-decoration-none text-center">
                        <img src="public/image/icons/vga.jpeg" alt="VGA"
                            class="img-fluid rounded-circle shadow-sm border mb-2"
                            style="width: 120px; height: 120px; object-fit: cover;">
                        <p class="fw-semibold mb-0 text-dark">VGA</p>
                    </a>
                </div>
            </div>
        </section>


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
    <script src="public/js/banner.js"></script>
    <script>
        // Configure carousel to auto-slide every 3 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const carousel = document.getElementById('promoCarousel');
            const carouselInstance = new bootstrap.Carousel(carousel, {
                interval: 3000, // 3 seconds
                ride: 'carousel'
            });

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
                const badge = document.querySelector('.badge');
                if (badge) {
                    badge.textContent = totalItems;
                }
            }
        });
    </script>
    
</body>
</html>