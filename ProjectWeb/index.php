<?php
include 'koneksi.php';
include 'header.php';
include 'fungsi.php';

?>

<div class="content">

    <!-- Bagian Trending -->
    <div class="box">
    <section class="trending-section">
        <h2>Trending</h2>
        <div class="trending-grid">
            <?php
            // Ambil 2 artikel dengan komentar terbanyak
            $trending = mysqli_query($conn, "
                SELECT a.*, COUNT(k.id) AS jumlah_komentar 
                FROM artikel a 
                LEFT JOIN komentar k ON a.id = k.id_artikel 
                GROUP BY a.id 
                ORDER BY jumlah_komentar DESC 
                LIMIT 2
            ");
            while ($row = mysqli_fetch_assoc($trending)): ?>
                <div class="trending-main">
                    <img src="images/<?= $row['gambar'] ?>" alt="<?= $row['judul'] ?>">
                    <h3><a href="artikel.php?id=<?= $row['id'] ?>"><?= $row['judul'] ?></a></h3>
                    <p><?= substr(strip_tags($row['isi']), 0, 150) ?>...</p>
                </div>
            <?php endwhile; ?>
        </div>


        <div class="trending-sublist">
            <?php
            // Ambil 4 artikel populer berikutnya
            $trending_small = mysqli_query($conn, "
                SELECT a.*, COUNT(k.id) AS jumlah_komentar 
                FROM artikel a 
                LEFT JOIN komentar k ON a.id = k.id_artikel 
                GROUP BY a.id 
                ORDER BY jumlah_komentar DESC 
                LIMIT 2, 4
            ");
            while ($row = mysqli_fetch_assoc($trending_small)): ?>
                <div class="trending-sub">
                    <img src="images/<?= $row['gambar'] ?>" alt="">
                    <div>
                        <h4><a href="artikel.php?id=<?= $row['id'] ?>"><?= $row['judul'] ?></a></h4>
                        <small><?= date('d M Y', strtotime($row['created_at'])) ?></small>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </section>

    </div>
    <!-- Bagian Artikel Terbaru -->
    <div class="box">
        <section class="latest-section">
        <h2>Artikel Terbaru</h2>
        <?php
        $latest = mysqli_query($conn, "
            SELECT a.*, k.nama AS nama_kategori 
            FROM artikel a
            LEFT JOIN kategori k ON a.id_kategori = k.id
            ORDER BY a.created_at DESC 
            LIMIT 8
        ");
        while ($row = mysqli_fetch_assoc($latest)): ?>
            <div class="latest-article">
                <img src="images/<?= $row['gambar'] ?>" alt="">
                <div>
                    <small class="kategori"><?= $row['nama_kategori'] ?></small>
                    <h3><a href="artikel.php?id=<?= $row['id'] ?>"><?= $row['judul'] ?></a></h3>
                    <p><?= substr(strip_tags($row['isi']), 0, 150) ?>...</p>
                    <small class="tanggal"><?= date('d M Y', strtotime($row['created_at'])) ?></small>
                </div>
            </div>

        <?php endwhile; ?>
        </section>
    </div>

    <!-- Bagian Komentar Terbaru -->
    <div class="box">
    <section class="comments-section">
        <h2>Komentar Terbaru</h2>
        <?php
        $komentar = mysqli_query($conn, "
            SELECT k.*, a.judul, a.gambar 
            FROM komentar k 
            JOIN artikel a ON k.id_artikel = a.id 
            ORDER BY k.created_at DESC 
            LIMIT 3
        ");
        while ($row = mysqli_fetch_assoc($komentar)): ?>
            <div class="comment-item">
                <img src="images/<?= $row['gambar'] ?>" alt="">
                <div class="comment-content">
                    <div class="judul">
                        <a href="artikel.php?id=<?= $row['id_artikel'] ?>" class="komentar-link"><?= htmlspecialchars($row['judul']) ?></a>
                    </div>
                    <div class="komentar">
                        <strong><?= htmlspecialchars($row['nama']) ?></strong>: <?= htmlspecialchars($row['komentar']) ?>
                    </div>
                    <div class="tanggal"><?= date("d M Y H:i", strtotime($row['created_at'])) ?></div>
                </div>
            </div>

        <?php endwhile; ?>
    </section>
    </div>

</div>


<?php include 'sidebar.php'; ?>
<?php include 'footer.php'; ?>
