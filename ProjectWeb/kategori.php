<?php
include 'koneksi.php';
include 'header.php';
include 'fungsi.php';

?>

<div class="content">
    <?php
    // Ambil nama kategori dari parameter URL
    if (isset($_GET['kategori'])) {
        $kategori = mysqli_real_escape_string($conn, $_GET['kategori']);

        // Dapatkan ID kategori dari nama slug
        $getKategori = mysqli_query($conn, "SELECT * FROM kategori WHERE slug = '$kategori'");
        if (mysqli_num_rows($getKategori) > 0) {
            $kat = mysqli_fetch_assoc($getKategori);
            $kategori_id = $kat['id'];

            echo "<h2>Artikel Kategori: " . htmlspecialchars($kat['nama']) . "</h2>";

            // Ambil semua artikel berdasarkan kategori ID
            $query = "SELECT * FROM artikel 
                  WHERE id_kategori = $kategori_id 
                  ORDER BY created_at DESC";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0):
                while ($row = mysqli_fetch_assoc($result)):
                    ?>
                    <div class="box" style="margin-bottom: 20px;">
                        <?php if (!empty($row['gambar'])): ?>
                            <img src="images/<?= $row['gambar'] ?>" alt="<?= $row['judul'] ?>" style="max-width:100%; height:auto;">
                        <?php endif; ?>
                        <h3><a href="artikel.php?id=<?= $row['id'] ?>"><?= $row['judul'] ?></a></h3>
                        <small><i>Tanggal: <?= date('d M Y', strtotime($row['created_at'])) ?></i></small>
                        <p><?= substr(strip_tags($row['isi']), 0, 200) ?>...</p>
                        <a href="artikel.php?id=<?= $row['id'] ?>">[Baca Selengkapnya]</a>
                    </div>
                <?php
                endwhile;
            else:
                echo "<p>Belum ada artikel dalam kategori ini.</p>";
            endif;
        } else {
            echo "<p>Kategori tidak ditemukan.</p>";
        }
    } else {
        echo "<p>Kategori tidak ditentukan.</p>";
    }
    ?>
</div>

<?php include 'sidebar.php'; ?>
<?php include 'footer.php'; ?>
