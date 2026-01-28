<?php
session_start();
require __DIR__ . './koneksi.php';
require_once __DIR__ . '/fungsi.php';

/*
	ikuti cara penulisan proses.php untuk validasi, sanitasi, RPG, data old
	dan insert ke tbl_tamu termasuk flash message ke index.php#biodata
	bedanya, kali ini diterapkan untuk biodata dosen bukan tamu
*/

$arrBiodata = [
  "kodedos" => $_POST["txtKodeDos"] ?? "",
  "nama" => $_POST["txtNmDosen"] ?? "",
  "alamat" => $_POST["txtAlRmh"] ?? "",
  "tanggal" => $_POST["txtTglDosen"] ?? "",
  "jja" => $_POST["txtJJA"] ?? "",
  "prodi" => $_POST["txtProdi"] ?? "",
  "nohp" => $_POST["txtNoHP"] ?? "",
  "pasangan" => $_POST["txNamaPasangan"] ?? "",
  "anak" => $_POST["txtNmAnak"] ?? "",
  "ilmu" => $_POST["txtBidangIlmu"] ?? ""
];
$_SESSION["biodata"] = $arrBiodata;

header("location: index.php#about");

<?php
session_start();
require __DIR__ . '/koneksi.php';
require_once __DIR__ . '/fungsi.php';

#cek method form, hanya izinkan POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  $_SESSION['flash_error'] = 'Akses tidak valid.';
  redirect_ke('index.php#biodata');
}

#ambil dan bersihkan nilai dari form
$KodeDosen = bersihkan($_POST['txtKodeDos']  ?? '');
$NamaDosen = bersihkan($_POST['txtNmDos'] ?? '');
$Alamat = bersihkan($_POST['txtAlRmh'] ?? '');
$TanggalJadiDosen = bersihkan($_POST['txtTglDosen'] ?? '');
$JJA = bersihkan($_POST['txtJJA'] ?? '');
$NamaPasangan = bersihkan($_POST['txtNamaPasangan'] ?? '');
$NomorHp = bersihkan($_POST['txtNoHP'] ?? '');
$HomebaseProdi = bersihkan($_POST['txtProdi'] ?? '');
$NamaAnak = bersihkan($_POST['txtNmAnak'] ?? '');
$BidangIlmuDosen = bersihkan($_POST['txtBidangIlmu'] ?? '');

#Validasi sederhana
$errors = []; #ini array untuk menampung semua error yang ada

if ($nim === '') {
  $errors[] = 'NIM wajib diisi.';
}

if ($namalengkap === '') {
  $errors[] = 'Nama Lengkap wajib diisi.';
}

if($tempatlahir === '') {
  $errors[] = 'Tempat Lahir wajib diisi.';
}

if ($tanggallahir === '') {
  $errors[] = 'Tanggal Lahir wajib diisi.';
}

if ($hobi === '') {
  $errors[] = 'Hobi wajib diisi.';
}

if ($pasangan === '') {
  $errors[] = 'Pasangan wajib diisi.';
}

if ($pekerjaan === '') {
  $errors[] = 'Pekerjaan wajib diisi.';
}

if ($namaOrangTua === '') {
  $errors[] = 'Nama Orang Tua wajib diisi.';
}

if ($namaKakak === '') {
  $errors[] = 'Nama Kakak wajib diisi.';
}

if ($namaAdik === '') {
  $errors[] = 'Nama Adik wajib diisi.';
}


if (mb_strlen($namalengkap) < 3) {
  $errors[] = 'Nama Lengkap minimal 3 karakter.';
}

/*
kondisi di bawah ini hanya dikerjakan jika ada error, 
simpan nilai lama dan pesan error, lalu redirect (konsep PRG)
*/
if (!empty($errors)) {
  $_SESSION['old'] = [
    'nim'  => $nim,
    'nama_lengkap' => $namalengkap,
    'tempat_lahir' => $tempatlahir,
    'tanggal_lahir' => $tanggallahir,
    'hobi' => $hobi,
    'pasangan' => $pasangan,
    'pekerjaan' => $pekerjaan,
    'nama_orang_tua' => $namaOrangTua,
    'nama_kakak' => $namaKakak,
    'nama_adik' => $namaAdik,
  ];

  $_SESSION['flash_error'] = implode('<br>', $errors);
  redirect_ke('index.php#biodata');
}

#menyiapkan query INSERT dengan prepared statement
$sql = "INSERT INTO tbl_biodata (cnim, cnama_lengkap, ctempat_lahir, ctanggal_lahir, chobi, cpasangan, cpekerjaan, cnama_orang_tua, cnama_kakak, cnama_adik) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
  #jika gagal prepare, kirim pesan error ke pengguna (tanpa detail sensitif)
  $_SESSION['flash_error'] = 'Terjadi kesalahan sistem (prepare gagal).';
  redirect_ke('index.php#biodata');
}
#bind parameter dan eksekusi (s = string)
mysqli_stmt_bind_param($stmt, "ssssssssss", $nim, $namalengkap, $tempatlahir, $tanggallahir, $hobi, $pasangan, $pekerjaan, $namaOrangTua, $namaKakak, $namaAdik);

if (mysqli_stmt_execute($stmt)) { #jika berhasil, kosongkan old value, beri pesan sukses
  unset($_SESSION['old']);
  $_SESSION['flash_sukses'] = 'Terima kasih, data Anda sudah tersimpan.';
  redirect_ke('index.php#biodata'); #pola PRG: kembali ke form / halaman home
} else { #jika gagal, simpan kembali old value dan tampilkan error umum
  $_SESSION['old'] = [
    'nim'  => $nim,
    'nama_lengkap' => $namalengkap,
    'tempat_lahir' => $tempatlahir,
    'tanggal_lahir' => $tanggallahir,
    'hobi' => $hobi,
    'pasangan' => $pasangan,
    'pekerjaan' => $pekerjaan,
    'nama_orang_tua' => $namaOrangTua,
    'nama_kakak' => $namaKakak,
    'nama_adik' => $namaAdik,
  ];
  $_SESSION['flash_error'] = 'Data gagal disimpan. Silakan coba lagi.';
  redirect_ke('index.php#biodata');
}
#tutup statement
mysqli_stmt_close($stmt);

header("location: index.php#about");

