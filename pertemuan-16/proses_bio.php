
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

if ($KodeDosen === '') {
  $errors[] = 'Kode Dosen wajib diisi.';
}

if ($NamaDosen === '') {
  $errors[] = 'Nama Dosen wajib diisi.';
}

if($Alamat === '') {
  $errors[] = 'Alamat Rumah wajib diisi.';
}

if ($TanggalJadiDosen === '') {
  $errors[] = 'Tanggal Jadi Dosen wajib diisi.';
}

if ($JJA === '') {
  $errors[] = 'JJA Dosen wajib diisi.';
}

if ($NamaPasangan === '') {
  $errors[] = 'Nama Pasangan wajib diisi.';
}

if ($NomorHp === '') {
  $errors[] = 'Nomor HP wajib diisi.';
}

if ($HomebaseProdi === '') {
  $errors[] = 'Homebase Prodi wajib diisi.';
}

if ($NamaAnak === '') {
  $errors[] = 'Nama Anak wajib diisi.';
}

if ($BidangIlmuDosen === '') {
  $errors[] = 'Bidang Ilmu Dosen wajib diisi.';
}


if (mb_strlen($NamaDosen) < 3) {
  $errors[] = 'Nama Dosen minimal 3 karakter.';
}

/*
kondisi di bawah ini hanya dikerjakan jika ada error, 
simpan nilai lama dan pesan error, lalu redirect (konsep PRG)
*/
if (!empty($errors)) {
  $_SESSION['old'] = [
    'kodedos'  => $KodeDosen,
    'nama' => $NamaDosen,
    'alamat' => $Alamat,
    'tanggal' => $TanggalJadiDosen,
    'jja' => $JJA,
    'namapasangan' => $NamaPasangan,
    'nomorhp' => $NomorHp,
    'homebaseprodi' => $HomebaseProdi,
    'namaanak' => $NamaAnak,
    'bidangilmudosen' => $BidangIlmuDosen,
  ];

  $_SESSION['flash_error'] = implode('<br>', $errors);
  redirect_ke('index.php#biodata');
}

#menyiapkan query INSERT dengan prepared statement
$sql = "INSERT INTO tbl_biodata_dosen (cKodeDosen, cNamaDosen, cAlamat, cTanggalJadiDosen, cJJA, cNamaPasangan, cNomorHp, cHomebaseProdi, cNamaAnak, cBidangIlmuDosen) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
  #jika gagal prepare, kirim pesan error ke pengguna (tanpa detail sensitif)
  $_SESSION['flash_error'] = 'Terjadi kesalahan sistem (prepare gagal).';
  redirect_ke('index.php#biodata');
}
#bind parameter dan eksekusi (s = string)
mysqli_stmt_bind_param($stmt, "ssssssssss", $KodeDosen, $NamaDosen, $Alamat, $TanggalJadiDosen, $JJA, $NamaPasangan, $NomorHp, $HomebaseProdi, $NamaAnak, $BidangIlmuDosen);
if (mysqli_stmt_execute($stmt)) { #jika berhasil, kosongkan old value, beri pesan sukses
  unset($_SESSION['old']);
  $_SESSION['flash_sukses'] = 'Terima kasih, data Anda sudah tersimpan.';
  redirect_ke('index.php#biodata'); #pola PRG: kembali ke form / halaman home
} else { #jika gagal, simpan kembali old value dan tampilkan error umum
  $_SESSION['old'] = [
    'kodedos'  => $KodeDosen,
    'nama' => $NamaDosen,
    'alamat' => $Alamat,
    'tanggal' => $TanggalJadiDosen,
    'jja' => $JJA,
    'namapasangan' => $NamaPasangan,
    'nomorhp' => $NomorHp,
    'namaorangtua' => $HomebaseProdi,
    'namaanak' => $NamaAnak,
    'bidangilmudosen' => $BidangIlmuDosen,
  ];
  $_SESSION['flash_error'] = 'Data gagal disimpan. Silakan coba lagi.';
  redirect_ke('index.php#biodata');
}
#tutup statement
mysqli_stmt_close($stmt);

header("location: index.php#about");

