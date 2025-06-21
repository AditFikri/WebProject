
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'koneksi.php';
?>

<style>
    .sidebar {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .sidebar-box {
        background: white;
        padding: 20px;
        border-radius: 8px;
    }

    .sidebar-box h3 {
        margin-top: 0;
    }

    .sidebar-box input[type="text"] {
        width: 100%;
        padding: 8px;
        margin-bottom: 10px;
        box-sizing: border-box;
    }

    .sidebar-box button {
        background: #111;
        color: white;
        padding: 10px;
        border: none;
        width: 100%;
        cursor: pointer;
        font-weight: bold;
    }

    .kategori-btn {
        display: block;
        background: #ddd;
        padding: 10px;
        margin-bottom: 8px;
        text-align: center;
        text-decoration: none;
        color: black;
        border-radius: 5px;
        font-weight: bold;
    }
    .recent-articles {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .recent-articles li {
        margin-bottom: 15px;
        border-bottom: 1px solid #ccc;
        padding-bottom: 10px;
    }

    .recent-articles a {
        text-decoration: none;
        color: #111;
        font-weight: bold;
    }

    .recent-articles a:hover {
        color: #555;
    }
    .recent-articles {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .recent-articles li {
        margin-bottom: 15px;
    }

    .recent-articles a {
        text-decoration: none;
        color: #111;
    }

    .recent-article-item {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .recent-article-item img {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 5px;
    }

    .recent-judul {
        font-size: 14px;
        font-weight: bold;
        line-height: 1.3em;
        max-height: 2.6em;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .recent-tanggal {
        font-size: 12px;
        color: #666;
    }
    .sidebar-box select {
        width: 100%;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
        font-size: 14px;
    }

</style>

<div class="sidebar">

    <!-- Pencarian -->
    <div class="sidebar-box">
        <h3>Pencarian</h3>
        <form action="search.php" method="GET">
            <input type="text" name="q" placeholder="Cari artikel...">
            <button type="submit">Cari</button>
        </form>
    </div>

    <!-- Filter Kategori Dropdown -->
    <div class="sidebar-box">
        <h3>Kategori</h3>
        <select onchange="if(this.value) window.location.href=this.value;" style="width:100%; padding:10px;">
            <option value="">-- Pilih Kategori --</option>
            <?php
            $kategori = mysqli_query($conn, "SELECT * FROM kategori ORDER BY nama ASC");
            while ($row = mysqli_fetch_assoc($kategori)):
                $slug = $row['slug'];
                $nama = htmlspecialchars($row['nama']);
                echo "<option value='kategori.php?kategori=$slug'>$nama</option>";
            endwhile;
            ?>
        </select>
    </div>


    <!-- Terakhir Dibaca -->
    <div class="sidebar-box">
        <h3>Terakhir Dibaca</h3>
        <ul class="recent-articles">
            <?php
            if (!empty($_SESSION['recent_views'])) {
                $ids = array_reverse($_SESSION['recent_views']);
                $idList = implode(',', array_map('intval', $ids));

                $result = mysqli_query($conn, "SELECT id, judul, gambar, created_at FROM artikel WHERE id IN ($idList)");
                $artikel_map = [];
                while ($row = mysqli_fetch_assoc($result)) {
                    $artikel_map[$row['id']] = $row;
                }

                foreach ($ids as $id) {
                    if (isset($artikel_map[$id])) {
                        $r = $artikel_map[$id];
                        ?>
                        <li>
                            <a href="artikel.php?id=<?= $r['id'] ?>">
                                <div class="recent-article-item">
                                    <img src="images/<?= $r['gambar'] ?: 'default-thumb.jpg' ?>" alt="<?= $r['judul'] ?>">
                                    <div>
                                        <div class="recent-judul"><?= htmlspecialchars($r['judul']) ?></div>
                                        <div class="recent-tanggal"><?= date("d M Y", strtotime($r['created_at'])) ?></div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <?php
                    }
                }
            } else {
                echo "<p>Belum ada artikel yang dibaca.</p>";
            }
            ?>
        </ul>
    </div>



    <!-- Tentang -->
    <div class="sidebar-box">
        <h3>Tentang</h3>
        <p>Blog Wisata adalah portal informasi seputar tempat-tempat wisata menarik di Indonesia. Temukan inspirasi perjalananmu di sini!</p>
        <p></p>
        <p>Fikri Aditya Rahman 230605110073</p>
    </div>




</div>

<!-- Tambahkan JavaScript filter kategori -->
<script>
    function filterKategori() {
        var input = document.getElementById("searchKategori");
        var filter = input.value.toLowerCase();
        var list = document.getElementById("daftarKategori").getElementsByTagName("a");

        for (var i = 0; i < list.length; i++) {
            var txt = list[i].textContent || list[i].innerText;
            list[i].style.display = txt.toLowerCase().includes(filter) ? "" : "none";
        }
    }
</script>
