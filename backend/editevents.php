<?php
include 'koneksi.php';

$id = $_GET['id'];
$query = mysqli_query($link, "SELECT * FROM events WHERE id = $id");
$data = mysqli_fetch_assoc($query);

if (!$data) {
  echo "<script>alert('Data tidak ditemukan');window.location='indexevents.php';</script>";
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nama_event = htmlspecialchars($_POST['nama_event']);
  $deskripsi = htmlspecialchars($_POST['deskripsi']);
  $tanggal = $_POST['tanggal_event'];
  $link_event = htmlspecialchars($_POST['link_event']);
  $tampilkan_link = isset($_POST['tampilkan_link']) ? 1 : 0;

  // Upload foto jika ada file baru
  if ($_FILES['foto']['name']) {
    $foto_name = time() . '-' . $_FILES['foto']['name'];
    $target = 'uploads/' . $foto_name;
    move_uploaded_file($_FILES['foto']['tmp_name'], $target);

    // Hapus file lama jika ada
    if ($data['foto']) {
      unlink('uploads/' . $data['foto']);
    }

    $foto_sql = ", foto = '$foto_name'";
  } else {
    $foto_sql = "";
  }

  $update = mysqli_query($link, "UPDATE events SET 
      nama_event = '$nama_event',
      deskripsi = '$deskripsi',
      tanggal_event = '$tanggal',
      link_event = '$link_event',
      tampilkan_link = '$tampilkan_link'
      $foto_sql
      WHERE id = $id
  ");

  if ($update) {
    echo "<script>alert('Event berhasil diperbarui');window.location='indexevents.php';</script>";
  } else {
    echo "<script>alert('Gagal memperbarui event');</script>";
  }
}
?>