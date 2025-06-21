<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
include 'koneksi.php';
include 'fungsi.php';

if (isset($_POST['simpan'])) {
    $judul     = mysqli_real_escape_string($conn, $_POST['judul']);
    $isi       = mysqli_real_escape_string($conn, $_POST['isi']);
    $id_kat    = intval($_POST['kategori']);
    $id_user   = $_SESSION['user_id'];
    $slug      = buat_slug($judul);
    $gambar    = '';

    // Upload gambar
    if ($_FILES['gambar']['name']) {
        $file_name = $_FILES['gambar']['name'];
        $tmp_name = $_FILES['gambar']['tmp_name'];
        $upload_dir = "images/";

        $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($ext, $allowed)) {
            $gambar = uniqid() . '.' . $ext;
            move_uploaded_file($tmp_name, $upload_dir . $gambar);
        } else {
            $error = "Format gambar tidak didukung.";
        }
    }

    if (!isset($error)) {
        $query = "INSERT INTO artikel (judul, slug, isi, gambar, id_kategori, id_user) 
                  VALUES ('$judul', '$slug', '$isi', '$gambar', $id_kat, $id_user)";
        if (mysqli_query($conn, $query)) {
            header("Location: artikel_admin.php");
            exit;
        } else {
            $error = "Gagal menambahkan artikel.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Artikel</title>
    <style>
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
            width: 600px;
            margin: auto;
            border-radius: 5px;
        }

        input[type="text"], textarea, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        input[type="file"] {
            width: 100%;
            padding: 10px;
            background-color: #222;
            color: white;
            border: none;
            border-radius: 5px;
            font-family: inherit;
            cursor: pointer;
            margin-bottom: 15px;
        }

        input[type="file"]::file-selector-button {
            background: #111;
            color: white;
            border: none;
            padding: 8px 12px;
            margin-right: 10px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }

        input[type="file"]::file-selector-button:hover {
            background-color: #444;
        }

        textarea {
            resize: vertical;
        }

        button {
            padding: 10px 15px;
            background: #111;
            color: white;
            border: none;
            font-weight: bold;
            cursor: pointer;
        }

        .error {
            color: red;
            margin-bottom: 15px;
        }

        .form-actions {
            margin-top: 20px;
        }
    </style>

</head>
<body>

<header>
    <h2>Tambah Artikel</h2>
</header>

<div class="container">
    <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>
    <form method="post" enctype="multipart/form-data">
        <label>Judul Artikel</label>
        <input type="text" name="judul" required>

        <label>Kategori</label>
        <select name="kategori" required>
            <option value="">-- Pilih Kategori --</option>
            <?php
            $kategori = mysqli_query($conn, "SELECT * FROM kategori ORDER BY nama ASC");
            while ($k = mysqli_fetch_assoc($kategori)) {
                echo "<option value='{$k['id']}'>{$k['nama']}</option>";
            }
            ?>
        </select>

        <label>Gambar (opsional)</label>
        <input type="file" name="gambar">

        <br><br> <!-- jarak antar elemen -->

        <label>Isi Artikel</label>
        <textarea name="isi" rows="8" required></textarea>


        <button type="submit" name="simpan">Simpan</button>
        <a href="artikel_admin.php" style="margin-left: 10px;">Batal</a>
    </form>
</div>

</body>
</html>
