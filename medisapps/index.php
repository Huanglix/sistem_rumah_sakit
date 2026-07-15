<?php
require_once "config.php";

// Jika sudah login, langsung ke dashboard
if (isset($_SESSION['admin_id'])) {
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - MedisApps v1.0</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="login-wrapper">
        <div class="login-card">
            <div class="login-icon">+</div>
            <h2>MedisApps v1.0</h2>
            <p class="subtitle">Sistem Informasi Rumah Sakit</p>

            <?php if (isset($_GET['error'])): ?>
                <div class="alert-error">Username atau password salah!</div>
            <?php endif; ?>

            <form action="proses_login.php" method="POST">
                <div class="form-group">
                    <label>Username / No. Pegawai</label>
                    <input type="text" name="username" placeholder="Masukkan username..." required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Masukkan password..." required>
                </div>
                <button type="submit" class="btn-login">MASUK SISTEM</button>
            </form>

            <p class="footer-note">IT Rumah Sakit Sentosa &copy; 2026</p>
        </div>
    </div>
</body>
</html>
