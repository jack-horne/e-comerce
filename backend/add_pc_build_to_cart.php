<?php
session_start();
require_once 'connection.php';

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== TRUE) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$user_id = $_SESSION['id_user'];
$components = json_decode($_POST['components'], true);

if (!$components || !is_array($components)) {
    echo json_encode(['success' => false, 'message' => 'Invalid components data']);
    exit;
}

// Filter out null/empty components
$valid_components = array_filter($components, function($component_id) {
    return !empty($component_id) && is_numeric($component_id);
});

if (empty($valid_components)) {
    echo json_encode(['success' => false, 'message' => 'No valid components selected']);
    exit;
}

try {
    // Start transaction
    mysqli_begin_transaction($conn);

    // Check if user has an active cart, if not create one
    $cart_query = "SELECT id_keranjang FROM keranjang WHERE id_user = ? ORDER BY tgl DESC LIMIT 1";
    $stmt = mysqli_prepare($conn, $cart_query);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $cart_id = $row['id_keranjang'];
    } else {
        // Create new cart
        $insert_cart = "INSERT INTO keranjang (id_user, tgl) VALUES (?, CURDATE())";
        $stmt_cart = mysqli_prepare($conn, $insert_cart);
        mysqli_stmt_bind_param($stmt_cart, "i", $user_id);
        mysqli_stmt_execute($stmt_cart);
        $cart_id = mysqli_insert_id($conn);
    }

    // Add each component to cart
    $added_count = 0;
    foreach ($valid_components as $component_id) {
        // Get product details
        $product_query = "SELECT harga FROM produk WHERE id_produk = ? AND kodisi = 1";
        $stmt_product = mysqli_prepare($conn, $product_query);
        mysqli_stmt_bind_param($stmt_product, "i", $component_id);
        mysqli_stmt_execute($stmt_product);
        $product_result = mysqli_stmt_get_result($stmt_product);

        if ($product_row = mysqli_fetch_assoc($product_result)) {
            $price = $product_row['harga'];

            // Check if product already in cart
            $check_query = "SELECT id_det_keranjang, qty FROM det_keranjang WHERE id_keranjang = ? AND id_produk = ?";
            $stmt_check = mysqli_prepare($conn, $check_query);
            mysqli_stmt_bind_param($stmt_check, "ii", $cart_id, $component_id);
            mysqli_stmt_execute($stmt_check);
            $check_result = mysqli_stmt_get_result($stmt_check);

            if ($check_row = mysqli_fetch_assoc($check_result)) {
                // Update quantity
                $new_qty = $check_row['qty'] + 1;
                $update_query = "UPDATE det_keranjang SET qty = ? WHERE id_det_keranjang = ?";
                $stmt_update = mysqli_prepare($conn, $update_query);
                mysqli_stmt_bind_param($stmt_update, "ii", $new_qty, $check_row['id_det_keranjang']);
                mysqli_stmt_execute($stmt_update);
            } else {
                // Insert new item
                $insert_detail = "INSERT INTO det_keranjang (id_produk, id_keranjang, qty, harga) VALUES (?, ?, 1, ?)";
                $stmt_detail = mysqli_prepare($conn, $insert_detail);
                mysqli_stmt_bind_param($stmt_detail, "iii", $component_id, $cart_id, $price);
                mysqli_stmt_execute($stmt_detail);
            }

            $added_count++;
        }
    }

    // Commit transaction
    mysqli_commit($conn);

    echo json_encode([
        'success' => true,
        'message' => "Berhasil menambahkan $added_count komponen ke keranjang",
        'cart_id' => $cart_id
    ]);

} catch (Exception $e) {
    // Rollback on error
    mysqli_rollback($conn);
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}

mysqli_close($conn);
?>
