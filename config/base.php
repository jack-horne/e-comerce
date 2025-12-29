w<?php
// Konfigurasi base path untuk deployment
// Sesuaikan dengan struktur deployment Anda

// Untuk Hostinger, jika deploy di root domain (https://domain.com/)
// define('BASE_URL', '/');

// Jika deploy di subfolder (https://domain.com/ecommerce/)
// define('BASE_URL', '/ecommerce/');

// Default: deploy di root domain
define('BASE_URL', '/');

// Base path untuk include/require (absolute path dari root project)
define('BASE_PATH', __DIR__ . '/../');

// Helper function untuk generate URL absolut
function base_url($path = '') {
    return BASE_URL . ltrim($path, '/');
}

// Helper function untuk include file dengan path absolut
function include_path($path) {
    return BASE_PATH . ltrim($path, '/');
}
?>
