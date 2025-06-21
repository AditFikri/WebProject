<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
include 'koneksi.php';

// Pastikan ada ID artikel
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Cek apakah artikel ada
    $cek = mysqli_query($conn, "SELECT * FROM artikel WHERE id = $id");
    if (mysqli_num_rows($cek) === 1) {
        $artikel = mysqli_fetch_assoc($cek);

        // Hapus gambar jika ada
        if (!empty($artikel['gambar']) && file_exists("images/{$artikel['gambar']}")) {
            unlink("images/{$artikel['gambar']}");
        }

        // Hapus artikel dari DB
        $hapus = mysqli_query($conn, "DELETE FROM artikel WHERE id = $id");
        if ($hapus) {
            header("Location: artikel_admin.php");
            exit;
        } else {
            echo "Gagal menghapus artikel.";
        }
    } else {
        echo "Artikel tidak ditemukan.";
    }
} else {
    header("Location: artikel_admin.php");
    exit;
}
?>
