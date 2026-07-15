<?php
require_once "config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password'];

    $query = mysqli_query($koneksi, "SELECT * FROM tb_admin WHERE username = '$username' LIMIT 1");

    if (mysqli_num_rows($query) === 1) {
        $admin = mysqli_fetch_assoc($query);

        if (password_verify($password, $admin['password'])) {
            $_SESSION['admin_id']       = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            header("Location: dashboard.php");
            exit;
        }
    }

    // Login gagal
    header("Location: index.php?error=1");
    exit;
}
?>
