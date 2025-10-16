<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=">
  <title>Register</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    

  <div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card shadow p-4" style="width: 28rem; border-radius: 1rem;">
      <h3 class="text-center mb-4">Register</h3>
      <form action="register.php" method="POST">
        <div class="mb-3">
          <label for="fullname" class="form-label">Nama Lengkap</label>
          <input type="text" class="form-control" id="fullname" name="fullname" required>
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email address</label>
          <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="mb-3">
          <label for="confirm" class="form-label">Konfirmasi Password</label>
          <input type="password" class="form-control" id="confirm" name="confirm" required>
        </div>
        <button type="submit" class="btn btn-success w-100">Register</button>
      </form>
      <p class="text-center mt-3 mb-0">
        Sudah punya akun? <a href="login.php" class="text-decoration-none">Login di sini</a>
      </p>
    </div>
  </div>

</body>
</html>
