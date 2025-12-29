<nav class="navbar navbar-expand-lg custom-navbar">
  <div class="container">

    <!-- LOGO -->
    <a class="navbar-brand logo" href="home.php">
      <img src="public/image/logo.png" alt="PixelPart" width="40" height="40"> 
      PixelPart
    </a>

    <!-- TOGGLER (Mobile) -->
    <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
      <i class="fa-solid fa-bars"></i>
    </button>

    <!-- NAV MENU -->
    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
        
        <!-- HOME -->
        <li class="nav-item">
          <a class="nav-link" href="index.php">
            <i class="fa-solid fa-house"></i> Home
          </a>
        </li>

        <!-- DROPDOWN KATEGORI -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
            <i class="fa-solid fa-box"></i> Kategori
          </a>
          <ul class="dropdown-menu dropdown-menu-dark">
            <li><a class="dropdown-item" href="produk.php?cat=gpu">VGA</a></li>
            <li><a class="dropdown-item" href="produk.php?cat=cpu">Processor</a></li>
            <li><a class="dropdown-item" href="produk.php?cat=motherboard">Motherboard</a></li>
            <li><a class="dropdown-item" href="produk.php?cat=ram">RAM</a></li>
            <li><a class="dropdown-item" href="produk.php?cat=storage">Storage</a></li>
            <li><a class="dropdown-item" href="produk.php?cat=psu">Power Supply</a></li>
            <li><a class="dropdown-item" href="produk.php?cat=cooling">Cooling</a></li>
          </ul>
        </li>

        <!-- TENTANG KAMI -->
        <li class="nav-item">
          <a class="nav-link" href="view/template/about.php">
            <i class="fa-solid fa-address-card"></i> Tentang Kami
          </a>
        </li>

        <!-- DIVIDER (Optional) -->
        <li class="nav-divider d-none d-lg-block"></li>

        <!-- SEARCH ICON -->
        <li class="nav-item">
          <a class="nav-link nav-icon" href="#" data-bs-toggle="modal" data-bs-target="#searchModal">
            <i class="fa-solid fa-search"></i>
          </a>
        </li>

        <!-- CART ICON -->
        <li class="nav-item position-relative">
          <a class="nav-link nav-icon" href="view/template/chart.php">
            <i class="fa-solid fa-cart-shopping"></i>
            <span class="badge bg-danger position-absolute top-0 start-100 translate-middle">0</span>
          </a>
        </li>

        <!-- USER DROPDOWN -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
            <i class="fa-solid fa-user"></i> Akun
          </a>
          <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end">
            <li><a class="dropdown-item" href="view/login.php">
              <i class="fa-solid fa-right-to-bracket me-2"></i>Masuk
            </a></li>
            <li><a class="dropdown-item" href="view/register.php">
              <i class="fa-solid fa-user-plus me-2"></i>Daftar
            </a></li>
          </ul>
        </li>

      </ul>
    </div>
  </div>
</nav>

<!-- Search Modal -->
<div class="modal fade" id="searchModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-dark text-white">
      <div class="modal-header border-secondary">
        <h5 class="modal-title">Search Products</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form action="search.php" method="GET">
          <div class="input-group">
            <input type="text" class="form-control" name="q" placeholder="Cari produk...">
            <button class="btn btn-danger" type="submit">
              <i class="fa-solid fa-search"></i> Cari
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<style>
/* BACKGROUND + BLUR */
.custom-navbar {
    background: rgba(0, 0, 0, 0.65);
    backdrop-filter: blur(6px);
    padding: 15px 0;
    position: fixed;
    width: 100%;
    z-index: 99;
    top: 0;
}

/* LOGO */
.logo {
    font-size: 24px;
    font-weight: bold;
    color: #fff !important;
    letter-spacing: 1px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.logo img {
    filter: brightness(1.2);
}

/* NAV LINKS */
.navbar-nav .nav-link {
    color: #ccc !important;
    margin-left: 15px;
    font-size: 15px;
    transition: 0.3s;
    padding: 8px 12px;
}

.navbar-nav .nav-link:hover {
    color: #fff !important;
    text-shadow: 0 0 8px #ff4a4a;
}

/* NAV ICONS */
.nav-link.nav-icon {
    font-size: 18px;
    padding: 8px 12px;
}

/* DIVIDER */
.nav-divider {
    width: 1px;
    height: 25px;
    background: rgba(255, 255, 255, 0.2);
    margin: 0 10px;
}

/* DROPDOWN */
.dropdown-menu-dark {
    background: rgba(0, 0, 0, 0.9);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 8px;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
}

.dropdown-menu-dark .dropdown-item {
    padding: 10px 20px;
    transition: 0.2s;
}

.dropdown-menu-dark .dropdown-item:hover {
    background: #e84343;
    color: white;
    padding-left: 25px;
}

/* CART BADGE */
.navbar-nav .badge {
    font-size: 10px;
    padding: 3px 6px;
    min-width: 18px;
}

/* TOGGLER (Mobile) */
.navbar-toggler {
    border: none;
    font-size: 24px;
    color: #fff;
}

.navbar-toggler:focus {
    box-shadow: none;
}

/* SEARCH MODAL */
.modal-content.bg-dark {
    background-color: rgba(0, 0, 0, 0.95) !important;
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.modal-content .form-control {
    background-color: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: #fff;
}

.modal-content .form-control:focus {
    background-color: rgba(255, 255, 255, 0.15);
    border-color: #e84343;
    color: #fff;
    box-shadow: 0 0 0 0.25rem rgba(232, 67, 67, 0.25);
}

.modal-content .form-control::placeholder {
    color: rgba(255, 255, 255, 0.5);
}

/* RESPONSIVE */
@media (max-width: 992px) {
    .navbar-nav {
        padding: 15px 0;
    }

    .navbar-nav .nav-link {
        margin-left: 0;
        padding: 10px 15px;
    }

    .nav-divider {
        display: none !important;
    }

    .dropdown-menu-end {
        right: auto !important;
    }
}
</style>