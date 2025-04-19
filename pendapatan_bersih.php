<?php
include 'config.php';
include 'function.php';
include 'header.php';
include 'sidebar.php';;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pendapatan Bersih</title>
    <link rel="stylesheet" type="text/css" href="style3.css">
</head>
<body>

<div class="container mt-4">
    <h2>Pendapatan Bersih</h2>

    <?php
    // Ambil total pemasukan (kolom = jumlah)
    $pemasukan_result = mysqli_query($conn, "SELECT SUM(jumlah) AS total_pemasukan FROM pemasukan");
    if (!$pemasukan_result) {
        die("Query pemasukan gagal: " . mysqli_error($conn));
    }
    $data_pemasukan = mysqli_fetch_assoc($pemasukan_result);
    $total_pemasukan = $data_pemasukan['total_pemasukan'] ?? 0;

    // Ambil total pengeluaran (kolom = nominal)
    $pengeluaran_result = mysqli_query($conn, "SELECT SUM(nominal) AS total_pengeluaran FROM pengeluaran");
    if (!$pengeluaran_result) {
        die("Query pengeluaran gagal: " . mysqli_error($conn));
    }
    $data_pengeluaran = mysqli_fetch_assoc($pengeluaran_result);
    $total_pengeluaran = $data_pengeluaran['total_pengeluaran'] ?? 0;

    // Hitung pendapatan bersih
    $pendapatan_bersih = $total_pemasukan - $total_pengeluaran;
    ?>

    <div class="card mt-4 p-3">
        <p><strong>Total Pemasukan:</strong> Rp <?= number_format($total_pemasukan, 0, ',', '.') ?></p>
        <p><strong>Total Pengeluaran:</strong> Rp <?= number_format($total_pengeluaran, 0, ',', '.') ?></p>
        <hr>
        <h4><strong>Pendapatan Bersih:</strong> Rp <?= number_format($pendapatan_bersih, 0, ',', '.') ?></h4>
    </div>
</div>

</body>
</html>
