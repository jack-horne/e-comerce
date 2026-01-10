<?php
session_start();
require_once '../../config/init.php'; 

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== TRUE) {
    header('Location: ' . BASE_URL . 'view/login.php');
    exit();
}

echo "ID User yang sedang login: " . $_SESSION['id_user']; 

$user_id = $_SESSION['id_user'];

// 1. Ambil data user lengkap (termasuk alamat dari tabel user dan username dari tabel akun)
$query = "SELECT u.nm_user, u.no_hp, u.email, u.alamat, a.username
          FROM user u
          JOIN akun a ON u.id_user = a.id_user
          WHERE u.id_user = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

// 2. Proses Update jika tombol Simpan diklik
if (isset($_POST['update'])) {
    $nama = $_POST['nama'];
    $no_hp = $_POST['no_hp'];
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];
    $username = $_POST['username'];

    // 1. Update tabel user
    $update_user = "UPDATE user SET nm_user = ?, no_hp = ?, email = ?, alamat = ? WHERE id_user = ?";
    $stmt1 = mysqli_prepare($conn, $update_user);
    mysqli_stmt_bind_param($stmt1, "ssssi", $nama, $no_hp, $email, $alamat, $user_id);
    $res1 = mysqli_stmt_execute($stmt1);

    // 2. Update tabel akun
    $update_akun = "UPDATE akun SET username = ? WHERE id_user = ?";
    $stmt2 = mysqli_prepare($conn, $update_akun);
    mysqli_stmt_bind_param($stmt2, "si", $username, $user_id);
    $res2 = mysqli_stmt_execute($stmt2);
    
    if (mysqli_stmt_execute($stmt1) && mysqli_stmt_execute($stmt2)) {
        echo "<script>alert('Profil dan Akun berhasil diperbarui!'); window.location='profile.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Profil - Pixel Part</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../public/css/style.css" />
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container my-5">
        <div class="card shadow-sm col-md-6 mx-auto">
            <div class="card-header bg-warning text-dark">
                <h4 class="mb-0">Edit Data Profil & Akun</h4>
            </div>
            <div class="card-body">
                <form action="" method="POST">
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Nama Pengguna (Username)</label>
                        <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($user['username']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($user['nm_user']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nomor HP</label>
                        <input type="text" name="no_hp" class="form-control" value="<?= htmlspecialchars($user['no_hp']); ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat Lengkap</label>
                        <textarea name="alamat" class="form-control" rows="3"><?= htmlspecialchars($user['alamat'] ?? ''); ?></textarea>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="profile.php" class="btn btn-secondary">Batal</a>
                        <button type="submit" name="update" class="btn btn-success px-4">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>