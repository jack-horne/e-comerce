<?php
header('Content-Type: application/json');
require_once 'connection.php';
require_once 'midtrans_config.php'; // Ini akan memuat library Midtrans

// Ambil data JSON dari frontend
$input = json_decode(file_get_contents('php://input'), true);
$total_bayar = $input['total'];

// 1. Buat ID Order Unik (Penting untuk Midtrans)
$id_order = 'PIXEL-' . time() . '-' . rand(100, 999);

// 2. Simpan ke database (Sesuaikan nama tabel kamu, misal: penjualan)
$query = "INSERT INTO penjualan (kd_invoice, total_harga, status_pembayaran, tgl_penjualan) 
          VALUES ('$id_order', '$total_bayar', 'Pending', NOW())";

if (mysqli_query($conn, $query)) {
    
    // 3. Siapkan Parameter untuk dikirim ke Midtrans
    $params = [
        'transaction_details' => [
            'order_id' => $id_order,
            'gross_amount' => (int)$total_bayar, // Harus integer
        ],
    ];

    try {
        // 4. Minta Snap Token
        $snapToken = \Midtrans\Snap::getSnapToken($params);
        echo json_encode(['status' => 'success', 'snap_token' => $snapToken]);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }

} else {
    echo json_encode(['status' => 'error', 'message' => 'Gagal simpan database']);
}