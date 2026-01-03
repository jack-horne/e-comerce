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
$product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
$quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

if ($product_id <= 0 || $quantity <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid product ID or quantity']);
    exit;
}

try {
    // Start transaction
    mysqli_begin_transaction($conn);

    // Check if product exists and is available
    $product_query = "SELECT harga, qyt FROM produk WHERE id_produk = ? AND kodisi = 1";
    $stmt_product = mysqli_prepare($conn, $product_query);
    mysqli_stmt_bind_param($stmt_product, "i", $product_id);
    mysqli_stmt_execute($stmt_product);
    $product_result = mysqli_stmt_get_result($stmt_product);

    if (!$product_row = mysqli_fetch_assoc($product_result)) {
        echo json_encode(['success' => false, 'message' => 'Product not found or unavailable']);
        exit;
    }

    $price = $product_row['harga'];
    $available_stock = $product_row['qyt'];

    // Check if user has an active cart, if not create one
    $cart_query = "SELECT id_keranjang FROM keranjang WHERE id_user = ? ORDER BY tgl DESC LIMIT 1";
    $stmt_cart = mysqli_prepare($conn, $cart_query);
    mysqli_stmt_bind_param($stmt_cart, "i", $user_id);
    mysqli_stmt_execute($stmt_cart);
    $cart_result = mysqli_stmt_get_result($stmt_cart);

    if ($cart_row = mysqli_fetch_assoc($cart_result)) {
        $cart_id = $cart_row['id_keranjang'];
    } else {
        // Create new cart
        $insert_cart = "INSERT INTO keranjang (id_user, tgl) VALUES (?, CURDATE())";
        $stmt_insert_cart = mysqli_prepare($conn, $insert_cart);
        mysqli_stmt_bind_param($stmt_insert_cart, "i", $user_id);
        mysqli_stmt_execute($stmt_insert_cart);
        $cart_id = mysqli_insert_id($conn);
    }

    // Check if product already in cart
    $check_query = "SELECT id_det_keranjang, qty FROM det_keranjang WHERE id_keranjang = ? AND id_produk = ?";
    $stmt_check = mysqli_prepare($conn, $check_query);
    mysqli_stmt_bind_param($stmt_check, "ii", $cart_id, $product_id);
    mysqli_stmt_execute($stmt_check);
    $check_result = mysqli_stmt_get_result($stmt_check);

    if ($check_row = mysqli_fetch_assoc($check_result)) {
        // Update quantity
        $new_qty = $check_row['qty'] + $quantity;

        // Check stock limit
        if ($new_qty > $available_stock) {
            echo json_encode(['success' => false, 'message' => 'Insufficient stock']);
            exit;
        }

        $update_query = "UPDATE det_keranjang SET qty = ? WHERE id_det_keranjang = ?";
        $stmt_update = mysqli_prepare($conn, $update_query);
        mysqli_stmt_bind_param($stmt_update, "ii", $new_qty, $check_row['id_det_keranjang']);
        mysqli_stmt_execute($stmt_update);
    } else {
        // Check stock limit for new item
        if ($quantity > $available_stock) {
            echo json_encode(['success' => false, 'message' => 'Insufficient stock']);
            exit;
        }

        // Insert new item
        $insert_detail = "INSERT INTO det_keranjang (id_produk, id_keranjang, qty, harga) VALUES (?, ?, ?, ?)";
        $stmt_detail = mysqli_prepare($conn, $insert_detail);
        mysqli_stmt_bind_param($stmt_detail, "iiii", $product_id, $cart_id, $quantity, $price);
        mysqli_stmt_execute($stmt_detail);
    }

    // Commit transaction
    mysqli_commit($conn);

    echo json_encode([
        'success' => true,
        'message' => 'Product added to cart successfully',
        'cart_id' => $cart_id
    ]);

} catch (Exception $e) {
    // Rollback on error
    mysqli_rollback($conn);
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}

mysqli_close($conn);
?>
