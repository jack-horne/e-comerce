<?php
// 1. Logika PHP HARUS diletakkan di bagian paling atas
session_start();
include '../backend/connection.php'; // file koneksi 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $username_input = $_POST['email']; 
    $password_input = $_POST['password']; 

    // Siapkan query (menggunakan Prepared Statement)
    $query = "
        SELECT a.password, a.id_akun, a.id_user, a.role, u.nm_user
        FROM akun a 
        JOIN user u ON a.id_user = u.id_user 
        WHERE a.username = ? 
    ";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $username_input);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $hashed_password_db = $row['password'];

        // VERIFIKASI DENGAN password_verify()
        if (password_verify($password_input, $hashed_password_db)) {
            
            // Login Berhasil: Buat session
            $_SESSION['id_akun'] = $row['id_akun'];
            $_SESSION['id_user'] = $row['id_user'];
            $_SESSION['username'] = $username_input;
            $_SESSION['role'] = $row['role'];
            $_SESSION['nm_user'] = $row['nm_user'];
            $_SESSION['logged_in'] = TRUE; 

            // Redirect berdasarkan role
            if ($_SESSION['role'] == 'admin') {
                header("Location: ../admin/dashboard.php");
                exit;
            } else {
                // Asumsi index.php ada di root E-COMMERCE
                header("Location: ../index.php"); 
                exit;
            }
        } else {
            $error_message = "Password salah.";
        }
    } else {
        $error_message = "Email tidak terdaftar.";
    }
    
    // Jika ada error, tampilkan alert dan reload halaman login
    echo "<script>alert('Login gagal! Periksa email atau password Anda.'); window.location='login.php';</script>";
    exit; // Pastikan skrip berhenti setelah redirect atau alert
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow p-4" style="width: 25rem; border-radius: 1rem;">
            <h3 class="text-center mb-4">Login</h3>
            
            <?php 
                // Jika Anda ingin menampilkan error di body, bukan alert:
                // if(isset($_GET['error'])) {
                //     echo '<div class="alert alert-danger" role="alert">' . htmlspecialchars($_GET['error']) . '</div>';
                // }
            ?>

            <form action="login.php" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
            
            <p class="text-center mt-3 mb-0">
                Belum punya akun? <a href="register.php" class="text-decoration-none">Daftar sekarang</a>
            </p>
        </div>
    </div>

</body>
</html>
