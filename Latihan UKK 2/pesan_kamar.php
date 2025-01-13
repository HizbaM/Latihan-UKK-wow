<?php
require_once 'koneksi.php';

if (isset($_POST['kirim'])) {
    $nama_pemesan = $_POST['nama_pemesan'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $nomor_identitas = $_POST['nomor_identitas'];
    $id_jenis_kamar = $_POST['id_jenis_kamar'];
    $tanggal_pemesanan = $_POST['tanggal_pemesanan'];
    $durasi_pemesanan = (int)$_POST['durasi_pemesanan'];
    $breakfast = isset($_POST['breakfast']) ? 1 : 0; // 1 jika breakfast diaktifkan, 0 jika tidak.

    // Ambil harga kamar dari database berdasarkan jenis kamar yang dipilih.
    $queryHarga = "SELECT harga FROM jenis_kamar WHERE id = $id_jenis_kamar";
    $resultHarga = $connect->query($queryHarga);

    if ($resultHarga && $resultHarga->num_rows > 0) {
        $row = $resultHarga->fetch_assoc();
        $harga_kamar = $row['harga'];

        // Hitung total harga
        $total_harga = $harga_kamar * $durasi_pemesanan;

        // Tambahkan biaya breakfast jika diaktifkan
        if ($breakfast) {
            $total_harga += 80000;
        }

        // Berikan diskon 10% jika durasi pemesanan lebih dari 3 hari
        if ($durasi_pemesanan > 3) {
            $total_harga *= 0.9; // Diskon 10%
        }

        // Simpan data ke tabel pemesanan
        $queryInsert = "INSERT INTO pemesanan (nama_pemesan, jenis_kelamin, nomor_identitas, id_jenis_kamar, tanggal_pemesanan, durasi_pemesanan, breakfast)
        VALUES ('$nama_pemesan', '$jenis_kelamin', '$nomor_identitas', '$id_jenis_kamar', '$tanggal_pemesanan', $durasi_pemesanan, $breakfast)";

        if ($connect->query($queryInsert)) {
            echo "<script>
                alert('Pemesanan berhasil! Total harga: Rp" . number_format($total_harga, 0, ',', '.') . "');
                window.location.href = 'hasil.php';
                </script>";
        } else {
            echo "<script>
                alert('Gagal menyimpan data: " . $connect->error . "');
                window.history.back();
                </script>";
        }
    } else {
        echo "<script>
            alert('Jenis kamar tidak ditemukan.');
            window.history.back();
            </script>";
    }
}
?>

<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Formulir Pemesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function calculateTotal() {
            const durasiPemesanan = parseInt(document.getElementById('durasiPemesanan').value) || 0;
            const idJenisKamar = document.getElementById('jenisKamar');
            const selectedOption = idJenisKamar.options[idJenisKamar.selectedIndex];
            const hargaKamar = parseInt(selectedOption.getAttribute('data-harga')) || 0;
            const breakfast = document.getElementById('breakfast').checked ? 80000 : 0;

            let totalHarga = hargaKamar * durasiPemesanan + breakfast;

            // Diskon 10% jika durasi lebih dari 3 hari
            if (durasiPemesanan > 3) {
                totalHarga *= 0.9;
            }

            document.getElementById('totalHarga').value = `Rp ${totalHarga.toLocaleString('id-ID')}`;
        }
    </script>
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-8">
            <div class="card">
                <div class="card-header">
                    Formulir Pemesanan
                </div>
                <div class="card-body">
                    <form action="" method="POST">
                        <div class="mb-3">
                            <label for="namaPemesan" class="form-label">Nama Pemesan</label>
                            <input type="text" class="form-control" id="namaPemesan" name="nama_pemesan" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jenis Kelamin</label>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="jenisKelaminPria" name="jenis_kelamin" value="Pria" required>
                                <label class="form-check-label" for="jenisKelaminPria">Pria</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="jenisKelaminWanita" name="jenis_kelamin" value="Wanita" required>
                                <label class="form-check-label" for="jenisKelaminWanita">Wanita</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="nomorIdentitas" class="form-label">Nomor Identitas</label>
                            <input type="text" class="form-control" id="nomorIdentitas" name="nomor_identitas" required>
                        </div>
                        <div class="mb-3">
                            <label for="jenisKamar" class="form-label">Tipe Kamar</label>
                            <select class="form-select" id="jenisKamar" name="id_jenis_kamar" onchange="updateHarga()" required>
                                <option selected disabled>-- Pilih Tipe Kamar --</option>
                                <?php
                                $query = "SELECT * FROM jenis_kamar";
                                $result = $connect->query(query: $query);
                                while ($row = $result->fetch_assoc()) {
                                    echo '<option value="' . $row['id'] . '" data-harga="' . $row['harga'] . '">' . $row['nama_kamar'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="hargaKamar" class="form-label">Harga</label>
                            <input type="text" class="form-control" id="hargaKamar" name="harga_kamar" readonly>

                        </div>
                        <div class="mb-3">
                            <label for="tanggalPemesanan" class="form-label">Tanggal Pemesanan</label>
                            <input type="date" class="form-control" id="tanggalPemesanan" name="tanggal_pemesanan" required>
                        </div>
                        <div class="mb-3">
                            <label for="durasiPemesanan" class="form-label">Durasi Pemesanan (hari)</label>
                            <input type="number" class="form-control" id="durasiPemesanan" name="durasi_pemesanan" oninput="calculateTotal()" required>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="breakfast" name="breakfast" onclick="calculateTotal()">
                            <label class="form-check-label" for="breakfast">Tambah Breakfast (+ Rp 80.000)</label>
                        </div>
                        <div class="mb-3">
                            <label for="totalHarga" class="form-label">Total Harga</label>
                            <input type="text" class="form-control" id="totalHarga" readonly>
                        </div>
                        <button type="submit" name="kirim" class="btn btn-primary">Kirim</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    //jquery: library yang mempersingkat penulisan js
    //ajax: untuk berinteraksi degnan server dan mengirimkan data atau mengambil data dari server secara dinamis
    $('#jenisKamar').change(function () {
    var jenisKamar = $(this).val(); // Mengambil value dari dropdown jenis kamar

    $.ajax({


        type: 'POST', // Metode request
        url: 'ajax_hotel.php', // URL file PHP yang menangani permintaan
        data: { data1: jenisKamar }, // Data yang dikirim ke PHP
        success: function (response) {
            $('#hargaKamar').val(response); // Menampilkan hasil response pada input harga
        },
        error: function (xhr, status, error) {
            alert("Terjadi kesalahan: " + error); // Menampilkan pesan error jika gagal
        }
        
    });
    
});

</script>





</body>
</html>
