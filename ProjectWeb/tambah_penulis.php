<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
include 'koneksi.php';

if (isset($_POST['simpan'])) {
    $nama     = mysqli_real_escape_string($conn, $_POST['nama']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $password = md5($_POST['password']); // nanti bisa diganti password_hash()

    $query = "INSERT INTO users (nama, username, email, password) 
              VALUES ('$nama', '$username', '$email', '$password')";

    if (mysqli_query($conn, $query)) {
        header("Location: penulis.php");
        exit;
    } else {
        $error = "Gagal menambahkan penulis.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Penulis</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial;
            background: #f4f4f4;
            margin: 0;
        }

        header {
            background: #111;
            color: white;
            padding: 20px;
            text-align: center;
        }

        .container {
            padding: 30px;
        }

        form {
            background: white;
            padding: 20px;
            width: 400px;
            margin: auto;
            border-radius: 5px;
        }

        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            font-size: 14px;
            border: 1px solid #ccc;
        }

        button {
            padding: 10px 15px;
            background: #111;
            color: white;
            border: none;
            font-weight: bold;
            cursor: pointer;
        }

        a {
            margin-left: 15px;
            text-decoration: none;
            color: purple;
        }

        .error {
            color: red;
            margin-bottom: 15px;
        }
    </style>

</head>
<body>

<header>
    <h2>Tambah Penulis</h2>
</header>

<div class="container">
    <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>
    <form method="post">
        <label>Nama Lengkap</label>
        <input type="text" name="nama" required>

        <label>Username</label>
        <input type="text" name="username" required>

        <label>Email</label>
        <input type="email" name="email">

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit" name="simpan">Simpan</button>
        <a href="penulis.php" style="margin-left: 10px;">Batal</a>
    </form>
</div>

</body>
</html>
