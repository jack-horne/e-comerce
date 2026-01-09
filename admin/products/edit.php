<?php
// 1. Berikan kunci akses
if (!defined('APP_INIT')) {
    define('APP_INIT', true);
}

// 2. Panggil init.php
$init_path = __DIR__ . '/../../config/init.php';
if (file_exists($init_path)) {
    require_once $init_path;
} else {
    die("Gagal memuat konfigurasi. Jalur salah: " . $init_path);
}

if (!isset($_GET['id'])) { header("Location: list.php"); exit(); }
$id_produk = (int)$_GET['id'];

/** @var mysqli $conn */

// Ambil data produk lama
$query = "SELECT * FROM produk WHERE id_produk = $id_produk";
$result = mysqli_query($conn, $query);
$produk = mysqli_fetch_assoc($result);

// Ambil kategori & supplier untuk dropdown
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
    
    $gambar_name = $produk['gambar']; 

    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $filetype = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
        $new_filename = uniqid() . '_' . time() . '.' . $filetype;
        $upload_path = '../../public/image/product/' . $new_filename;
        
        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $upload_path)) {
            // Hapus file lama jika ada
            if ($produk['gambar'] != 'default.png' && !empty($produk['gambar'])) {
                $old_file = '../../public/image/product/' . $produk['gambar'];
                if (file_exists($old_file) && is_file($old_file)) {
                    unlink($old_file);
                }
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
    } else {
        $error_db = mysqli_error($conn);
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
        .card { border-radius: 15px; border: none; box-shadow: 0 10px 20px rgba(0,0,0,0.2); }
        
        /* CSS KHUSUS GAMBAR AGAR PAS */
        .img-preview-wrapper {
            width: 200px;
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #fff;
            border-radius: 12px;
            overflow: hidden;
            border: 2px solid #dee2e6;
            margin-bottom: 10px;
            padding: 10px;
        }
        .img-preview-wrapper img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain; /* Gambar tidak gepeng */
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2"><?php include '../sidebar-admin.php'; ?></div>
            <div class="col-md-10 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="text-white">Edit Produk</h2>
                    <a href="list.php" class="btn btn-light"><i class="fas fa-arrow-left"></i> Kembali</a>
                </div>

                <?php if(isset($error_db)): ?>
                    <div class="alert alert-danger"><?= $error_db ?></div>
                <?php endif; ?>

                <div class="card">
                    <div class="card-body p-4">
                        <form method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Nama Produk</label>
                                    <input type="text" name="nm_produk" class="form-control" value="<?= htmlspecialchars($produk['nm_produk']); ?>" required>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label fw-bold">Kategori</label>
                                    <select name="id_kategori" class="form-select">
                                        <?php mysqli_data_seek($kategori_result, 0); ?>
                                        <?php while ($kat = mysqli_fetch_assoc($kategori_result)): ?>
                                            <option value="<?= $kat['id_kategori']; ?>" <?= ($kat['id_kategori'] == $produk['id_kategori']) ? 'selected' : ''; ?>>
                                                <?= $kat['nm_kategori']; ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label fw-bold">Supplier</label>
                                    <select name="id_supplier" class="form-select" required>
                                        <?php mysqli_data_seek($supplier_result, 0); ?>
                                        <?php while ($sup = mysqli_fetch_assoc($supplier_result)): ?>
                                            <option value="<?= $sup['id_supplier']; ?>" <?= ($sup['id_supplier'] == $produk['id_supplier']) ? 'selected' : ''; ?>>
                                                <?= $sup['nm_supplier']; ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Harga (Rp)</label>
                                    <input type="number" name="harga" class="form-control" value="<?= $produk['harga']; ?>" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Stok (QYT)</label>
                                    <input type="number" name="qyt" class="form-control" value="<?= $produk['qyt']; ?>" required>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label fw-bold">Diskon (%)</label>
                                    <input type="number" name="diskon" class="form-control" value="<?= $produk['diskon']; ?>">
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label fw-bold">Kondisi</label>
                                    <select name="kodisi" class="form-select">
                                        <option value="1" <?= $produk['kodisi'] == 1 ? 'selected' : ''; ?>>Baru</option>
                                        <option value="0" <?= $produk['kodisi'] == 0 ? 'selected' : ''; ?>>Bekas</option>
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Gambar Produk</label>
                                    <div class="img-preview-wrapper">
                                        <?php 
                                            $imgPath = "../../public/image/product/" . ($produk['gambar'] ?: 'default.png');
                                        ?>
                                        <img src="<?= $imgPath ?>" id="previewImg" alt="Preview">
                                    </div>
                                    <input type="file" name="gambar" class="form-control" accept="image/*" onchange="previewFile(this)">
                                    <small class="text-muted">Format: JPG, PNG, WEBP (Maks 2MB)</small>
                                </div>

                                <div class="col-md-8 mb-3">
                                    <label class="form-label fw-bold">Deskripsi Produk</label>
                                    <textarea name="deskripsi" class="form-control" rows="8"><?= $produk['deskripsi']; ?></textarea>
                                </div>
                            </div>

                            <hr>
                            <div class="d-flex justify-content-end gap-2">
                                <a href="list.php" class="btn btn-secondary px-4">Batal</a>
                                <button type="submit" class="btn btn-primary px-5">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewFile(input){
            var file = $("input[type=file]").get(0).files[0];
            if(file){
                var reader = new FileReader();
                reader.onload = function(){
                    $("#previewImg").attr("src", reader.result);
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>