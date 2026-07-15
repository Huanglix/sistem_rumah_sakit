<?php
require_once "koneksi.php";
require_once "auth.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id      = (int) $_POST['id'];
    $nama    = mysqli_real_escape_string($koneksi, $_POST['nama_pasien']);
    $jk      = mysqli_real_escape_string($koneksi, $_POST['jenis_kelamin']);
    $email   = mysqli_real_escape_string($koneksi, $_POST['email']);
    $telp    = mysqli_real_escape_string($koneksi, $_POST['no_telp']);
    $alamat  = mysqli_real_escape_string($koneksi, $_POST['alamat']);

    $query = "UPDATE tb_pasien SET
                nama_pasien = '$nama',
                jenis_kelamin = '$jk',
                email = '$email',
                no_telp = '$telp',
                alamat = '$alamat'
              WHERE id = $id";

    if (mysqli_query($koneksi, $query)) {
        header("Location: data_pasien.php?msg=edit");
        exit;
    } else {
        die("Gagal memperbarui data: " . mysqli_error($koneksi));
    }
}
?>
