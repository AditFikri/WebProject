<?php
// koneksi.php
$host = "localhost";
$user = "root";
$pass = "agrinet46";
$db   = "db_blogwisata";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
