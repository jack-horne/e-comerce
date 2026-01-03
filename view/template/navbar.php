<?php
if (!defined('BASE_URL')) {
    define('BASE_URL', '');
}
?>

<nav class="navbar navbar-expand-lg custom-navbar">
  <div class="container">

    <a class="navbar-brand logo" href="<?= BASE_URL ?>/index.php">
      <img src="<?= BASE_URL ?>/public/image/logo.png" alt="PixelPart" width="40" height="40"> 
      <?= APP_NAME ?>
    </a>

    <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
      <i class="fa-solid fa-bars"></i>
    </button>

    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
        
        <li class="nav-item">
          <a class="nav-link" href="<?= BASE_URL ?>/index.php">
            <i class="fa-solid fa-house"></i> Home
          </a>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
            <i class="fa-solid fa-box"></i> Kategori
          </a>
          <ul class="dropdown-menu dropdown-menu-dark">
            <li><a class="dropdown-item" href="<?= BASE_URL ?>/view/produk.php?cat=gpu">VGA</a></li>
            <li><a class="dropdown-item" href="<?= BASE_URL ?>/view/produk.php?cat=cpu">Processor</a></li>
            <li><a class="dropdown-item" href="<?= BASE_URL ?>/view/produk.php?cat=motherboard">Motherboard</a></li>
            </ul>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="<?= BASE_URL ?>/view/about.php">
            <i class="fa-solid fa-address-card"></i> Tentang Kami
          </a>
        </li>

        <li class="nav-divider d-none d-lg-block"></li>

        <li class="nav-item">
          <a class="nav-link nav-icon" href="#" data-bs-toggle="modal" data-bs-target="#searchModal">
            <i class="fa-solid fa-search"></i>
          </a>
        </li>

        <li class="nav-item position-relative">
          <a class="nav-link nav-icon" href="<?= BASE_URL ?>/view/cart.php">
            <i class="fa-solid fa-cart-shopping"></i>
            <span class="badge bg-danger position-absolute top-0 start-100 translate-middle">0</span>
          </a>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
            <i class="fa-solid fa-user"></i> 
            <?= isset($_SESSION['logged_in']) ? htmlspecialchars($_SESSION['nm_user']) : 'Akun' ?>
          </a>
          <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end">
            <?php if (isset($_SESSION['logged_in'])): ?>
                <?php if ($_SESSION['role'] == 'admin'): ?>
                    <li><a class="dropdown-item" href="<?= BASE_URL ?>/admin/dashboard.php">
                        <i class="fa-solid fa-gauge me-2"></i>Dashboard Admin
                    </a></li>
                <?php endif; ?>
                
                <li><a class="dropdown-item" href="<?= BASE_URL ?>/view/profile.php">
                    <i class="fa-solid fa-id-card me-2"></i>Profil Saya
                </a></li>
                <li><hr class="dropdown-divider border-secondary"></li>
                <li><a class="dropdown-item text-danger" href="<?= BASE_URL ?>/backend/logout.php">
                    <i class="fa-solid fa-right-from-bracket me-2"></i>Keluar
                </a></li>
            <?php else: ?>
                <li><a class="dropdown-item" href="<?= BASE_URL ?>/view/login.php">
                  <i class="fa-solid fa-right-to-bracket me-2"></i>Masuk
                </a></li>
                <li><a class="dropdown-item" href="<?= BASE_URL ?>/view/register.php">
                  <i class="fa-solid fa-user-plus me-2"></i>Daftar
                </a></li>
            <?php endif; ?>
          </ul>
        </li>

      </ul>
    </div>
  </div>
</nav>

<div class="modal fade" id="searchModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-dark text-white">
      <div class="modal-header border-secondary">
        <h5 class="modal-title">Search Products</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form action="<?= BASE_URL ?>/view/search.php" method="GET">
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