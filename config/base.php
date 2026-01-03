<?php
/**
 * FILE: base.php
 * Kegunaan: Mengatur URL, Path, dan Zona Waktu Proyek
 */

// 1. PROTEKSI: Mencegah akses langsung ke file ini via browser
if (!defined('APP_INIT')) {
    die('Akses ditolak secara langsung!');
}

// 2. TIMEZONE: Memastikan waktu transaksi (seperti tgl_penjualan) akurat WIB
date_default_timezone_set('Asia/Jakarta');

// 3. DYNAMIC BASE URL: Agar link CSS/JS tidak pecah meski nama folder diubah rekan tim
$protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http");
$host = $_SERVER['HTTP_HOST'];

// Sesuaikan '/e-comerce' dengan nama folder utama Anda di htdocs TOLONG DI BACA INI!!!
$folder_name = '/e-comerce'; 

define('BASE_URL', $protocol . "://" . $host . $folder_name);

// 4. ROOT PATH: Membantu PHP menemukan file backend tanpa tanda ../ yang membingungkan
define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'] . $folder_name);

// 5. APP INFO: Identitas aplikasi
define('APP_NAME', 'Pixel Part');