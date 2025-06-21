<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
include 'koneksi.php';
include 'fungsi.php';

// Validasi ID kategori
if (!isset($_GET['id'])) {
    header("Location: kategori_admin.php");
    exit;
}

$id = intval($_GET['id']);
$result = mysqli_query($conn, "SELECT * FROM kategori WHERE id = $id");

if (mysqli_num_rows($result) !== 1) {
    echo "Kategori tidak ditemukan.";
    exit;
}

$kategori = mysqli_fetch_assoc($result);

// Jika form disubmit
if (isset($_POST['update'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $slug = buat_slug($nama);

    // Cek slug unik kecuali untuk dirinya sendiri
    $cek = mysqli_query($conn, "SELECT * FROM kategori WHERE slug='$slug' AND id != $id");
    if (mysqli_num_rows($cek) > 0) {
        $error = "Slug kategori sudah digunakan oleh kategori lain.";
    } else {
        $query = "UPDATE kategori SET nama='$nama', slug='$slug' WHERE id=$id";
        if (mysqli_query($conn, $query)) {
            header("Location: kategori_admin.php");
            exit;
        } else {
            $error = "Gagal memperbarui kategori.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Kategori</title>
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
    <h2>Edit Kategori</h2>
</header>

<div class="container">
    <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>
    <form method="post">
        <label>Nama Kategori</label>
        <input type="text" name="nama" value="<?= htmlspecialchars($kategori['nama']) ?>" required>

        <button type="submit" name="update">Update</button>
        <a href="kategori_admin.php" style="margin-left: 10px;">Batal</a>
    </form>
</div>

</body>
</html>
