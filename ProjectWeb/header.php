
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Blog Wisata</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        header {
            background-color: #111;
            color: white;
            padding: 20px 0;
            text-align: center;
        }
        nav {
            background-color: #222;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }
        .nav-left {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        .nav-left a,
        .nav-right a {
            color: #ccc;
            text-decoration: none;
            padding: 14px 16px;
            display: block;
            font-weight: bold;
        }
        .nav-left a:hover {
            background-color: #444;
            color: white;
        }
        .nav-right a {
            background-color: #f44336;
            color: white;
            border-radius: 5px;
            margin-left: auto;
            transition: background-color 0.2s ease;
        }
        .nav-right a:hover {
            background-color: #b71c1c;
        }
        .container {
            display: flex;
            padding: 20px;
            max-width: 1200px;
            margin: auto;
        }
        .content {
            flex: 3;
            padding: 20px;

        }
        .sidebar {
            flex: 1;
            padding: 20px;
            margin-left: 20px;
        }
        footer {
            background-color: #111;
            color: white;
            text-align: center;
            padding: 15px 0;
            margin-top: 40px;
        }
        nav {
            background-color: #222;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        .nav-left {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }

        .nav-left a {
            color: #ccc;
            text-decoration: none;
            padding: 14px 12px;
            font-weight: bold;
        }

        .nav-left a:hover {
            background-color: #444;
            color: white;
        }

        .nav-left .separator {
            color: #666;
            margin: 0 5px;
            font-weight: bold;
        }

        .nav-left .label {
            color: #999;
            font-style: italic;
            margin-right: 10px;
        }

        .nav-right a.admin-btn {
            background-color: #f44336;
            color: white;
            padding: 8px 14px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            transition: background 0.2s ease;
        }

        .nav-right a.admin-btn:hover {
            background-color: #b71c1c;
        }
        .trending-section, .latest-section, .comments-section {
            margin-bottom: 40px;
        }

        .trending-grid {
            display: flex;
            gap: 20px;
        }

        .trending-main img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 5px;
        }

        .trending-sublist {
            display: flex;
            gap: 20px;
            margin-top: 20px;
        }

        .trending-sub {
            display: flex;
            gap: 10px;
            width: 100%;
            max-width: 220px;
        }

        .trending-sub img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 5px;
        }

        .latest-article {
            display: flex;
            gap: 12px;
            margin-bottom: 18px;
            padding-bottom: 12px;
            border-bottom: 1px solid #ddd;
        }

        .latest-article img {
            width: 120px;
            height: 150px;
            object-fit: cover;
            border-radius: 4px;
            flex-shrink: 0;
        }
        h3 a {
            color: #111;
            text-decoration: none;
        }

        h3 a:visited {
            color: #111;
        }

        .latest-article small {
            color: #ff5722; /* Biru, bisa diganti sesuai selera */
            font-weight: bold;
            display: inline-block;
            margin-bottom: 5px;
        }


        .comment-item {
            display: flex;
            gap: 15px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 15px;
            margin-bottom: 15px;
        }

        .comment-item img {
            width: 80px;
            height: 60px;
            object-fit: cover;
            border-radius: 5px;
        }

        .komentar-link {
            color: #111 !important;
            text-decoration: none;
        }
        .komentar-link:hover {
            text-decoration: underline;
        }

        .marquee-container {
            background: #111;
            overflow: hidden;
            white-space: nowrap;
            padding: 10px 0;
            border-top: 1px solid #333;
        }

        .marquee-content {
            display: inline-block;
            animation: marquee 75s linear infinite;
            font-size: 14px;
            color: white;
            padding-left: 100%;
        }

        .marquee-content a {
            color: #ffc107;
            margin-right: 30px;
            text-decoration: none;
            font-weight: bold;
        }

        .marquee-content a:hover {
            text-decoration: underline;
        }

        @keyframes marquee {
            0% { transform: translateX(0%); }
            100% { transform: translateX(-100%); }
        }

        .ticker-wrapper {
            overflow: hidden;
            background: #f4f4f4;
            border-top: 1px solid #ddd;
            border-bottom: 1px solid #ddd;
            padding: 15px 0; /* Lebih tinggi */
        }

        .ticker-track {
            display: flex;
            animation: scrollTicker 180s linear infinite;
            animation-play-state: paused; /* awalnya tidak jalan */
            width: max-content;
            gap: 40px; /* spasi antar item */
            will-change: transform;
        }

        .ticker {
            display: flex;
            margin-right: 50px; /* Jarak antara duplikat loop */
        }

        .ticker-item {
            display: flex;
            flex-direction: row;
            gap: 12px;
            width: 300px; /* lebih lebar */
            align-items: flex-start;
            text-decoration: none;
            color: #111;
            font-size: 15px;
            background: #fff;
            padding: 12px 14px; /* Tambahkan padding agar isi tidak mepet ke tepi */
            margin: 0 10px;      /* Tambahkan jarak antar item */
            border-radius: 6px;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
        }

        .ticker-item img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 6px;
        }

        .ticker-item .judul {
            font-weight: bold;
            line-height: 1.3;
            max-height: 3.6em; /* 2-3 baris */
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
        }

        .ticker-item .tanggal {
            font-size: 12px;
            color: #777;
            margin-top: 5px;
        }

        /* Animasi */
        @keyframes scrollTicker {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); } /* bukan -100% agar loop terlihat mulus */
        }
        .trending-section {
            margin-bottom: 40px;
        }

        .trending-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .trending-grid {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .trending-grid .big-item {
            flex: 1;
        }

        .trending-grid .big-item img {
            width: 100%;
            height: auto;
            border-radius: 5px;
        }
        .latest-article h3 a {
            color: #111;
            text-decoration: none;
        }

        .latest-article h3 a:hover {
            color: #f44336;
        }

        .latest-article .tanggal {
            font-size: 12px;
            color: #777;
            margin-top: 6px;
            display: inline-block;
        }
        .latest-article h3 {
            margin: 0;
            line-height: 1.3;
        }

        .latest-article p {
            margin: 3px 0 6px;
            line-height: 1.4;
        }

        .latest-article small.kategori,
        .latest-article .tanggal {
            line-height: 1.2;
            margin: 0;
        }

        .trending-main h3 a {
            color: #111;
            text-decoration: none;
        }

        .trending-main h3 a:hover {
            color: #f44336; /* atau warna hover sesuai selera */
        }

        .trending-grid .big-item h3 {
            font-size: 18px;
            margin-top: 10px;
        }

        .trending-grid .big-item p {
            font-size: 14px;
            color: #333;
        }

        /* Bagian artikel kecil di bawah trending */
        .trending-small-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .trending-small-item {
            width: 23%;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .trending-small-item img {
            width: 100%;
            height: auto;
            border-radius: 5px;
            margin-bottom: 8px;
        }

        .box {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }

        .trending-sub h4 {
            font-size: 13px;
            margin: 0;
            line-height: 1.3;
            display: -webkit-box;
            -webkit-line-clamp: 3;        /* Batasi ke 4 baris */
            -webkit-box-orient: vertical;
            overflow: hidden;
        }


        .trending-sub h4 a {
            color: #111 !important;  /* Warna hitam */
            text-decoration: none;
        }

        .trending-sub h4 a:hover {
            text-decoration: underline;
        }


        .trending-small-item .tanggal {
            font-size: 12px;
            color: #777;
            margin-top: 4px;
        }

        .comment-item {
            display: flex;
            gap: 12px;
            margin-bottom: 12px;
            padding-bottom: 10px;
            border-bottom: 1px solid #ddd;
        }

        .comment-item img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 5px;
        }

        .comment-content {
            flex: 1;
            line-height: 1.4;
        }

        .comment-content .judul {
            font-weight: bold;
            color: #111;
            margin-bottom: 2px;
            max-height: 1.3em;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .comment-content .komentar {
            font-size: 14px;
            color: #222;
            margin-bottom: 3px;
        }

        .comment-content .komentar strong {
            font-weight: bold;
        }

        .comment-content .tanggal {
            font-size: 12px;
            color: #888;
        }

    </style>
</head>

<header>
    <h1>Blog Wisata</h1>
    <p>Eksplorasi Tempat Indah di Indonesia</p>
</header>

<?php
error_reporting(E_ALL & ~E_NOTICE);

include_once 'koneksi.php';

?>

<nav>
    <div class="nav-left">
        <a href="index.php" class="beranda">Beranda</a>
        <span class="separator">|</span>
        <span class="label">Kategori Terpopuler:</span>
        <?php
        $nav_kategori = mysqli_query($conn, "SELECT * FROM kategori ORDER BY id ASC LIMIT 5");
        while ($row = mysqli_fetch_assoc($nav_kategori)):
            ?>
            <a href="kategori.php?kategori=<?= $row['slug'] ?>"><?= htmlspecialchars($row['nama']) ?></a>
        <?php endwhile; ?>
    </div>

    <div class="nav-right">
        <?php if (isset($_SESSION['login'])): ?>
            <a href="dashboard.php" class="admin-btn">Dashboard</a>
        <?php else: ?>
            <a href="login.php" class="admin-btn">Login Admin</a>
        <?php endif; ?>
    </div>
</nav>

<script>
    window.addEventListener('load', () => {
        const tickerTrack = document.querySelector('.ticker-track');
        tickerTrack.style.animationPlayState = 'running';
    });
</script>

<div class="ticker-wrapper">
    <div class="ticker-track">
        <div class="ticker">
            <?php
            $recent = mysqli_query($conn, "SELECT id, judul, gambar, created_at FROM artikel ORDER BY created_at DESC LIMIT 10");
            while ($r = mysqli_fetch_assoc($recent)):
                ?>
                <a href="artikel.php?id=<?= $r['id'] ?>" class="ticker-item">
                    <img src="images/<?= $r['gambar'] ?: 'default-thumb.jpg' ?>" alt="<?= htmlspecialchars($r['judul']) ?>" />
                    <div>
                        <div class="judul"><?= htmlspecialchars($r['judul']) ?></div>
                        <div class="tanggal"><?= date("d M Y", strtotime($r['created_at'])) ?></div>
                    </div>
                </a>
            <?php endwhile; ?>
        </div>

        <!-- Duplikasi untuk loop seamless -->
        <div class="ticker">
            <?php
            mysqli_data_seek($recent, 0); // kembalikan ke awal
            while ($r = mysqli_fetch_assoc($recent)):
                ?>
                <a href="artikel.php?id=<?= $r['id'] ?>" class="ticker-item">
                    <img src="images/<?= $r['gambar'] ?: 'default-thumb.jpg' ?>" alt="<?= htmlspecialchars($r['judul']) ?>" />
                    <div>
                        <div class="judul"><?= htmlspecialchars($r['judul']) ?></div>
                        <div class="tanggal"><?= date("d M Y", strtotime($r['created_at'])) ?></div>
                    </div>
                </a>
            <?php endwhile; ?>
        </div>
    </div>
</div>

<div class="container">
