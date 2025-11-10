<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../public/css/admin.css">
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <aside class="sidebar bg-dark text-white" id="sidebar">
            <div class="sidebar-header p-3 border-bottom d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i>Pixel Part</h5>
                <button class="btn btn-dark btn-sm d-lg-none" id="closeSidebar">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <nav class="sidebar-nav">
                <ul class="list-unstyled">
                    <li><a href="../dashboard.php" class="nav-link"><i class="fas fa-home"></i> Dashboard</a></li>
                    <li><a href="list.php" class="nav-link active"><i class="fas fa-box"></i> Produk</a></li>
                    <li><a href="../orders/list.php" class="nav-link"><i class="fas fa-shopping-bag"></i> Pesanan</a></li>
                    <li><a href="../users/list.php" class="nav-link"><i class="fas fa-users"></i> User</a></li>
                    <li><a href="../reports/sales.php" class="nav-link"><i class="fas fa-chart-bar"></i> Laporan</a></li>
                    <li><a href="../settings.php" class="nav-link"><i class="fas fa-cog"></i> Pengaturan</a></li>
                    <li class="border-top mt-3"><a href="../../backend/auth.php?action=logout" class="nav-link text-danger"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                </ul>
            </nav>
        </aside>

        <!-- Overlay -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        <!-- Main Content -->
        <main class="main-content flex-grow-1">
            <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
                <div class="container-fluid px-4">
                    <button class="btn btn-outline-secondary d-lg-none me-2" id="toggleSidebar">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h4 class="mb-0">Daftar Produk</h4>
                    <div class="ms-auto d-flex align-items-center gap-3">
                        <span class="d-none d-md-block">Admin: <strong>Nama Admin</strong></span>
                        <img src="../../public/image/user-avatar.jpg" alt="Admin" class="rounded-circle" width="40" height="40">
                    </div>
                </div>
            </nav>

            <div class="p-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Produk</h5>
                        <a href="add.php" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i> Tambah Produk</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama Produk</th>
                                        <th>Kategori</th>
                                        <th>Harga</th>
                                        <th>Stok</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Gigabyte RTX 5090</td>
                                        <td>GPU</td>
                                        <td>Rp 14.000.000</td>
                                        <td><span class="badge bg-success">10</span></td>
                                        <td>
                                            <a href="edit.php?id=1" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                            <a href="delete.php?id=1" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Sidebar Toggle
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('toggleSidebar');
        const closeBtn = document.getElementById('closeSidebar');
        const overlay = document.getElementById('sidebarOverlay');

        // Open Sidebar
        toggleBtn.addEventListener('click', function() {
            sidebar.classList.add('show');
            overlay.classList.add('show');
            document.body.style.overflow = 'hidden';
        });

        // Close Sidebar
        function closeSidebar() {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
            document.body.style.overflow = 'auto';
        }

        closeBtn.addEventListener('click', closeSidebar);
        overlay.addEventListener('click', closeSidebar);

        // Close sidebar when clicking on a link (mobile)
        const navLinks = document.querySelectorAll('.nav-link');
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth < 992) {
                    closeSidebar();
                }
            });
        });
    </script>
</body>
</html>

