<?php
include 'config.php';
include 'function.php';
include 'header.php';
include 'sidebar.php';

// Ambil total pemasukan dari tabel total_keuangan
$queryTotal = "SELECT total_pemasukan FROM total_keuangan WHERE id = 1";
$resultTotal = mysqli_query($conn, $queryTotal);
$dataTotal = mysqli_fetch_assoc($resultTotal);
$totalPemasukan = $dataTotal['total_pemasukan'] ?? 0;
?>

<main>
    <link rel="stylesheet" href="style2.css">
    <h2>Dashboard Laporan Keuangan</h2>

    <div class="summary">
        <div class="card">
            <h3>Total Pemasukan</h3>
            <p>Rp <?php echo number_format($totalPemasukan, 0, ',', '.'); ?></p>
        </div>
        <div class="card">
            <h3>Total Pengeluaran</h3>
            <p>Rp <?php echo number_format(getTotal('report', 'pengeluaran', '1=1'), 0, ',', '.'); ?></p>
        </div>
        <div class="card">
            <h3>Pendapatan Bersih</h3>
            <p>Rp <?php echo number_format(getPendapatanBersih(), 0, ',', '.'); ?></p>
        </div>
    </div>

    <h3>Grafik Keuangan</h3>
    <canvas id="chartKeuangan"></canvas>
</main>

<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('chartKeuangan').getContext('2d');
    // Tambahkan script untuk menampilkan grafik di sini
</script>
