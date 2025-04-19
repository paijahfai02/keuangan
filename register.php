<?php
require 'config.php';
session_start();

$error = "";

if (isset($_POST['register'])) {
    $nama = isset($_POST['nama']) ? trim($_POST['nama']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    if (empty($nama) || empty($password)) {
        $error = "Nama dan password harus diisi!";
    } else {
        // Enkripsi password sebelum disimpan
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Cek apakah nama sudah ada di database
        $query = "SELECT * FROM admin WHERE nama = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $nama);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "Nama sudah digunakan!";
        } else {
            // Insert ke database
            $query = "INSERT INTO admin (nama, password) VALUES (?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ss", $nama, $hashedPassword);

            if ($stmt->execute()) {
                $_SESSION['admin'] = $nama; 
                header("Location: dashboard.php"); // Redirect ke dashboard
                exit();
            } else {
                $error = "Registrasi gagal: " . $stmt->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Admin</title>
    <link rel="stylesheet" href="style.css"> <!-- Hubungkan ke file CSS -->
</head>
<body>
    <div class="container">
        <div class="register-box">
            <h2>Register Admin</h2>
            <?php if ($error): ?>
                <p class="error"><?php echo $error; ?></p>
            <?php endif; ?>
            <form method="POST">
                <label>Nama:</label>
                <input type="text" name="nama" required>
                <label>Password:</label>
                <input type="password" name="password" required>
                <button type="submit" name="register">Register</button>
            </form>
            <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
        </div>
    </div>
</body>
</html>