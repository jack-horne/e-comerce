<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 1. BUAT KUNCI AKSES (Wajib di atas require)
if (!defined('APP_INIT')) {
define('APP_INIT', true); 
}

// 2. PANGGIL BASE.PHP
require_once __DIR__ . '/../config/base.php'; 
?>
<?php
/**
 * FILE: base.php
 * Kegunaan: Mengatur URL, Path, dan Zona Waktu Proyek
 */

// 1. PROTEKSI: Mencegah akses langsung ke file ini via browser
// Ganti blok 'die' atau 'Akses Ditolak' dengan ini:
if (!defined('APP_INIT')) {
    define('APP_INIT', true); 
}
// Dengan ini, jika file lupa bawa 'karcis', base.php akan membuatkannya secara otomatis.

// 2. TIMEZONE: Memastikan waktu transaksi (seperti tgl_penjualan) akurat WIB
date_default_timezone_set('Asia/Jakarta');

// 3. DYNAMIC BASE URL: Agar link CSS/JS tidak pecah meski nama folder diubah rekan tim
$protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http");
$host = $_SERVER['HTTP_HOST'];

// Sesuaikan '/e-comerce' dengan nama folder utama Anda di htdocs TOLONG DI BACA INI!!!
$folder_name = '/e_commerce2'; 

define('BASE_URL', $protocol . "://" . $host . $folder_name);

// 4. ROOT PATH: Membantu PHP menemukan file backend tanpa tanda ../ yang membingungkan
define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'] . $folder_name);

// 5. APP INFO: Identitas aplikasi
define('APP_NAME', 'Pixel Part');