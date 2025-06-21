
<?php
session_start(); // HARUS PALING ATAS SEBELUM APAPUN

include 'koneksi.php';
include 'fungsi.php';

if (!isset($_SESSION['recent_views'])) {
    $_SESSION['recent_views'] = [];
}


$id = intval($_GET['id']);
$_SESSION['recent_views'][] = $id;
$_SESSION['recent_views'] = array_slice(array_unique($_SESSION['recent_views']), -10);

// Cek parameter ID
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Simpan komentar
if (isset($_POST['kirim_komentar'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $komentar = mysqli_real_escape_string($conn, $_POST['komentar']);

    if (!empty($nama) && !empty($komentar)) {
        $sql = "INSERT INTO komentar (id_artikel, nama, komentar, created_at)
                VALUES ($id, '$nama', '$komentar', NOW())";
        mysqli_query($conn, $sql);
        header("Location: artikel.php?id=$id#komentar");
        exit;
    } else {
        $error = "Nama dan komentar tidak boleh kosong.";
    }
}

include 'header.php';
?>

<div class="content">
    <?php
    // Ambil ID artikel dari parameter URL
    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);

        $query = "SELECT artikel.*, kategori.nama AS nama_kategori, users.nama AS penulis 
              FROM artikel 
              LEFT JOIN kategori ON artikel.id_kategori = kategori.id 
              LEFT JOIN users ON artikel.id_user = users.id 
              WHERE artikel.id = $id";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0):
            $row = mysqli_fetch_assoc($result);
            ?>
            <h2><?= $row['judul'] ?></h2>
            <small>
                <i>Kategori: <?= $row['nama_kategori'] ?> |
                    Oleh: <?= $row['penulis'] ?> |
                    Tanggal: <?= date('d M Y', strtotime($row['created_at'])) ?></i>
            </small>

            <?php if (!empty($row['gambar'])): ?>
            <img src="images/<?= $row['gambar'] ?>" alt="<?= $row['judul'] ?>" style="max-width:100%; margin-top:15px;">
        <?php endif; ?>

            <div style="margin-top: 20px;">
                <?= nl2br($row['isi']) ?>
            </div>
            <hr id="komentar">
            <h3>Tinggalkan Komentar</h3>
            <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

            <form method="post">
                <input type="text" name="nama" placeholder="Nama Anda" style="width: 100%; padding: 10px; margin-bottom: 10px;" required>
                <textarea name="komentar" placeholder="Tulis komentar..." rows="5" style="width: 100%; padding: 10px;" required></textarea>
                <button type="submit" name="kirim_komentar" style="margin-top: 10px; padding: 10px 15px; background: #111; color: white; border: none;">Kirim</button>
            </form>

            <br><h3>Komentar:</h3>
            <?php
            $komen = mysqli_query($conn, "SELECT * FROM komentar WHERE id_artikel = $id ORDER BY created_at DESC");
            if (mysqli_num_rows($komen) == 0) {
                echo "<p>Belum ada komentar.</p>";
            } else {
                while ($k = mysqli_fetch_assoc($komen)) {
                    echo "<div style='margin-bottom: 15px; padding: 10px; background: #eee; border-radius: 5px;'>
                <strong>" . htmlspecialchars($k['nama']) . "</strong><br>
                <small><i>" . date("d M Y H:i", strtotime($k['created_at'])) . "</i></small>
                <p>" . nl2br(htmlspecialchars($k['komentar'])) . "</p>
              </div>";
                }
            }
            ?>

        <?php
        else:
            echo "<p>Artikel tidak ditemukan.</p>";
        endif;
    } else {
        echo "<p>ID artikel tidak diberikan.</p>";
    }
    ?>
</div>

<?php include 'sidebar.php'; ?>
<?php include 'footer.php'; ?>
