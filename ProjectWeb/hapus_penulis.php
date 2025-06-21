<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

include 'koneksi.php';

// Pastikan ada ID penulis yang dikirim
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Cegah user menghapus dirinya sendiri (opsional)
    if ($_SESSION['user_id'] == $id) {
        echo "Anda tidak dapat menghapus akun Anda sendiri!";
        exit;
    }

    $query = "DELETE FROM users WHERE id = $id";

    if (mysqli_query($conn, $query)) {
        header("Location: penulis.php");
        exit;
    } else {
        echo "Gagal menghapus penulis.";
    }
} else {
    header("Location: penulis.php");
    exit;
}
?>
