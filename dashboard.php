<?php
session_start();
include "config/connection.php";

/* CEK LOGIN (INI KUNCI) */
if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}

$username = $_SESSION['username'];
$role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | Task Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background:#f4f6f9; min-height:100vh;"><?php
session_start();
include "config/connection.php";

/* CEK LOGIN */
if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}

$username = $_SESSION['username'];
$role = $_SESSION['role'];

/* STATISTIK */
$total     = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) total FROM tasks"))['total'];
$pending   = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) total FROM tasks WHERE status='Pending'"))['total'];
$completed = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) total FROM tasks WHERE status='Completed'"))['total'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | Task Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background:#f4f6f9; min-height:100vh;">

<!-- NAVBAR -->
<nav class="navbar navbar-dark bg-dark px-4">
    <span class="navbar-brand fw-bold">📝 Task Manager</span>
    <span class="text-white">
        <?= $username ?> (<?= $role ?>) |
        <a href="logout.php" class="text-warning text-decoration-none">Logout</a>
    </span>
</nav>

<div class="container-fluid">
<div class="row">

<!-- SIDEBAR -->
<div class="col-md-2 bg-white border-end min-vh-100 p-3">
    <h6 class="fw-bold text-secondary mb-3">MENU</h6>

    <a href="dashboard.php" class="d-block mb-2 text-dark text-decoration-none fw-semibold">
        📋 Dashboard
    </a>

    <?php if ($role === 'admin') { ?>
        <a href="tasks/add.php" class="d-block mb-2 text-dark text-decoration-none fw-semibold">
            ➕ Tambah Task
        </a>
    <?php } ?>

    <hr>

    <a href="logout.php" class="d-block text-danger text-decoration-none fw-semibold">
        🚪 Logout
    </a>
</div>

<!-- CONTENT -->
<div class="col-md-10 p-4">

<h3 class="fw-bold mb-4">Dashboard Statistik</h3>

<!-- STAT BOX -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <h6 class="text-muted">Total Task</h6>
                <h2 class="fw-bold"><?= $total ?></h2>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <h6 class="text-muted">Pending</h6>
                <h2 class="fw-bold text-warning"><?= $pending ?></h2>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <h6 class="text-muted">Completed</h6>
                <h2 class="fw-bold text-success"><?= $completed ?></h2>
            </div>
        </div>
    </div>
</div>

<!-- TABLE -->
<div class="card shadow-sm">
<div class="card-body table-responsive">

<table class="table table-hover align-middle">
<thead class="table-light">
<tr>
    <th>Judul</th>
    <th>Deskripsi</th>
    <th>Status</th>
    <th width="260">Aksi</th>
</tr>
</thead>

<tbody>
<?php
$data = mysqli_query($conn, "SELECT * FROM tasks ORDER BY id DESC");
while ($t = mysqli_fetch_assoc($data)) {
?>
<tr>
    <td class="fw-semibold"><?= $t['title'] ?></td>
    <td><?= $t['description'] ?></td>
    <td>
        <?php if ($t['status'] === 'Completed') { ?>
            <span class="badge bg-success">Completed</span>
        <?php } else { ?>
            <span class="badge bg-warning text-dark">Pending</span>
        <?php } ?>
    </td>
    <td>
        <?php if ($role === 'admin') { ?>
            <a href="tasks/edit.php?id=<?= $t['id'] ?>" class="btn btn-sm btn-outline-primary">Edit</a>
            <a href="tasks/delete.php?id=<?= $t['id'] ?>" class="btn btn-sm btn-outline-danger"
               onclick="return confirm('Hapus task ini?')">Hapus</a>
        <?php } ?>

        <?php if ($t['status'] === 'Pending') { ?>
            <a href="tasks/status.php?id=<?= $t['id'] ?>" class="btn btn-sm btn-outline-success">
                Selesai
            </a>
        <?php } ?>
    </td>
</tr>
<?php } ?>
</tbody>

</table>

</div>
</div>

</div>
</div>
</div>

</body>
</html>
 

<!-- NAVBAR -->
<nav class="navbar navbar-dark bg-dark px-4">
    <span class="navbar-brand fw-bold">📝 Task Manager</span>
    <span class="text-white">
        <?= $username ?> (<?= $role ?>) |
        <a href="logout.php" class="text-warning text-decoration-none">Logout</a>
    </span>
</nav>

<div class="container-fluid">
<div class="row">

<!-- SIDEBAR -->
<div class="col-md-2 bg-white border-end min-vh-100 p-3">
    <h6 class="fw-bold text-secondary mb-3">MENU</h6>

    <a href="dashboard.php" class="d-block mb-2 text-dark text-decoration-none fw-semibold">
        📋 Dashboard
    </a>

    <?php if ($role === 'admin') { ?>
        <a href="tasks/add.php" class="d-block mb-2 text-dark text-decoration-none fw-semibold">
            ➕ Tambah Task
        </a>
    <?php } ?>

    <hr>

    <a href="logout.php" class="d-block text-danger text-decoration-none fw-semibold">
        🚪 Logout
    </a>
</div>

<!-- CONTENT -->
<div class="col-md-10 p-4">

<h3 class="fw-bold mb-3">Daftar Tugas</h3>

<div class="card shadow-sm">
<div class="card-body table-responsive">

<table class="table table-striped table-hover align-middle">
<thead class="table-light">
<tr>
    <th>Judul</th>
    <th>Deskripsi</th>
    <th>Status</th>
    <th width="260">Aksi</th>
</tr>
</thead>

<tbody>
<?php
$data = mysqli_query($conn, "SELECT * FROM tasks ORDER BY id DESC");
while ($t = mysqli_fetch_assoc($data)) {
?>
<tr>
    <td class="fw-semibold"><?= $t['title'] ?></td>
    <td><?= $t['description'] ?></td>
    <td>
        <?php if ($t['status'] === 'Completed') { ?>
            <span class="badge bg-success">Completed</span>
        <?php } else { ?>
            <span class="badge bg-warning text-dark">Pending</span>
        <?php } ?>
    </td>
    <td>
        <?php if ($role === 'admin') { ?>
            <a href="tasks/edit.php?id=<?= $t['id'] ?>" class="btn btn-sm btn-outline-primary">Edit</a>
            <a href="tasks/delete.php?id=<?= $t['id'] ?>" class="btn btn-sm btn-outline-danger"
               onclick="return confirm('Hapus task ini?')">Hapus</a>
        <?php } ?>

        <?php if ($t['status'] === 'Pending') { ?>
            <a href="tasks/status.php?id=<?= $t['id'] ?>" class="btn btn-sm btn-outline-success">
                Selesai
            </a>
        <?php } ?>
    </td>
</tr>
<?php } ?>
</tbody>

</table>

</div>
</div>

</div>
</div>
</div>

</body>
</html>
