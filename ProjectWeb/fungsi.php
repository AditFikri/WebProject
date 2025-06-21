<?php
// fungsi.php

// Buat slug dari teks (judul/kategori)
function buat_slug($text) {
    $text = strtolower(trim($text));
    $text = preg_replace('/[^a-z0-9-]+/', '-', $text);
    $text = trim($text, '-');
    return $text;
}

// Format tanggal dalam bahasa Indonesia
function format_tanggal($tanggal) {
    $bulan = [
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];
    $pecah = explode('-', $tanggal);
    return $pecah[2] . ' ' . $bulan[(int)$pecah[1]] . ' ' . $pecah[0];
}

// Potong isi artikel untuk ringkasan
function potong_teks($teks, $panjang = 200) {
    return substr(strip_tags($teks), 0, $panjang) . '...';
}
?>
