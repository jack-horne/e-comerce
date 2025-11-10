<?php
// Pastikan connection.php sudah mengatur variabel $conn
require_once 'connection.php'; 

// Cek apakah form sudah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Ambil dan bersihkan data POST dari form (view/register.php)
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm'];
    // Catatan: Nomor HP ('no_hp') belum ada di form, kita asumsikan kosong dulu
    $no_hp = ""; 
    $role = "user"; // Set role default untuk pengguna baru

    // Validasi Dasar
    if ($password !== $confirm_password) {
        header("Location: ../view/register.php?error=Konfirmasi password tidak cocok.");
        exit();
    }
    
    // Enkripsi Password (WAJIB!)
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // 1. Cek Duplikasi Email di tabel 'user'
    $check_sql = "SELECT id_user FROM user WHERE email = ?";
    $stmt_check = mysqli_prepare($conn, $check_sql);
    mysqli_stmt_bind_param($stmt_check, "s", $email);
    mysqli_stmt_execute($stmt_check);
    mysqli_stmt_store_result($stmt_check);

    if (mysqli_stmt_num_rows($stmt_check) > 0) {
        header("Location: ../view/register.php?error=Email sudah terdaftar. Silakan gunakan email lain.");
        mysqli_stmt_close($stmt_check);
        exit();
    }
    mysqli_stmt_close($stmt_check);

    // Memulai Transaksi (Penting agar kedua INSERT berhasil, atau gagal semua)
    mysqli_begin_transaction($conn);
    $success = true;

    try {
        // --- QUERY 1: INSERT ke tabel 'user' ---
        $insert_user_sql = "INSERT INTO user (nm_user, no_hp, email) VALUES (?, ?, ?)";
        $stmt_user = mysqli_prepare($conn, $insert_user_sql);
        mysqli_stmt_bind_param($stmt_user, "sss", $fullname, $no_hp, $email);
        
        if (!mysqli_stmt_execute($stmt_user)) {
            $success = false;
        }

        // Ambil ID yang baru saja dibuat (LAST_INSERT_ID)
        $id_user_baru = mysqli_insert_id($conn);
        mysqli_stmt_close($stmt_user);

        // --- QUERY 2: INSERT ke tabel 'akun' ---
        if ($success) {
            $insert_akun_sql = "INSERT INTO akun (id_user, username, password, role) VALUES (?, ?, ?, ?)";
            $stmt_akun = mysqli_prepare($conn, $insert_akun_sql);
            // Catatan: 'username' di tabel akun diisi dengan Email
            mysqli_stmt_bind_param($stmt_akun, "isss", $id_user_baru, $email, $hashed_password, $role);
            
            if (!mysqli_stmt_execute($stmt_akun)) {
                $success = false;
            }
            mysqli_stmt_close($stmt_akun);
        }

        // Keputusan Transaksi
        if ($success) {
            mysqli_commit($conn); // Simpan kedua data
            header("Location: ../view/login.php?success=Pendaftaran berhasil, silakan masuk.");
        } else {
            mysqli_rollback($conn); // Batalkan semua jika ada yang gagal
            header("Location: ../view/register.php?error=Gagal menyimpan akun (Error DB).");
        }

    } catch (Exception $e) {
        mysqli_rollback($conn);
        header("Location: ../view/register.php?error=Terjadi kesalahan sistem: " . $e->getMessage());
    }

    mysqli_close($conn);

} else {
    // Jika diakses tanpa submit form
    header("Location: ../view/register.php");
}
exit();
?>