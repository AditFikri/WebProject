<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
include 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
        }
        header {
            background: #111;
            color: white;
            padding: 20px;
            text-align: center;
        }
        nav {
            background: #222;
            padding: 10px;
            text-align: center;
        }
        nav a {
            color: #ccc;
            margin: 0 10px;
            text-decoration: none;
        }
        nav a:hover {
            color: white;
        }
        .container {
            padding: 30px;
        }
        .box {
            background: white;
            padding: 20px;
            margin-bottom: 20px;
            border-left: 5px solid #111;
        }
    </style>
</head>
<body>

<header>
    <h1>Dashboard Admin</h1>
    <p>Selamat datang, <?= $_SESSION['username']; ?> |
        <a href="logout.php" style="color: #f44336;">Logout</a> |
        <a href="index.php" style="color: #ccc;">Kembali ke Beranda Artikel</a>
    </p>
</header>

<nav>
    <a href="dashboard.php">Beranda</a>
    <a href="artikel_admin.php">Kelola Artikel</a>
    <a href="kategori_admin.php">Kelola Kategori</a>
    <a href="penulis.php">Kelola Penulis</a>
</nav>

<div class="container">
    <div class="box">
        <h3>Manajemen Artikel</h3>
        <p>Tambah, edit, dan hapus artikel wisata.</p>
    </div>

    <div class="box">
        <h3>Manajemen Kategori</h3>
        <p>Atur kategori wisata seperti pantai, gunung, museum.</p>
    </div>

    <div class="box">
        <h3>Manajemen Penulis</h3>
        <p>Kelola akun penulis dan admin yang memiliki akses menulis artikel.</p>
    </div>
</div>

</body>
</html>
