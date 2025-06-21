<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
include 'koneksi.php';

// Pastikan ID tersedia di URL
if (!isset($_GET['id'])) {
    header("Location: penulis.php");
    exit;
}

$id = intval($_GET['id']);

// Ambil data user
$result = mysqli_query($conn, "SELECT * FROM users WHERE id = $id");
if (mysqli_num_rows($result) !== 1) {
    echo "Penulis tidak ditemukan.";
    exit;
}

$user = mysqli_fetch_assoc($result);

// Proses jika disubmit
if (isset($_POST['update'])) {
    $nama     = mysqli_real_escape_string($conn, $_POST['nama']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email    = mysqli_real_escape_string($conn, $_POST['email']);

    if (!empty($_POST['password'])) {
        $password = md5($_POST['password']);
        $query = "UPDATE users SET nama='$nama', username='$username', email='$email', password='$password' WHERE id=$id";
    } else {
        $query = "UPDATE users SET nama='$nama', username='$username', email='$email' WHERE id=$id";
    }

    if (mysqli_query($conn, $query)) {
        header("Location: penulis.php");
        exit;
    } else {
        $error = "Gagal memperbarui data.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Penulis</title>
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
    <h2>Edit Penulis</h2>
</header>

<div class="container">
    <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>
    <form method="post">
        <label>Nama Lengkap</label>
        <input type="text" name="nama" value="<?= htmlspecialchars($user['nama']) ?>" required>

        <label>Username</label>
        <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>

        <label>Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>">

        <label>Password (kosongkan jika tidak diubah)</label>
        <input type="password" name="password">

        <button type="submit" name="update">Update</button>
        <a href="penulis.php" style="margin-left: 10px;">Batal</a>
    </form>
</div>

</body>
</html>
