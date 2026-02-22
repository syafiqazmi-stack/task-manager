<?php
session_start();
include "../config/connection.php";

/* CEK LOGIN */
if (!isset($_SESSION['user'])) {
    header("Location: ../index.php");
    exit;
}

/* CEK ROLE (HANYA ADMIN) */
if ($_SESSION['role'] !== 'admin') {
    header("Location: ../dashboard.php");
    exit;
}

/* CEK ID */
if (!isset($_GET['id'])) {
    header("Location: ../dashboard.php");
    exit;
}

$id = (int) $_GET['id'];

/* AMBIL DATA TASK */
$query = mysqli_query($conn, "SELECT * FROM tasks WHERE id=$id");
$task = mysqli_fetch_assoc($query);

if (!$task) {
    header("Location: ../dashboard.php");
    exit;
}

/* UPDATE DATA */
if (isset($_POST['update'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $desc  = mysqli_real_escape_string($conn, $_POST['description']);
    $status = $_POST['status'];

    mysqli_query(
        $conn,
        "UPDATE tasks 
         SET title='$title', description='$desc', status='$status'
         WHERE id=$id"
    );

    header("Location: ../dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Task</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background: linear-gradient(135deg,#667eea,#764ba2); min-height:100vh;">
<div class="container d-flex justify-content-center align-items-center min-vh-100">

    <div class="card shadow-lg w-50">
        <div class="card-header bg-dark text-white fw-bold">
            ✏️ Edit Task
        </div>

        <div class="card-body">
            <form method="POST">

                <div class="mb-3">
                    <label class="form-label fw-semibold">Judul</label>
                    <input type="text" name="title" class="form-control"
                           value="<?= $task['title']; ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Deskripsi</label>
                    <textarea name="description" class="form-control" rows="4" required><?= $task['description']; ?></textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Status</label>
                    <select name="status" class="form-select">
                        <option value="Pending" <?= $task['status']=='Pending'?'selected':''; ?>>Pending</option>
                        <option value="Completed" <?= $task['status']=='Completed'?'selected':''; ?>>Completed</option>
                    </select>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="../dashboard.php" class="btn btn-secondary">
                        ← Kembali
                    </a>

                    <button type="submit" name="update" class="btn btn-primary px-4">
                        💾 Update
                    </button>
                </div>

            </form>
        </div>
    </div>

</div>
</body>
</html>
