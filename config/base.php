<?php
/**
 * Konfigurasi base path untuk Pixel Part
 */

// 1. Definisikan BASE_URL dengan pengecekan agar tidak error "Already Defined"
if (!defined('BASE_URL')) {
    // Sesuaikan dengan folder proyek kamu di localhost
    define('BASE_URL', '/e_commerce2/'); 
}

// 2. Definisikan BASE_PATH untuk keperluan include file (Internal Server)
if (!defined('BASE_PATH')) {
    define('BASE_PATH', __DIR__ . '/../');
}

/**
 * Helper function untuk generate URL absolut (untuk link/gambar)
 * Contoh penggunaan: <img src="<?= base_url('public/image/logo.png') ?>">
 */
if (!function_exists('base_url')) {
    function base_url($path = '') {
        return BASE_URL . ltrim($path, '/');
    }
}

/**
 * Helper function untuk include file (Internal Server)
 */
if (!function_exists('include_path')) {
    function include_path($path) {
        return BASE_PATH . ltrim($path, '/');
    }
}
?>