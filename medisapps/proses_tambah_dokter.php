<?php
require_once "koneksi.php";
require_once "auth.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama   = mysqli_real_escape_string($koneksi, $_POST['nama_dokter']);
    $spes   = mysqli_real_escape_string($koneksi, $_POST['spesialisasi']);
    $email  = mysqli_real_escape_string($koneksi, $_POST['email']);
    $telp   = mysqli_real_escape_string($koneksi, $_POST['no_telp']);
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);

    $query = "INSERT INTO tb_dokter (nama_dokter, spesialisasi, email, no_telp, alamat)
              VALUES ('$nama', '$spes', '$email', '$telp', '$alamat')";

    if (mysqli_query($koneksi, $query)) {
        header("Location: data_dokter.php?msg=tambah");
        exit;
    } else {
        die("Gagal menyimpan data: " . mysqli_error($koneksi));
    }
}
?>
