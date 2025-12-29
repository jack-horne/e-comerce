<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once __DIR__ . '/../../config/app.php';
require_once __DIR__ . '/../../backend/connection.php';

$search = $_GET['search'] ?? '';
$query_str = "SELECT * FROM user";
if (!empty($search)) {
    $query_str .= " WHERE nm_user LIKE '%$search%' OR email LIKE '%$search%'";
}
$query_str .= " ORDER BY id_user DESC";
$result = mysqli_query($conn, $query_str);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List - Pixel Part</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* RESET TOTAL UNTUK MENGHILANGKAN GAP */
        html, body { height: 100%; margin: 0; padding: 0; }
        
        .admin-layout {
            display: grid;
            grid-template-columns: 260px 1fr; /* Sidebar 260px, sisanya konten */
            min-height: 100vh;
            gap: 0; /* Gap nol mutlak */
        }

        .sidebar-wrapper {
            background-color: #212529; /* Warna bg-dark */
            overflow-y: auto;
        }

        .main-wrapper {
            background-color: #f8f9fa;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .user-avatar { width: 40px; height: 40px; object-fit: cover; border-radius: 50%; }
        
        @media (max-width: 992px) {
            .admin-layout { grid-template-columns: 1fr; }
            .sidebar-wrapper { display: none; }
        }
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
                <span class="small text-muted d-none d-md-block">Admin: <strong>Pixel Admin</strong></span>
                <img src="<?= BASE_URL ?>/public/image/user-avatar.jpg" class="rounded-circle border" width="35" height="35">
            </div>
        </nav>

        <div class="p-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <form method="GET" class="d-flex gap-2">
                        <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari user..." value="<?= htmlspecialchars($search) ?>">
                        <button type="submit" class="btn btn-sm btn-dark px-3"><i class="fas fa-search"></i></button>
                    </form>
                    <a href="add.php" class="btn btn-primary btn-sm"><i class="fas fa-plus me-1"></i> Tambah User</a>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-0 text-nowrap">
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
                                    <td><img src="<?= BASE_URL ?>/public/image/<?= $user['foto'] ?? 'user-avatar.jpg' ?>" class="user-avatar"></td>
                                    <td class="fw-bold"><?= $user['nm_user'] ?></td>
                                    <td><?= $user['email'] ?></td>
                                    <td><span class="badge <?= $user['role'] == 'admin' ? 'bg-danger' : 'bg-info text-dark' ?>"><?= ucfirst($user['role']) ?></span></td>
                                    <td class="text-center">
                                        <a href="edit.php?id=<?= $user['id_user'] ?>" class="btn btn-sm btn-link text-warning p-0 me-2"><i class="fas fa-edit"></i></a>
                                        <a href="delete.php?id=<?= $user['id_user'] ?>" class="btn btn-sm btn-link text-danger p-0" onclick="return confirm('Hapus user?')"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>