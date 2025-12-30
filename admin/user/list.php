<?php
require_once __DIR__ . '/../../config/app.php';
require_once __DIR__ . '/../../backend/connection.php';

$search = $_GET['search'] ?? '';
$query_str = "SELECT * FROM user";
if (!empty($search)) {
    $s = mysqli_real_escape_string($conn, $search);
    $query_str .= " WHERE nm_user LIKE '%$s%' OR email LIKE '%$s%'";
}
$query_str .= " ORDER BY id_user DESC";
$result = mysqli_query($conn, $query_str);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>User List - Pixel Part</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        html, body { height: 100%; margin: 0; background: #f8f9fa; }
        .admin-layout { display: flex; min-height: 100vh; }
        .sidebar-wrapper { width: 260px; position: fixed; height: 100vh; background: #212529; }
        .main-wrapper { flex: 1; margin-left: 260px; width: calc(100% - 260px); display: flex; flex-direction: column; }
        .user-avatar { width: 40px; height: 40px; object-fit: cover; border-radius: 50%; border: 1px solid #ddd; }
    </style>
</head>
<body>

<div class="admin-layout">
    <aside class="sidebar-wrapper">
        <?php include '../sidebar-admin.php'; ?>
    </aside>

    <main class="main-wrapper">
        <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom px-4 py-3">
            <h4 class="mb-0 fw-bold">Manajemen User</h4>
            <div class="ms-auto d-flex align-items-center gap-3">
                <img src="<?= defined('BASE_URL') ? BASE_URL : '' ?>/public/image/user-avatar.jpg" class="rounded-circle border" width="35" height="35">
            </div>
        </nav>

        <div class="p-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <form method="GET" class="d-flex gap-2">
                        <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari user..." value="<?= htmlspecialchars($search) ?>">
                        <button type="submit" class="btn btn-sm btn-dark"><i class="fas fa-search"></i></button>
                    </form>
                    <a href="add.php" class="btn btn-primary btn-sm"><i class="fas fa-plus me-1"></i> Tambah User</a>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light small text-uppercase">
                            <tr>
                                <th class="ps-4">No</th>
                                <th>Profil</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; while($user = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td class="ps-4"><?= $no++ ?></td>
                                <td><img src="<?= defined('BASE_URL') ? BASE_URL : '' ?>/public/image/<?= $user['foto'] ?? 'user-avatar.jpg' ?>" class="user-avatar" onerror="this.src='/e_commerce2/public/image/product/default.png'"></td>
                                <td class="fw-bold"><?= htmlspecialchars($user['nm_user']) ?></td>
                                <td><?= htmlspecialchars($user['email']) ?></td>
                                <td><span class="badge <?= $user['role'] == 'admin' ? 'bg-danger' : 'bg-info text-dark' ?>"><?= ucfirst($user['role']) ?></span></td>
                                <td class="text-center">
                                    <a href="edit.php?id=<?= $user['id_user'] ?>" class="btn btn-sm text-warning"><i class="fas fa-edit"></i></a>
                                    <a href="delete.php?id=<?= $user['id_user'] ?>" class="btn btn-sm text-danger" onclick="return confirm('Hapus user?')"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>
</body>
</html>