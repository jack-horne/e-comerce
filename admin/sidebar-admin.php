<?php

if (!defined('BASE_URL')) {
    define('BASE_URL', '/e-comerce'); 
}
$url_aktif = $_SERVER['PHP_SELF'];
?>

<div class="bg-dark text-white vh-100 p-3 shadow-lg d-flex flex-column" style="position: sticky; top: 0; min-width: 220px;">
    <div class="mb-4 border-bottom pb-3">
        <h5 class="m-0 text-info fw-bold">
            <i class="fas fa-microchip me-2"></i>Pixel Part
        </h5>
    </div>
    
    <nav class="flex-grow-1">
        <ul style="list-style: none !important; padding: 0; margin: 0;">
            <li class="mb-2">
                <a href="<?= BASE_URL; ?>/admin/dashboard.php" class="nav-link-custom <?= (strpos($url_aktif, 'dashboard.php') !== false) ? 'active' : ''; ?>">
                    <i class="fas fa-home me-2"></i> Dashboard
                </a>
            </li>
            <li class="mb-2">
                <a href="<?= BASE_URL; ?>/admin/products/list.php" class="nav-link-custom <?= (strpos($url_aktif, 'products/') !== false) ? 'active' : ''; ?>">
                    <i class="fas fa-box me-2"></i> Produk
                </a>
            </li>
            <li class="mb-2">
                <a href="<?= BASE_URL; ?>/admin/orders/list.php" class="nav-link-custom <?= (strpos($url_aktif, 'orders/') !== false) ? 'active' : ''; ?>">
                    <i class="fas fa-shopping-bag me-2"></i> Pesanan
                </a>
            </li>
            <li class="mb-2">
                <a href="<?= BASE_URL; ?>/admin/user/list.php" class="nav-link-custom <?= (strpos($url_aktif, 'user/') !== false) ? 'active' : ''; ?>">
                    <i class="fas fa-users me-2"></i> User
                </a>
            </li>
            <li class="mb-2">
                <a href="<?= BASE_URL; ?>/admin/reports/sales.php" class="nav-link-custom <?= (strpos($url_aktif, 'reports/') !== false) ? 'active' : ''; ?>">
                    <i class="fas fa-chart-bar me-2"></i> Laporan
                </a>
            </li>
        </ul>
    </nav>

    <div class="border-top pt-3 mt-auto">
        <a href="<?= BASE_URL; ?>/backend/logout.php" class="nav-link-custom text-danger fw-bold" onclick="return confirm('Yakin ingin keluar?')">
             <i class="fas fa-sign-out-alt me-2"></i> Logout
        </a>
    </div>
</div>

<style>
    .nav-link-custom {
        display: block;
        padding: 10px 15px;
        color: rgba(255,255,255,0.8);
        text-decoration: none;
        border-radius: 8px;
        transition: 0.3s;
    }
    .nav-link-custom:hover {
        background: rgba(255,255,255,0.1);
        color: #0dcaf0;
    }
    .nav-link-custom.active {
        background: #0dcaf0 !important;
        color: #000 !important;
        font-weight: bold;
    }
    /* Menghapus semua bullet point yang mungkin muncul dari CSS luar */
    ul, li { list-style: none !important; }
</style>