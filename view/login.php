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
<title>Futuristic Login</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;600&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

<style>
body{
    min-height:100vh;
    background:linear-gradient(135deg,#0f2027,#203a43,#2c5364);
    display:flex;
    justify-content:center;
    align-items:center;
    font-family:'Orbitron',sans-serif;
    overflow:hidden;
}
body::before{
    content:"";
    position:absolute;
    width:500px;
    height:500px;
    background:radial-gradient(circle,#00f2ff,transparent 70%);
    filter:blur(120px);
    animation:float 6s infinite alternate;
}
@keyframes float{
    from{transform:translate(-100px,-50px);}
    to{transform:translate(150px,100px);}
}
.login-card{
    width:380px;
    padding:2.5rem;
    border-radius:20px;
    background:rgba(255,255,255,0.08);
    backdrop-filter:blur(15px);
    box-shadow:0 0 30px rgba(0,255,255,0.25);
    color:#fff;
    z-index:1;
}
.login-card h3{
    text-align:center;
    margin-bottom:1.8rem;
    letter-spacing:2px;
    color:#00f2ff;
}
.form-control{
    background:transparent;
    border:1px solid rgba(255,255,255,0.3);
    color:#fff;
    border-radius:10px;
}
.form-control:focus{
    background:transparent;
    border-color:#00f2ff;
    box-shadow:0 0 10px rgba(0,242,255,0.6);
    color:#fff;
}
.password-wrapper{
    position:relative;
}


.btn-login{
    background:linear-gradient(135deg,#00f2ff,#0066ff);
    border:none;
    border-radius:12px;
    padding:12px;
    font-weight:600;
    letter-spacing:1px;
    color:#000;
    transition:0.3s;
    position:relative;
}
.btn-login.loading{
    pointer-events:none;
    background:#444;
    color:#fff;
}
.btn-login .spinner{
    display:none;
}
.btn-login.loading .spinner{
    display:inline-block;
}
.btn-login.loading span{
    display:none;
}
.register-link{
    text-align:center;
    margin-top:1.2rem;
    font-size:.85rem;
}
.register-link a{
    color:#00f2ff;
    text-decoration:none;
}
</style>
</head>

<body>

<div class="position-absolute top-0 start-0 p-3">
    <a href="../index.php" class="btn btn-outline-secondary btn-sm">
        <i class="fas fa-arrow-left me-1"></i> Kembali ke Beranda
    </a>
</div>

<div class="login-card">
    <h3>LOGIN</h3>

    <form action="login.php" method="POST" onsubmit="showLoading()">
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3 password-wrapper">
            <label>Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
            
        </div>

        <button type="submit" class="btn btn-login w-100" id="loginBtn">
            <span>LOGIN</span>
            <span class="spinner spinner-border spinner-border-sm"></span>
        </button>
    </form>

    <div class="register-link">
        Belum punya akun? <a href="register.php">Daftar Sekarang</a>
    </div>
</div>

<script>


function showLoading(){
    const btn=document.getElementById("loginBtn");
    btn.classList.add("loading");
}
</script>

</body>
</html>
