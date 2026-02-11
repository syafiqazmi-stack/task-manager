<?php
session_start();
include "../config/connection.php";

/* CEK LOGIN */
if (!isset($_SESSION['login'])) {
    header("Location: ../index.php");
    exit;
}

/* HANYA ADMIN BOLEH TAMBAH */
if ($_SESSION['role'] !== 'admin') {
    header("Location: ../dashboard.php");
    exit;
}

if (isset($_POST['simpan'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $sql = "INSERT INTO tasks (title, description, status)
            VALUES ('$title', '$description', 'Pending')";

    if (mysqli_query($conn, $sql)) {
        header("Location: ../dashboard.php");
        exit;
    } else {
        $error = "Gagal menambah task: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Task</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background:#f4f6f9; min-height:100vh;">

<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="col-md-6">

        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h4 class="fw-bold mb-3">➕ Tambah Task</h4>

                <?php if (isset($error)) { ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php } ?>

                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Judul Task</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description" class="form-control" rows="4" required></textarea>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="../dashboard.php" class="btn btn-secondary">Kembali</a>
                        <button type="submit" name="simpan" class="btn btn-success">
                            Simpan Task
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

</body>
</html>
