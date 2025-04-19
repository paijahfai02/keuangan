<?php
session_start();
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
?>
<nav>
    <h1>Dashboard Keuangan</h1>
    <p>Selamat datang, <?php echo htmlspecialchars($username); ?>!</p>
</nav>