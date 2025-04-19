<?php
include 'config.php';
include 'function.php';
include 'header.php';
include 'sidebar.php';

// Handle form submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nominal = $_POST['nominal'];
    $deskripsi = $_POST['deskripsi'];
    $tanggal = $_POST['tanggal'];

    $query = "INSERT INTO pengeluaran (nominal, deskripsi, tanggal) VALUES ('$nominal', '$deskripsi', '$tanggal')";
    mysqli_query($conn, $query);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pengeluaran</title>
    <link rel="stylesheet" type="text/css" href="style3.css"> <!-- Link ke CSS kamu -->
</head>
<body>

<div class="container mt-4">
    <h2>Input Pengeluaran</h2>
    <form method="POST" action="">
        <div class="form-group">
            <label>Nominal</label>
            <input type="number" name="nominal" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Deskripsi</label>
            <input type="text" name="deskripsi" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Tanggal</label>
            <input type="date" name="tanggal" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-danger mt-2">Simpan Pengeluaran</button>
    </form>

    <hr>

    <h3>Daftar Pengeluaran</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nominal</th>
                <th>Deskripsi</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = mysqli_query($conn, "SELECT * FROM pengeluaran ORDER BY tanggal DESC");
            $no = 1;
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                    <td>".$no++."</td>
                    <td>Rp " . number_format($row['nominal'], 0, ',', '.') . "</td>
                    <td>".$row['deskripsi']."</td>
                    <td>".$row['tanggal']."</td>
                </tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>
