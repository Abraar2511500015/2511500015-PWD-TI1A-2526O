<?php
session_start();
$sesnama = $_POST["txtNama"];
$sesemail = $_POST["txtEmail"];
$sespesan = $_POST["txtPesan"];
$sesnama = $_POST["txtNim"];
$sesemail = $_POST["txtNama Lengkap"];
$sespesan = $_POST["txtTempat Lahir"];
$sesnama = $_POST["txtTanggal Lahir"];
$sesemail = $_POST["txtHobi"];
$sespesan = $_POST["txtPasangan"];
$sesnama = $_POST["txtPekerjaan"];
$sesemail = $_POST["txtNama Orang Tua"];
$sespesan = $_POST["txtNama Kakak"];
$sespesan = $_POST["txtNama Adik"];
$_SESSION["sesnama"] = $sesnama;
$_SESSION["sesemail"] = $sesemail;
$_SESSION["sespesan"] = $sespesan;
header("location: index.php");
?>