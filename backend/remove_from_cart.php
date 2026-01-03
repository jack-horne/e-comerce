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
$cart_detail_id = isset($_POST['cart_detail_id']) ? (int)$_POST['cart_detail_id'] : 0;

if ($cart_detail_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid cart detail ID']);
    exit;
}

try {
    // Start transaction
    mysqli_begin_transaction($conn);

    // Check if cart item belongs to user
    $check_query = "SELECT dk.id_det_keranjang
                    FROM det_keranjang dk
                    JOIN keranjang k ON dk.id_keranjang = k.id_keranjang
                    WHERE dk.id_det_keranjang = ? AND k.id_user = ?";

    $stmt_check = mysqli_prepare($conn, $check_query);
    mysqli_stmt_bind_param($stmt_check, "ii", $cart_detail_id, $user_id);
    mysqli_stmt_execute($stmt_check);
    $check_result = mysqli_stmt_get_result($stmt_check);

    if (!mysqli_fetch_assoc($check_result)) {
        echo json_encode(['success' => false, 'message' => 'Cart item not found']);
        exit;
    }

    // Delete cart item
    $delete_query = "DELETE FROM det_keranjang WHERE id_det_keranjang = ?";
    $stmt_delete = mysqli_prepare($conn, $delete_query);
    mysqli_stmt_bind_param($stmt_delete, "i", $cart_detail_id);
    mysqli_stmt_execute($stmt_delete);

    // Commit transaction
    mysqli_commit($conn);

    echo json_encode([
        'success' => true,
        'message' => 'Item removed from cart successfully'
    ]);

} catch (Exception $e) {
    // Rollback on error
    mysqli_rollback($conn);
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}

mysqli_close($conn);
?>
