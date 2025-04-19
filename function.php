<?php
include 'config.php';

function getTotal($table, $column, $condition) {
    global $conn;
    $query = "SELECT SUM($column) AS total FROM $table WHERE $condition";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['total'] ?? 0;
}

// Tambahkan fungsi getPendapatanBersih di bawah ini
function getPendapatanBersih() {
    $totalPemasukan = getTotal('report', 'pemasukan', '1=1');
    $totalPengeluaran = getTotal('report', 'pengeluaran', '1=1');
    return $totalPemasukan - $totalPengeluaran;
}
