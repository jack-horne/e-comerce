<?php
if (!defined('APP_INIT')) {
    die('Akses ditolak');
}

/*
|--------------------------------------------------------------------------
| DATABASE CONFIG
|--------------------------------------------------------------------------
*/
$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'e_comerce_db'; 

$conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

if (!$conn) {
    die('Koneksi database gagal: ' . mysqli_connect_error());
}

// Optional: set charset
mysqli_set_charset($conn, 'utf8mb4');
