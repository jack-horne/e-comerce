<?php
session_start();

// Cek login admin
// if (!isset($_SESSION['admin_id'])) {
//     header("Location: ../../index.php");
//     exit();
// }

require_once '../../backend/connection.php';

// Cek apakah ada ID produk
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: list.php?error=no_id");
    exit();
}

$id_produk = (int)$_GET['id'];

// Ambil data produk untuk mendapatkan nama file gambar
$query = "SELECT gambar FROM produk WHERE id_produk = $id_produk";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    header("Location: list.php?error=not_found");
    exit();
}

$produk = mysqli_fetch_assoc($result);

// Hapus file gambar jika ada
if (!empty($produk['gambar'])) {
    $image_path = '../../publik/image/product/' . $produk['gambar'];
    if (file_exists($image_path)) {
        unlink($image_path); // Hapus file gambar
    }
}

// Hapus data produk dari database
$delete_query = "DELETE FROM produk WHERE id_produk = $id_produk";

if (mysqli_query($conn, $delete_query)) {
    // Berhasil hapus
    header("Location: list.php?success  ");
} else {
    // Gagal hapus
    header("Location: list.php?failed");
}

exit();
?>
