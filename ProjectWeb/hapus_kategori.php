<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Optional: Cek apakah ada artikel yang masih pakai kategori ini
    $cek = mysqli_query($conn, "SELECT * FROM artikel WHERE id_kategori = $id");
    if (mysqli_num_rows($cek) > 0) {
        echo "Tidak bisa menghapus kategori. Masih ada artikel yang menggunakan kategori ini.";
        exit;
    }

    $query = "DELETE FROM kategori WHERE id = $id";

    if (mysqli_query($conn, $query)) {
        header("Location: kategori_admin.php");
        exit;
    } else {
        echo "Gagal menghapus kategori.";
    }
} else {
    header("Location: kategori_admin.php");
    exit;
}
?>
