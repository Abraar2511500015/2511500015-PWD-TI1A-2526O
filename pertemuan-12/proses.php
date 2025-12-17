<?php
session_start();
require_once __DIR__ . '/koneksi.php';
require_once __DIR__ . '/fungsi.php';

if($_POST['txtCaptcha_Sederhana']!=$_POST['txtCaptcha_Sederhana']) {
  echo "jawaban captcha 5";
  exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  $_SESSION['flash_error'] = 'Akses tidak valid.';
  redirect_ke('index.php#contact');
}

$no = "";
$nama = bersihkan($_POST['txtNama'] ?? '');
$email = bersihkan($_POST['txtEmail'] ?? ''); 
$pesan = bersihkan($_POST['txtPesan'] ?? '');
$captcha = bersihkan($_POST['txtCaptcha_Sederhana'] ?? '');
$tanggal = date("Y-m-d H:i:s");


$errors = [];

if ($nama === '') {
  $errors[] = 'Nama wajib diisi.';
}   

if ($email === '') {
  $errors[] = 'Email wajib diisi.';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  $errors[] = 'Format e-mail tidak valid.';
}

if ($pesan === '') {
  $errors[] = 'Pesan wajib diisi.';
}

if ($captcha === '') {
  $errors[] = 'Jawaban captcha 5!.';
}

if (mb_strlen($nama) < 3) {
  $errors[] = 'Nama minimal 3 karakter.';
}

if (mb_strlen($pesan) < 10) {
  $errors[] = 'Pesan minimal 10 karakter.';
}

if (!empty($errors)) {
  $_SESSION['$old'] = [
    'no' => "",
    'nama' => $nama,
    'email' => $email,
    'pesan' => $pesan,
    'captcha' => $captcha,
    'tanggal' => $tanggal,
  ];


  $_SESSION['flash_error'] = implode('<br>', $errors);
  redirect_ke('index.php#contact');
}

$sql = "INSERT INTO tbl_tamu (cnama, cemail, cpesan) VALUES (?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
  $_SESSION['flash_error'] = 'Terjadi kesalahan sistem (prepare gagal).';
  redirect_ke('index.php#contact');
}

mysqli_stmt_bind_param($stmt, "sss", $nama, $email, $pesan);

if (!mysqli_stmt_execute($stmt)) {
  unset($_SESSION['old']);
  $_SESSION['flash_error'] = 'Data gagal disimpan. Silahkan coba lagi.';
  redirect_ke('index.php#contact');
} else {
  $_SESSION['$old'] = [
    'no' => "",
    'nama' => $nama,
    'email' => $email,
    'pesan' => $pesan,
    'captcha' => $captcha,
    'tanggal' => $tanggal,
  ];
  $_SESSION['flash_sukses'] = 'Terima kasih, data Anda sudah tersimpan.';
  redirect_ke('index.php#contact');
}

mysqli_stmt_close($stmt);

$arrContact = [
  "no" => "",
  "nama" => $_POST["txtNama"] ?? "",
  "email" => $_POST["txtEmail"] ?? "",
  "pesan" => $_POST["txtPesan"] ?? "",
  "captcha" => $_POST["txtCaptcha_Sederhana"] ?? "",
  "tanggal" => date("Y-m-d H:i:s"),
];
$_SESSION["contact"] = $arrContact;

$arrBiodata = [
  "nim" => $_POST["txtNim"] ?? "",
  "nama" => $_POST["txtNmLengkap"] ?? "",
  "tempat" => $_POST["txtT4Lhr"] ?? "",
  "tanggal" => $_POST["txtTglLhr"] ?? "",
  "hobi" => $_POST["txtHobi"] ?? "",
  "pasangan" => $_POST["txtPasangan"] ?? "",
  "pekerjaan" => $_POST["txtKerja"] ?? "",
  "ortu" => $_POST["txtNmOrtu"] ?? "",
  "kakak" => $_POST["txtNmKakak"] ?? "",
  "adik" => $_POST["txtNmAdik"] ?? ""
];
$_SESSION["biodata"] = $arrBiodata;

header("location: index.php#about");