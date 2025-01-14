<?php
require_once 'koneksi.php';

// Query untuk mendapatkan data beasiswa akademik dan non-akademik
$query = "SELECT nama_kamar, harga FROM jenis_kamar";
$result = mysqli_query($connect, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Document</title>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-success navbar-dark">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">Hotel Bereketek</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavigasi" aria-controls="navbarNavigasi" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavigasi">
          <div class="navbar-nav">
            <a class="nav-link" href="produk.php">Produk</a>
            <a class="nav-link"href="pesan_kamar.php">Pesan Hotel</a>
            <a class="nav-link active"  aria-current="page" href="daftar_harga.php">Daftar Harga</a>
            <a class="nav-link" href="tentang_kami.php">Tentang Kami</a>
          </div>
        </div>
      </div>
    </nav>

    <div class="container mt-5">
      <h1 class="text-center mb-4">Daftar Harga</h1>
      <div class="row justify-content-center">
        <div class="col-10">
            <div class="card shadow border-0">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Jenis Kamar</h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <div class="col-md-6 col-lg-4">
                                <div class="card shadow-sm border-0 h-100">
                                    <div class="card-body p-4">
                                        <!-- Ikon Beasiswa -->
                                        <div class="text-center mb-3">
                                            <img src="images/56371e22f32242c93c3c720c7565bb3c.jpg" alt="Beasiswa Icon">
                                        </div>

                                        <!-- Jenis Beasiswa -->
                                        <h5 class="card-title fw-bold text-black text-center">
                                            <?php echo htmlspecialchars($row['nama_kamar']); ?>
                                        </h5>

                                        <!-- Keterangan -->
                                        <p class="card-text text-muted text-center">
                                            <?php echo htmlspecialchars($row['harga']); ?>
                                        </p>
                                    </div>
                                    <div class="card-footer bg-light text-end">
                                        <a href="#" class="btn btn-outline-primary btn-sm">Lihat Detail</a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
    
</body>
</html>