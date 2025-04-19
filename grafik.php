<?php
include 'config.php';
include 'function.php';
include 'header.php';
include 'sidebar.php';

// Ambil data pemasukan
$pemasukan = [];
$result1 = mysqli_query($conn, "SELECT tanggal, SUM(jumlah) as total FROM pemasukan GROUP BY tanggal");
while ($row = mysqli_fetch_assoc($result1)) {
    $pemasukan[$row['tanggal']] = $row['total'];
}

// Ambil data pengeluaran
$pengeluaran = [];
$result2 = mysqli_query($conn, "SELECT tanggal, SUM(nominal) as total FROM pengeluaran GROUP BY tanggal");
while ($row = mysqli_fetch_assoc($result2)) {
    $pengeluaran[$row['tanggal']] = $row['total'];
}

// Gabungkan semua tanggal
$tanggal_all = array_unique(array_merge(array_keys($pemasukan), array_keys($pengeluaran)));
sort($tanggal_all);

$data_chart = [];
foreach ($tanggal_all as $tgl) {
    $data_chart[] = [
        'tanggal' => $tgl,
        'pemasukan' => $pemasukan[$tgl] ?? 0,
        'pengeluaran' => $pengeluaran[$tgl] ?? 0
    ];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Grafik Keuangan</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="style3.css">
</head>
<body>
<div class="container mt-4">
    <h2>Grafik Keuangan</h2>
    <canvas id="keuanganChart" height="100"></canvas>
</div>

<script>
    const data = <?= json_encode($data_chart); ?>;

    const labels = data.map(item => item.tanggal);
    const pemasukanData = data.map(item => item.pemasukan);
    const pengeluaranData = data.map(item => item.pengeluaran);

    const ctx = document.getElementById('keuanganChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Pemasukan',
                    data: pemasukanData,
                    borderColor: 'green',
                    fill: false
                },
                {
                    label: 'Pengeluaran',
                    data: pengeluaranData,
                    borderColor: 'red',
                    fill: false
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' },
                title: {
                    display: true,
                    text: 'Grafik Pemasukan vs Pengeluaran'
                }
            }
        }
    });
</script>

</body>
</html>
