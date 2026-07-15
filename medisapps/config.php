<?php
session_start();

// ==========================
// KONFIGURASI DATABASE
// ==========================
$host    = "localhost";
$user    = "root";
$pass    = "";
$dbname  = "rumah_sakit";

$koneksi = mysqli_connect($host, $user, $pass, $dbname);

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

mysqli_set_charset($koneksi, "utf8");
?>
