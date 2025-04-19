<?php
include 'config.php';
include 'function.php';
include 'header.php';
include 'sidebar.php';

// Tambah Data Pemasukan
if (isset($_POST['tambah'])) {
    $tanggal = $_POST['tanggal'];
    $keterangan = $_POST['keterangan'];
    $jumlah = $_POST['jumlah'];
    
    $query = "INSERT INTO pemasukan (tanggal, keterangan, jumlah) VALUES ('$tanggal', '$keterangan', '$jumlah')";
    
    if (mysqli_query($conn, $query)) {
        header("Location: pemasukan.php");
        exit;
    } else {
        echo "Gagal menambahkan data: " . mysqli_error($conn);
    }
}

// Hapus Data Pemasukan
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $query = "DELETE FROM pemasukan WHERE id = '$id'";
    
    if (mysqli_query($conn, $query)) {
        header("Location: pemasukan.php");
        exit;
    } else {
        echo "Gagal menghapus data: " . mysqli_error($conn);
    }
}

// Simpan Total Pemasukan
if (isset($_POST['simpan_total'])) {
    $queryTotal = "SELECT SUM(jumlah) AS total FROM pemasukan";
    $resultTotal = mysqli_query($conn, $queryTotal);
    $dataTotal = mysqli_fetch_assoc($resultTotal);
    $totalPemasukan = $dataTotal['total'];

    // Simpan ke database atau sesi
    $querySave = "UPDATE total_keuangan SET total_pemasukan = '$totalPemasukan' WHERE id = 1";
    mysqli_query($conn, $querySave);

    header("Location: pemasukan.php");
    exit;
}

// Ambil Data Pemasukan
$result = mysqli_query($conn, "SELECT * FROM pemasukan ORDER BY tanggal DESC");
if (!$result) {
    die("Query Error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemasukan</title>
    <link rel="stylesheet" href="style3.css">
</head>
<body>
    <h2>Pemasukan</h2>
    
    <!-- Form Tambah Pemasukan -->
    <form action="" method="POST">
        <label>Tanggal:</label>
        <input type="date" name="tanggal" required>
        <label>Keterangan:</label>
        <input type="text" name="keterangan" required>
        <label>Jumlah (Rp):</label>
        <input type="number" name="jumlah" required>
        <button type="submit" name="tambah">Tambah</button>
    </form>
    
    <h2>Daftar Pemasukan</h2>
    <table border="1">
        <tr>
            <th>Tanggal</th>
            <th>Keterangan</th>
            <th>Jumlah</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
            <tr>
                <td><?= $row['tanggal']; ?></td>
                <td><?= $row['keterangan']; ?></td>
                <td>Rp <?= number_format($row['jumlah'], 0, ',', '.'); ?></td>
                <td>
                    <a href="pemasukan.php?hapus=<?= $row['id']; ?>" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <!-- Tombol Simpan Total -->
    <form action="" method="POST">
        <button type="submit" name="simpan_total">Simpan Total</button>
    </form>
</body>
</html>
