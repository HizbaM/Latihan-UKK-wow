<?php
require_once 'koneksi.php';

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kebun Raya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    <h1>Hello, world!</h1>
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
                            <input type="text" class="form-control" id="namaPemesan" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="nomorIdentitas" class="form-label">Nomor Identitas</label>
                            <input type="text" class="form-control" id="nomorIdentitas" name="nomor_identitas" required>
                        </div>
                        <div class="mb-3">
                            <label for="nomorHP" class="form-label">Nomor HP</label>
                            <input type="text" class="form-control" id="nomorHP" name="nomor_hp" required>
                        </div>
                        <div class="mb-3">
                            <label for="pilihanTempatWisata" class="form-label">Pilihan Tempat Wisata</label>
                            <select class="form-select" id="pilihanTempatWisata" name="id_tempat_wisata" required>
                                <option selected>-- Pilih Tempat Wisata --</option>
                                <?php
                                $query = "SELECT * FROM tempat_wisata";
                                $result = mysqli_query($connect, $query);
                                while ($rslt = mysqli_fetch_assoc($result)) {
                                    echo '<option value="' . $rslt['id'] . '">' . $rslt['nama_tempat'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tanggalKunjungan" class="form-label">Tanggal Kunjungan</label>
                            <input type="date" class="form-control" id="tanggalKunjungan" name="tanggal_kunjungan" required>
                        </div>
                        <div class="mb-3">
                            <label for="jumlahPengunjung" class="form-label">Jumlah Pengunjung</label>
                            <input type="number" class="form-control" id="jumlahPengunjung" name="jumlah_pengunjung" required>
                        </div>
                        <div class="mb-3">
                            <label for="pengunjungAnak" class="form-label">Pengunjung Anak</label>
                            <input type="number" class="form-control" id="pengunjungAnak" name="pengunjung_anak" required>
                        </div>
                        <button type="submit" name="kirim" class="btn btn-primary">Kirim</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>