<?php
session_start();
include 'config/connection.php';

if (isset($_SESSION['login'])) {
    header("Location: dashboard.php");
    exit;
}

$error = "";
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
    if (mysqli_num_rows($query) === 1) {
        $user = mysqli_fetch_assoc($query);
        if (password_verify($password, $user['password'])) {
            $_SESSION['login'] = true;
            $_SESSION['role'] = $user['role'];
            $_SESSION['username'] = $user['username'];
            header("Location: dashboard.php");
            exit;
        }
    }
    $error = "Username atau password salah";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | Task Manager</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
        }
        .login-card {
            border-radius: 12px;
            box-shadow: 0 15px 30px rgba(0,0,0,.2);
        }
    </style>
</head>
<body>

<div class="container-fluid d-flex justify-content-center align-items-center min-vh-100">
    <div class="col-md-4 col-lg-3">
        <div class="card login-card p-4">
            <h3 class="text-center mb-4 fw-bold">🔐 Login</h3>

            <?php if ($error): ?>
                <div class="alert alert-danger text-center py-2">
                    <?= $error ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" required autofocus>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <button type="submit" name="login" class="btn btn-primary w-100">
                    Login
                </button>
            </form>

            <p class="text-center text-muted mt-3 mb-0" style="font-size: 13px;">
                Task Manager System
            </p>
        </div>
    </div>
</div>

</body>
</html>
