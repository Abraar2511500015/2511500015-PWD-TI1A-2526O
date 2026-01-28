<?php
require 'koneksi.php';

$fieldBiodata = [
      "kodedosen" => ["label" => "Kode Dosen:", "suffix" => ""],
      "namadosen" => ["label" => "Nama Dosen:", "suffix" => " &#128526;"],
      "alamat" => ["label" => "Alamat:", "suffix" => ""],
      "tanggaljadidosen" => ["label" => "Tanggal Jadi Dosen:", "suffix" => ""],
      "jja" => ["label" => "JJA:", "suffix" => ""],
      "namapasangan" => ["label" => "Nama Pasangan:", "suffix" => " &hearts;"],
      "nomorhp" => ["label" => "Nomor HP:", "suffix" => " &copy; 2025"],
      "homebaseprodi" => ["label" => "Homebase Prodi:", "suffix" => ""],
      "namaanak" => ["label" => "Nama Anak:", "suffix" => ""],
      "bidangilmudosen" => ["label" => "Bidang Ilmu Dosen:", "suffix" => ""],
    ];

$sql = "SELECT * FROM tbl_biodata_dosen ORDER BY cid DESC";
$q = mysqli_query($conn, $sql);
if (!$q) {
  echo "<p>Gagal membaca data tamu: " . 
  htmlspecialchars(mysqli_error($conn)). "</p>";
} elseif (mysqli_num_rows($q) === 0) {
  echo "<p>Belum ada data tamu yang tersimpan.</p>";
} else {
  while ($row = mysqli_fetch_assoc($q)) {
    $arrBiodata = [
        "kodedosen" => $row['cKodeDosen'],
        "namadosen" => $row['cNamaDosen'],
        "alamat" => $row['cAlamat'],
        "tanggaljadidosen" => $row['cTanggalJadiDosen'],
        "jja" => $row['cJJA'],
        "namapasangan" => $row['cNamaPasangan'],
        "nomorhp" => $row['cNomorHp'],
        "homebaseprodi" => $row['cHomebaseProdi'],
        "namaanak" => $row['cNamaAnak'],
        "bidangilmudosen" => $row['cBidangIlmuDosen'],
    ];
    echo tampilkanBiodata($fieldBiodata, $arrBiodata);
  }
}
?>
