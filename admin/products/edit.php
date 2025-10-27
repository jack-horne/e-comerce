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

// Ambil data produk
$query = "SELECT * FROM produk WHERE id_produk = $id_produk";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    header("Location: list.php?error=not_found");
    exit();
}

$produk = mysqli_fetch_assoc($result);

// Ambil data kategori
$kategori_query = "SELECT * FROM kat_produk ORDER BY nm_kategori";
$kategori_result = mysqli_query($conn, $kategori_query);

// Ambil data supplier
$supplier_query = "SELECT * FROM supplier ORDER BY nm_supplier";
$supplier_result = mysqli_query($conn, $supplier_query);

// Handle form submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nm_produk = mysqli_real_escape_string($conn, $_POST['nm_produk']);
    $id_kategori = (int)$_POST['id_kategori'];
    $id_supplier = (int)$_POST['id_supplier'];
    $harga = (float)$_POST['harga'];
    $qyt = (int)$_POST['qyt'];
    $diskon = (int)$_POST['diskon'];
    $kodisi = (int)$_POST['kodisi'];
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    
    // Handle upload gambar baru
    $gambar_name = $produk['gambar']; // Default pakai gambar lama
    
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['gambar']['name'];
        $filetype = pathinfo($filename, PATHINFO_EXTENSION);
        
        if (in_array(strtolower($filetype), $allowed)) {
            // Generate unique filename
            $new_filename = uniqid() . '_' . time() . '.' . $filetype;
            $upload_path = '../../publik/image/product/' . $new_filename;
            
            if (move_uploaded_file($_FILES['gambar']['tmp_name'], $upload_path)) {
                // Hapus gambar lama jika ada
                if (!empty($produk['gambar'])) {
                    $old_image = '../../publik/image/product/' . $produk['gambar'];
                    if (file_exists($old_image)) {
                        unlink($old_image);
                    }
                }
                $gambar_name = $new_filename;
            }
        }
    }
    
    // Update database
    $update_query = "UPDATE produk SET 
                     nm_produk = '$nm_produk',
                     id_kategori = $id_kategori,
                     id_supplier = $id_supplier,
                     harga = $harga,
                     qyt = $qyt,
                     diskon = $diskon,
                     kodisi = $kodisi,
                     deskripsi = '$deskripsi',
                     gambar = " . ($gambar_name ? "'$gambar_name'" : "NULL") . "
                     WHERE id_produk = $id_produk";
    
    if (mysqli_query($conn, $update_query)) {
        header("Location: list.php?success=edit");
        exit();
    } else {
        $error = "Gagal mengupdate produk: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            min-height: 100vh;
        }
        .card {
            border-radius: 15px;
            border: none;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
            border-radius: 8px;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        h2 {
            color: white;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }
        .form-label {
            font-weight: 600;
        }
        .image-preview {
            max-width: 200px;
            max-height: 200px;
            margin-top: 10px;
            border-radius: 8px;
        }
        .current-image {
            max-width: 150px;
            max-height: 150px;
            border-radius: 8px;
            margin-bottom: 10px;
        }
        .alert {
            border-radius: 10px;
            border: none;
        }
    </style>
</head>
<body>
    <?php include '../navbar-admin.php'; ?>
    
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2">
                <?php include '../sidebar-admin.php'; ?>
            </div>
            
            <div class="col-md-10 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2><i class="fas fa-edit"></i> Edit Produk</h2>
                    <a href="list.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>

                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>

                <div class="card">
                    <div class="card-body p-4">
                        <form method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <!-- Nama Produk -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama Produk <span class="text-danger">*</span></label>
                                    <input type="text" name="nm_produk" class="form-control" required 
                                           value="<?php echo htmlspecialchars($produk['nm_produk']); ?>">
                                </div>

                                <!-- Kategori -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Kategori <span class="text-danger">*</span></label>
                                    <select name="id_kategori" class="form-select" required>
                                        <option value="">Pilih Kategori</option>
                                        <?php while ($kat = mysqli_fetch_assoc($kategori_result)): ?>
                                            <option value="<?php echo $kat['id_kategori']; ?>"
                                                <?php echo ($kat['id_kategori'] == $produk['id_kategori']) ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($kat['nm_kategori']); ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>

                                <!-- Supplier -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Supplier <span class="text-danger">*</span></label>
                                    <select name="id_supplier" class="form-select" required>
                                        <option value="">Pilih Supplier</option>
                                        <?php while ($sup = mysqli_fetch_assoc($supplier_result)): ?>
                                            <option value="<?php echo $sup['id_supplier']; ?>"
                                                <?php echo ($sup['id_supplier'] == $produk['id_supplier']) ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($sup['nm_supplier']); ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>

                                <!-- Harga -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Harga (Rp) <span class="text-danger">*</span></label>
                                    <input type="number" name="harga" class="form-control" required min="0" step="1000"
                                           value="<?php echo $produk['harga']; ?>">
                                </div>

                                <!-- Stok -->
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Stok <span class="text-danger">*</span></label>
                                    <input type="number" name="qyt" class="form-control" required min="0"
                                           value="<?php echo $produk['qyt']; ?>">
                                </div>

                                <!-- Diskon -->
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Diskon (%)</label>
                                    <input type="number" name="diskon" class="form-control" min="0" max="100"
                                           value="<?php echo $produk['diskon']; ?>">
                                    <small class="text-muted">Isi 0 jika KIKIRRR</small>
                                </div>

                                <!-- Status -->
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Status <span class="text-danger">*</span></label>
                                    <select name="kodisi" class="form-select" required>
                                        <option value="1" <?php echo ($produk['kodisi'] == 1) ? 'selected' : ''; ?>>Tersedia</option>
                                        <option value="0" <?php echo ($produk['kodisi'] == 0) ? 'selected' : ''; ?>>Habis</option>
                                    </select>
                                </div>

                                <!-- Gambar Saat Ini -->
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Gambar Saat Ini</label>
                                    <br>
                                    <?php if (!empty($produk['gambar'])): ?>
                                        <img src="../../publik/image/product/<?php echo htmlspecialchars($produk['gambar']); ?>" 
                                             class="current-image" alt="Current Image">
                                        <p class="text-muted small">File: <?php echo htmlspecialchars($produk['gambar']); ?></p>
                                    <?php else: ?>
                                        <p class="text-muted">Tidak ada gambar</p>
                                    <?php endif; ?>
                                </div>

                                <!-- Upload Gambar Baru -->
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Ganti Gambar Produk</label>
                                    <input type="file" name="gambar" class="form-control" accept="image/*" 
                                           id="imageInput" onchange="previewImage(event)">
                                    <small class="text-muted">Kosongkan jika tidak ingin mengganti gambar. Format: JPG, JPEG, PNG, GIF (Max 2MB)</small>
                                    <img id="imagePreview" class="image-preview" style="display:none;" alt="Preview">
                                </div>

                                <!-- Deskripsi -->
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Deskripsi Produk</label>
                                    <textarea name="deskripsi" class="form-control" rows="5"><?php echo htmlspecialchars($produk['deskripsi']); ?></textarea>
                                </div>
                            </div>

                            <div class="d-flex gap-2 mt-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Update Produk
                                </button>
                                <a href="list.php" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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