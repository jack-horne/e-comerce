<?php
session_start();
require_once __DIR__ . "/../../config/init.php";

if (!isset($_GET['id'])) { header("Location: list.php"); exit(); }
$id_produk = (int)$_GET['id'];

// Ambil data produk lama
$query = "SELECT * FROM produk WHERE id_produk = $id_produk";
$result = mysqli_query($conn, $query);
$produk = mysqli_fetch_assoc($result);

// Ambil kategori & supplier
$kategori_result = mysqli_query($conn, "SELECT * FROM kat_produk ORDER BY nm_kategori");
$supplier_result = mysqli_query($conn, "SELECT * FROM supplier ORDER BY nm_supplier");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nm_produk = mysqli_real_escape_string($conn, $_POST['nm_produk']);
    $id_kategori = (int)$_POST['id_kategori'];
    $id_supplier = (int)$_POST['id_supplier'];
    $harga = (float)$_POST['harga'];
    $qyt = (int)$_POST['qyt'];
    $diskon = (int)$_POST['diskon'];
    $kodisi = (int)$_POST['kodisi'];
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    
    $gambar_name = $produk['gambar']; // Default pakai yang lama

    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $filetype = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
        $new_filename = uniqid() . '_' . time() . '.' . $filetype;
        $upload_path = '../../public/image/product/' . $new_filename;
        
        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $upload_path)) {
            // Hapus gambar lama jika bukan default
            if ($produk['gambar'] != 'default.png' && file_exists('../../public/image/product/' . $produk['gambar'])) {
                unlink('../../public/image/product/' . $produk['gambar']);
            }
            $gambar_name = $new_filename;
        }
    }

    $update_query = "UPDATE produk SET 
                     nm_produk = '$nm_produk', id_kategori = $id_kategori, id_supplier = $id_supplier,
                     harga = $harga, qyt = $qyt, diskon = $diskon, kodisi = $kodisi, 
                     deskripsi = '$deskripsi', gambar = '$gambar_name'
                     WHERE id_produk = $id_produk";
    
    if (mysqli_query($conn, $update_query)) {
        header("Location: list.php?success=edit");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Produk - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%); min-height: 100vh; }
        .card { border-radius: 15px; border: none; }
        .current-image { max-width: 150px; border-radius: 8px; margin-bottom: 10px; }
    </style>
</head>
<body>
    
    
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2"><?php include '../sidebar-admin.php'; ?></div>
            <div class="col-md-10 p-4">
                <h2 class="text-white mb-4">Edit Produk</h2>
                <div class="card">
                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama Produk</label>
                                    <input type="text" name="nm_produk" class="form-control" value="<?= $produk['nm_produk']; ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Kategori</label>
                                    <select name="id_kategori" class="form-select">
                                        <?php while ($kat = mysqli_fetch_assoc($kategori_result)): ?>
                                            <option value="<?= $kat['id_kategori']; ?>" <?= ($kat['id_kategori'] == $produk['id_kategori']) ? 'selected' : ''; ?>>
                                                <?= $kat['nm_kategori']; ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Gambar Saat Ini</label><br>
                                    <img src="../../publik/image/product/<?= $produk['gambar']; ?>" class="current-image">
                                    <input type="file" name="gambar" class="form-control" accept="image/*">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Deskripsi</label>
                                    <textarea name="deskripsi" class="form-control" rows="3"><?= $produk['deskripsi']; ?></textarea>
                                </div>
                                </div>
                            <button type="submit" class="btn btn-primary">Update Produk</button>
                            <a href="list.php" class="btn btn-secondary">Batal</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>