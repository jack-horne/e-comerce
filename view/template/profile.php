<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== TRUE) {
    header('Location: ../view/login.php');
    exit();
}

require_once '../../config/connection.php';

// Ambil data user dari database
$query = "SELECT u.nm_user, u.no_hp, u.email, a.username
          FROM user u
          JOIN akun a ON u.id_user = a.id_user
          WHERE u.id_user = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $_SESSION['id_user']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    $user = [
        'username' => $row['username'],
        'email' => $row['email'],
        'full_name' => $row['nm_user'],
        'phone' => $row['no_hp'] ?? '08123456789',
        'address' => 'Alamat lengkap Anda disini' // Jika ada kolom alamat, tambahkan query
    ];
} else {
    $user = [
        'username' => $_SESSION['username'] ?? 'User',
        'email' => 'user@example.com',
        'full_name' => 'Nama Lengkap',
        'phone' => '08123456789',
        'address' => 'Alamat lengkap Anda disini'
    ];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Profil - Pixel Part</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../../public/css/style.css" />
</head>
<body>
<?php include 'navbar.php'; ?>

<div class="container my-5">
    <h2 class="mb-4">Profil Pengguna</h2>
    <div class="card shadow-sm">
        <div class="card-body">
            <form>
                <div class="mb-3">
                    <label for="fullName" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" id="fullName" value="<?php echo htmlspecialchars($user['full_name']); ?>" readonly />
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Nama Pengguna</label>
                    <input type="text" class="form-control" id="username" value="<?php echo htmlspecialchars($user['username']); ?>" readonly />
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" readonly />
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Nomor Telepon</label>
                    <input type="text" class="form-control" id="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" readonly />
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Alamat</label>
                    <textarea class="form-control" id="address" rows="3" readonly><?php echo htmlspecialchars($user['address']); ?></textarea>
                </div>
                <a href="edit_profile.php" class="btn btn-primary">Edit Profil</a>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
