<?php
include('koneksi.php'); // Pastikan file koneksi terhubung dengan benar

if (isset($_POST['data1'])) { // Memastikan parameter data1 dikirim dari AJAX
    $kamar = $_POST['data1'];

    // Query untuk mendapatkan data berdasarkan ID kamar
    $sql = mysqli_query($connect, "SELECT * FROM jenis_kamar WHERE id = '$kamar'");
    $jumlah_baris = mysqli_num_rows($sql);

    if ($jumlah_baris > 0) {
        $row = mysqli_fetch_assoc($sql);
        echo $row['harga']; // Pastikan kolom harga sudah ada dan sesuai
    } else {
        echo "Data tidak ditemukan";
    }
} else {
    echo "Parameter tidak valid";
}
?>
