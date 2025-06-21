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
    <title>Kelola Artikel</title>
    <style>
        body { font-family: Arial; background: #f4f4f4; margin: 0; }
        header { background: #111; color: white; padding: 20px; text-align: center; }
        .container { padding: 30px; }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        a.btn {
            padding: 6px 12px;
            background: #111;
            color: white;
            text-decoration: none;
            margin-right: 5px;
        }
        a.btn-danger {
            background: #f44336;
        }
    </style>
</head>
<body>

<header>
    <h2>Kelola Artikel</h2>
    <p><a href="dashboard.php" style="color: #ccc;">Kembali ke Dashboard</a></p>
</header>

<div class="container">
    <p><a href="tambah_artikel.php" class="btn">+ Tambah Artikel</a></p>

    <table>
        <tr>
            <th>No</th>
            <th>Judul</th>
            <th>Kategori</th>
            <th>Tanggal</th>
            <th>Aksi</th>
        </tr>
        <?php
        $no = 1;
        $query = "SELECT artikel.id, artikel.judul, artikel.created_at, kategori.nama AS kategori 
                  FROM artikel 
                  LEFT JOIN kategori ON artikel.id_kategori = kategori.id 
                  ORDER BY artikel.created_at DESC";
        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($result)):
            ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $row['judul'] ?></td>
                <td><?= $row['kategori'] ?? '-' ?></td>
                <td><?= date('d M Y', strtotime($row['created_at'])) ?></td>
                <td>
                    <a href="edit_artikel.php?id=<?= $row['id'] ?>" class="btn">Edit</a>
                    <a href="hapus_artikel.php?id=<?= $row['id'] ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus artikel ini?')">Hapus</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>

</body>
</html>
