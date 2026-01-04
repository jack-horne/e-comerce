<?php
session_start();
require_once '../../config/connection.php';

// Ambil data kategori
$kategori_query = "SELECT * FROM kat_produk ORDER BY nm_kategori";
$kategori_result = mysqli_query($conn, $kategori_query);

// Ambil data supplier
$supplier_query = "SELECT * FROM supplier ORDER BY nm_supplier";
$supplier_result = mysqli_query($conn, $supplier_query);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nm_produk = mysqli_real_escape_string($conn, $_POST['nm_produk']);
    $id_kategori = (int)$_POST['id_kategori'];
    $id_supplier = (int)$_POST['id_supplier'];
    $harga = (float)$_POST['harga'];
    $qyt = (int)$_POST['qyt'];
    $diskon = (int)$_POST['diskon'];
    $kodisi = (int)$_POST['kodisi'];
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $rate = 5.0; 
    
    // Handle upload gambar
    $gambar_name = 'default.png'; // Nilai awal adalah default
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['gambar']['name'];
        $filetype = pathinfo($filename, PATHINFO_EXTENSION);
        
        if (in_array(strtolower($filetype), $allowed)) {
            $new_filename = uniqid() . '_' . time() . '.' . $filetype;
            $upload_path = '../../public/image/product/' . $new_filename;
            
            if (move_uploaded_file($_FILES['gambar']['tmp_name'], $upload_path)) {
                $gambar_name = $new_filename;
            }
        }
    }
    
    // Insert ke database
    $query = "INSERT INTO produk (id_kategori, id_supplier, nm_produk, qyt, kodisi, deskripsi, rate, harga, gambar, diskon) 
              VALUES ($id_kategori, $id_supplier, '$nm_produk', $qyt, $kodisi, '$deskripsi', $rate, $harga, '$gambar_name', $diskon)";
    
    if (mysqli_query($conn, $query)) {
        header("Location: list.php?success=add");
        exit();
    } else {
        $error = "Gagal menambahkan produk: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%); min-height: 100vh; }
        .card { border-radius: 15px; border: none; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .image-preview { max-width: 200px; max-height: 200px; margin-top: 10px; border-radius: 8px; display: none; }
    </style>
</head>
<body>
    <?php include '../navbar-admin.php'; ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2"><?php include '../sidebar-admin.php'; ?></div>
            <div class="col-md-10 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="text-white"><i class="fas fa-plus-circle"></i> Tambah Produk</h2>
                    <a href="list.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
                </div>
                <div class="card">
                    <div class="card-body p-4">
                        <form method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama Produk <span class="text-danger">*</span></label>
                                    <input type="text" name="nm_produk" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Kategori <span class="text-danger">*</span></label>
                                    <select name="id_kategori" class="form-select" required>
                                        <option value="">Pilih Kategori</option>
                                        <?php while ($kat = mysqli_fetch_assoc($kategori_result)): ?>
                                            <option value="<?= $kat['id_kategori']; ?>"><?= htmlspecialchars($kat['nm_kategori']); ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Supplier <span class="text-danger">*</span></label>
                                    <select name="id_supplier" class="form-select" required>
                                        <option value="">Pilih Supplier</option>
                                        <?php while ($sup = mysqli_fetch_assoc($supplier_result)): ?>
                                            <option value="<?= $sup['id_supplier']; ?>"><?= htmlspecialchars($sup['nm_supplier']); ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Harga (Rp)</label>
                                    <input type="number" name="harga" class="form-control" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Stok</label>
                                    <input type="number" name="qyt" class="form-control" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Diskon (%)</label>
                                    <input type="number" name="diskon" class="form-control" value="0">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="kodisi" class="form-select">
                                        <option value="1">Tersedia</option>
                                        <option value="0">Habis</option>
                                    </select>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Gambar Produk</label>
                                    <input type="file" name="gambar" class="form-control" accept="image/*" onchange="previewImage(event)">
                                    <img id="imagePreview" class="image-preview" alt="Preview">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Deskripsi</label>
                                    <textarea name="deskripsi" class="form-control" rows="3"></textarea>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Produk</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function previewImage(event) {
            const preview = document.getElementById('imagePreview');
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
</body>
</html>