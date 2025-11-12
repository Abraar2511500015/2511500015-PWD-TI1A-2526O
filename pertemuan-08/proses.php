<?php
session_start();
$sesnama = $_POST["txtNama"];
$sesemail = $_POST["txtEmail"];
$sespesan = $_POST["txtPesan"];
$sesnim = $_POST["txtNim"];
$sesnamalengkap = $_POST["txtNama Lengkap"];
$sestempatlahir = $_POST["txtTempat Lahir"];
$sestanggallahir = $_POST["txtTanggal Lahir"];
$seshobi = $_POST["txtHobi"];
$sespasangan = $_POST["txtPasangan"];
$sespekerjaan = $_POST["txtPekerjaan"];
$sesnamaorangtua = $_POST["txtNama Orang Tua"];
$sesnamakakak = $_POST["txtNama Kakak"];
$sesnamaadik = $_POST["txtNama Adik"];
$_SESSION["sesnama"] = $sesnama;
$_SESSION["sesemail"] = $sesemail;
$_SESSION["sespesan"] = $sespesan;
header("location: index.php");
?>