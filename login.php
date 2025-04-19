<?php
require 'config.php';
session_start();

$error = "";

if (isset($_POST['login'])) {
    $nama = isset($_POST['nama']) ? trim($_POST['nama']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    if (empty($nama) || empty($password)) {
        $error = "Nama dan password harus diisi!";
    } else {
        // Ambil data dari database
        $query = "SELECT * FROM admin WHERE nama = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $nama);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            var_dump($data); // Debugging
            if (password_verify($password, $data['password'])) {
                $_SESSION['admin'] = $nama;
                header("Location: dashboard.php");
                exit();
            } else {
                echo "Password salah!";
            }
        } else {
            echo "Akun tidak ditemukan!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="login-box">
            <h2>Login Admin</h2>
            <?php if ($error): ?>
                <p class="error"><?php echo $error; ?></p>
            <?php endif; ?>
            <form method="POST">
                <label>Nama:</label>
                <input type="text" name="nama" required>
                <label>Password:</label>
                <input type="password" name="password" required>
                <button type="submit" name="login">Login</button>
            </form>
            <p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>
        </div>
    </div>
</body>
</html>