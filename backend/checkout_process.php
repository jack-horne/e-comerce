<?php
// 1. Panggil Library (Sesuaikan pathnya)
// Jika pakai Composer:
require_once dirname(__DIR__) . '/vendor/autoload.php';

// Jika Manual:
// require_once 'Midtrans/Midtrans.php'; 

// 2. Konfigurasi Key
\Midtrans\Config::$serverKey = 'MASUKKAN_SERVER_KEY_SANDBOX_MU';
\Midtrans\Config::$isProduction = false; // Set false untuk testing
\Midtrans\Config::$isSanitized = true;
\Midtrans\Config::$is3ds = true;

// 3. Ambil data dari Frontend (AJAX)
$data = json_decode(file_get_contents('php://input'), true);

// 4. Siapkan Parameter Transaksi
$params = [
    'transaction_details' => [
        'order_id' => 'PIXEL-' . time(), // Harus unik
        'gross_amount' => $data['total_harga'], // Total nominal
    ],
    'customer_details' => [
        'first_name' => $data['nama_pelanggan'],
        'email' => $data['email'],
    ],
];

// 5. Dapatkan Snap Token
try {
    $snapToken = \Midtrans\Snap::getSnapToken($params);
    echo json_encode(['token' => $snapToken]);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}