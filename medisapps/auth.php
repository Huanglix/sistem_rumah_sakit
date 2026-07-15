<?php
// Panggil file ini di paling atas setiap halaman yang butuh login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>
