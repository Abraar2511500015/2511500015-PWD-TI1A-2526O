<?php
require 'koneksi.php';

$fieldConfig = [
      "nim" => ["label" => "NIM:", "suffix" => ""],
      "nama" => ["label" => "Nama Lengkap:", "suffix" => " &#128526;"],
      "tempat" => ["label" => "Tempat Lahir:", "suffix" => ""],
      "tanggal" => ["label" => "Tanggal Lahir:", "suffix" => ""],
      "hobi" => ["label" => "Hobi:", "suffix" => " &#127926;"],
      "pasangan" => ["label" => "Pasangan:", "suffix" => " &hearts;"],
      "pekerjaan" => ["label" => "Pekerjaan:", "suffix" => " &copy; 2025"],
      "orang tua" => ["label" => "Nama Orang Tua:", "suffix" => ""],
      "kakak" => ["label" => "Nama Kakak:", "suffix" => ""],
      "adik" => ["label" => "Nama Adik:", "suffix" => ""],
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
        "tempat" => $row['ctempat_lahir'],
        "tanggal" => $row['ctanggal_lahir'],
        "hobi" => $row['chobi'],
        "pasangan" => $row['cpasangan'],
        "pekerjaan" => $row['cpekerjaan'],
        "orang tua" => $row['cnama_orang_tua'],
        "kakak" => $row['cnama_kakak'],
        "adik" => $row['cnama_adik'],
    ];
    echo tampilkanBiodata($fieldConfig, $arrConfig);
  }
}
?>
