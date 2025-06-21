<?php
include 'koneksi.php';
include 'header.php';
include 'fungsi.php';

?>

<div class="content">
    <h2>Hasil Pencarian</h2>
    <?php
    if (isset($_GET['q'])) {
        $keyword = mysqli_real_escape_string($conn, $_GET['q']);

        $query = "SELECT * FROM artikel 
              WHERE judul LIKE '%$keyword%' 
              OR isi LIKE '%$keyword%' 
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
            echo "<p>Tidak ada artikel yang cocok dengan kata kunci: <strong>" . htmlspecialchars($keyword) . "</strong></p>";
        endif;
    } else {
        echo "<p>Tidak ada kata kunci pencarian.</p>";
    }
    ?>
</div>

<?php include 'sidebar.php'; ?>
<?php include 'footer.php'; ?>
