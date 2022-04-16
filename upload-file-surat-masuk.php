<?php
    $nama_file = $_FILES['dokumen']['name'];
    $filepath = $_FILES['dokumen']['tmp_name'];
    $lokasi = "public/assets/file/surat-masuk/";
    move_uploaded_file($filepath, $lokasi.$nama_file);
?>