<?php
session_start();

// 1. Hapus semua data di dalam variabel session
$_SESSION = array();

// 2. Hancurkan session di server
session_destroy();

// 3. Hapus cookie session jika ada
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 4. Redirect KELUAR dari folder backend menuju index.php di root
header("Location: ../index.php");
exit();