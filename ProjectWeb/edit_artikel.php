<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
include 'koneksi.php';
include 'fungsi.php';


// Validasi ID artikel
if (!isset($_GET['id'])) {
    header("Location: artikel_admin.php");
    exit;
}

$id = intval($_GET['id']);
$result = mysqli_query($conn, "SELECT * FROM artikel WHERE id = $id");
if (mysqli_num_rows($result) !== 1) {
    echo "Artikel tidak ditemukan.";
    exit;
}
$artikel = mysqli_fetch_assoc($result);

if (isset($_POST['update'])) {
    $judul    = mysqli_real_escape_string($conn, $_POST['judul']);
    $isi      = mysqli_real_escape_string($conn, $_POST['isi']);
    $kategori = intval($_POST['kategori']);
    $slug     = buat_slug($judul);
    $gambar   = $artikel['gambar'];

    if ($_FILES['gambar']['name']) {
        $file_name = $_FILES['gambar']['name'];
        $tmp_name = $_FILES['gambar']['tmp_name'];
        $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($ext, $allowed)) {
            $new_name = uniqid() . '.' . $ext;
            move_uploaded_file($tmp_name, 'images/' . $new_name);
            if (!empty($gambar) && file_exists("images/$gambar")) {
                unlink("images/$gambar");
            }
            $gambar = $new_name;
        } else {
            $error = "Format gambar tidak valid.";
        }
    }

    if (!isset($error)) {
        $query = "UPDATE artikel 
                  SET judul='$judul', slug='$slug', isi='$isi', id_kategori=$kategori, gambar='$gambar' 
                  WHERE id=$id";
        if (mysqli_query($conn, $query)) {
            header("Location: artikel_admin.php");
            exit;
        } else {
            $error = "Gagal memperbarui artikel.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Artikel</title>
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

        .thumbnail {
            display: block;
            max-width: 100%;
            margin: 10px 0;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<header>
    <h2>Edit Artikel</h2>
</header>

<div class="container">
    <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>
    <form method="post" enctype="multipart/form-data">
        <label>Judul Artikel</label>
        <input type="text" name="judul" value="<?= htmlspecialchars($artikel['judul']) ?>" required>

        <label>Kategori</label>
        <select name="kategori" required>
            <option value="">-- Pilih Kategori --</option>
            <?php
            $kategori = mysqli_query($conn, "SELECT * FROM kategori ORDER BY nama ASC");
            while ($k = mysqli_fetch_assoc($kategori)) {
                $selected = ($k['id'] == $artikel['id_kategori']) ? 'selected' : '';
                echo "<option value='{$k['id']}' $selected>{$k['nama']}</option>";
            }
            ?>
        </select>

        <label>Gambar Saat Ini</label>
        <?php if ($artikel['gambar']): ?>
            <img src="images/<?= $artikel['gambar'] ?>" class="thumbnail">
        <?php else: ?>
            <p>(Tidak ada gambar)</p>
        <?php endif; ?>

        <label>Ganti Gambar (opsional)</label>
        <input type="file" name="gambar">

        <div style="margin-top: 15px;"></div>

        <label>Isi Artikel</label>
        <textarea name="isi" rows="8" required><?= htmlspecialchars($artikel['isi']) ?></textarea>

        <button type="submit" name="update">Update</button>
        <a href="artikel_admin.php" style="margin-left: 10px;">Batal</a>
    </form>
</div>

</body>
</html>

