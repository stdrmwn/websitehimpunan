<?php
include 'config4.php';

$nama = $_POST['nama_event'];
$deskripsi = $_POST['deskripsi_event'];
$tanggal = $_POST['tanggal_event'];
$link = $_POST['link_terkait'];
$tampilkan = isset($_POST['tampilkan_link']) ? 1 : 0;

$foto = $_FILES['foto_event']['name'];
$tmp = $_FILES['foto_event']['tmp_name'];
$fotoBaru = '';

if ($foto) {
  $fotoBaru = uniqid() . '-' . $foto;
  move_uploaded_file($tmp, 'uploads/' . $fotoBaru);
}

$query = "INSERT INTO eventshimpunan (nama_event, deskripsi_event, tanggal_event, foto_event, link_terkait, tampilkan_link) 
          VALUES ('$nama', '$deskripsi', '$tanggal', '$fotoBaru', '$link', '$tampilkan')";

mysqli_query($link, $query);
header("Location: indexeventhimpunan.php");
