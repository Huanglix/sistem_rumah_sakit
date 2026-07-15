<?php
require_once "koneksi.php";
require_once "auth.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama    = mysqli_real_escape_string($koneksi, $_POST['nama_pasien']);
    $jk      = mysqli_real_escape_string($koneksi, $_POST['jenis_kelamin']);
    $email   = mysqli_real_escape_string($koneksi, $_POST['email']);
    $telp    = mysqli_real_escape_string($koneksi, $_POST['no_telp']);
    $alamat  = mysqli_real_escape_string($koneksi, $_POST['alamat']);

    $query = "INSERT INTO tb_pasien (nama_pasien, jenis_kelamin, email, no_telp, alamat)
              VALUES ('$nama', '$jk', '$email', '$telp', '$alamat')";

    if (mysqli_query($koneksi, $query)) {
        header("Location: data_pasien.php?msg=tambah");
        exit;
    } else {
        die("Gagal menyimpan data: " . mysqli_error($koneksi));
    }
}
?>
