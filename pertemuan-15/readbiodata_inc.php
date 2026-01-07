<?php
require 'koneksi.php';

$fieldConfig = [
      "nim" => ["label" => "NIM:", "suffix" => ""],
      "nama" => ["label" => "Nama Lengkap:", "suffix" => " &#128526;"],
      "tempat_lahir" => ["label" => "Tempat Lahir:", "suffix" => ""],
      "tanggal_lahir" => ["label" => "Tanggal Lahir:", "suffix" => ""],
      "hobi" => ["label" => "Hobi:", "suffix" => " &#127926;"],
      "pasangan" => ["label" => "Pasangan:", "suffix" => " &hearts;"],
      "pekerjaan" => ["label" => "Pekerjaan:", "suffix" => " &copy; 2025"],
      "nama_orang_tua" => ["label" => "Nama Orang Tua:", "suffix" => ""],
      "nama_kakak" => ["label" => "Nama Kakak:", "suffix" => ""],
      "nama_adik" => ["label" => "Nama Adik:", "suffix" => ""],
    ];

$sql = "SELECT * FROM tbl_biodata ORDER BY cid DESC";
$q = mysqli_query($conn, $sql);
if (!$q) {
  echo "<p>Gagal membaca data tamu: " . htmlspecialchars(mysqli_error($conn)) . "</p>";
} elseif (mysqli_num_rows($q) === 0) {
  echo "<p>Belum ada data tamu yang tersimpan.</p>";
} else {
  while ($row = mysqli_fetch_assoc($q)) {
    $arrConfig = [
        "nim" => $row['cnim'],
        "nama" => $row['cnama'],
        "tempat_lahir" => $row['ctempat_lahir'],
        "tanggal_lahir" => $row['ctanggal_lahir'],
        "hobi" => $row['chobi'],
        "pasangan" => $row['cpasangan'],
        "pekerjaan" => $row['cpekerjaan'],
        "nama_orang_tua" => $row['cnama_orang_tua'],
        "nama_kakak" => $row['cnama_kakak'],
        "nama_adik" => $row['cnama_adik'],
    ];
    echo tampilkanBiodata($fieldConfig, $arrConfig);
  }
}
?>
