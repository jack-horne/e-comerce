<?php
// 1. Berikan kunci akses
if (!defined('APP_INIT')) {
    define('APP_INIT', true);
}

// 2. Panggil init.php (Naik 1 tingkat karena login.php ada di folder 'view')
require_once __DIR__ . '/../config/init.php'; 
?>

<?php
$error = isset($_GET['error']) ? htmlspecialchars($_GET['error']) : '';
$success = isset($_GET['success']) ? htmlspecialchars($_GET['success']) : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Futuristic Register</title>

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
.register-card{
    width:420px;
    padding:2.5rem;
    border-radius:20px;
    background:rgba(255,255,255,0.08);
    backdrop-filter:blur(15px);
    box-shadow:0 0 30px rgba(0,255,255,0.25);
    color:#fff;
    z-index:1;
}
.register-card h3{
    text-align:center;
    margin-bottom:1.5rem;
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
label{
    font-size:.85rem;
    letter-spacing:1px;
}
.password-wrapper{
    position:relative;
}
.btn-register{
    background:linear-gradient(135deg,#00f2ff,#00ff99);
    border:none;
    border-radius:12px;
    padding:12px;
    font-weight:600;
    letter-spacing:1px;
    color:#000;
    transition:.3s;
    position:relative;
}
.btn-register.loading{
    pointer-events:none;
    background:#444;
    color:#fff;
}
.btn-register .spinner{
    display:none;
}
.btn-register.loading .spinner{
    display:inline-block;
}
.btn-register.loading span{
    display:none;
}
.alert{
    border-radius:12px;
    font-size:.85rem;
}
.login-link{
    text-align:center;
    margin-top:1.2rem;
    font-size:.85rem;
}
.login-link a{
    color:#00f2ff;
    text-decoration:none;
}
.login-link a:hover{
    text-shadow:0 0 10px #00f2ff;
}
</style>
</head>

<body>

<div class="position-absolute top-0 start-0 p-3">
    <a href="../index.php" class="btn btn-outline-secondary btn-sm">
        <i class="fas fa-arrow-left me-1"></i> Kembali ke Beranda
    </a>
</div>

<div class="register-card">
    <h3>REGISTER</h3>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form action="../backend/register_process.php" method="POST" onsubmit="showLoading()">
        <div class="mb-3">
            <label>Nama Lengkap</label>
            <input type="text" name="fullname" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3 password-wrapper">
            <label>Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
            
        </div>

        <div class="mb-3 password-wrapper">
            <label>Konfirmasi Password</label>
            <input type="password" name="confirm" id="confirm" class="form-control" required>
            
        </div>

        <button type="submit" class="btn btn-register w-100" id="registerBtn">
            <span>REGISTER</span>
            <span class="spinner spinner-border spinner-border-sm"></span>
        </button>
    </form>

    <div class="login-link">
        Sudah punya akun? <a href="login.php">Login di sini</a>
    </div>
</div>

<script>
function togglePassword(id, icon){
    const input=document.getElementById(id);
    if(input.type==="password"){
        input.type="text";
        icon.classList.replace("fa-eye","fa-eye-slash");
    }else{
        input.type="password";
        icon.classList.replace("fa-eye-slash","fa-eye");
    }
}

function showLoading(){
    const btn=document.getElementById("registerBtn");
    btn.classList.add("loading");
}
</script>

</body>
</html>
