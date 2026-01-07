<?php
  session_start();
  require 'koneksi.php';
  require 'fungsi.php';

  /*
    Ambil nilai cid dari GET dan lakukan validasi untuk 
    mengecek cid harus angka dan lebih besar dari 0 (> 0).
    'options' => ['min_range' => 1] artinya cid harus ≥ 1 
    (bukan 0, bahkan bukan negatif, bukan huruf, bukan HTML).
  */
  $cid = filter_input(INPUT_GET, 'cid', FILTER_VALIDATE_INT, [
    'options' => ['min_range' => 1]
  ]);
  /*
    Skrip di atas cara penulisan lamanya adalah:
    $cid = $_GET['cid'] ?? '';
    $cid = (int)$cid;

    Cara lama seperti di atas akan mengambil data mentah 
    kemudian validasi dilakukan secara terpisah, sehingga 
    rawan lupa validasi. Untuk input dari GET atau POST, 
    filter_input() lebih disarankan daripada $_GET atau $_POST.
  */

  /*
    Cek apakah $cid bernilai valid:
    Kalau $cid tidak valid, maka jangan lanjutkan proses, 
    kembalikan pengguna ke halaman awal (read.php) sembari 
    mengirim penanda error.
  */
  if (!$cid) {
    $_SESSION['flash_error'] = 'Akses tidak valid.';
    redirect_ke('read_biodata.php');
  }

  /*
    Ambil data lama dari DB menggunakan prepared statement, 
    jika ada kesalahan, tampilkan penanda error.
  */
  $stmt = mysqli_prepare($conn, "SELECT cid, cnim, cnama,  ctempat, ctanggal, chobi, cpasangan, cpekerjaan, cortu, ckakak, cadik
                                    FROM tbl_biodata WHERE cid = ? LIMIT 1");
  if (!$stmt) {
    $_SESSION['flash_error'] = 'Query tidak benar.';
    redirect_ke('read_biodata.php');
  }

  mysqli_stmt_bind_param($stmt, "i", $cid);
  mysqli_stmt_execute($stmt);
  $res = mysqli_stmt_get_result($stmt);
  $row = mysqli_fetch_assoc($res);
  mysqli_stmt_close($stmt);

  if (!$row) {
    $_SESSION['flash_error'] = 'Record tidak ditemukan.';
    redirect_ke('read_biodata.php');
  }

  #Nilai awal (prefill form)
  $nim = $row['cnim'] ?? '';
  $nama  = $row['cnama'] ?? '';
  $tempat = $row['ctempat'] ??'';
  $tanggal = $row['ctanggal'] ??'';
  $hobi = $row['chobi'] ??'';
  $pasangan = $row['cpasangan'] ??'';
  $pekerjaan = $row['cpekerjaan'] ??'';
  $ortu = $row['cortu'] ??'';
  $kakak = $row['ckakak'] ??'';
  $adik = $row['cadik'] ??'';

  #Ambil error dan nilai old input kalau ada
  $flash_error = $_SESSION['flash_error'] ?? '';
  $old = $_SESSION['old'] ?? [];
  unset($_SESSION['flash_error'], $_SESSION['old']);
  if (!empty($old)) { 
    $nim =$old['nim'] ?? $nim;
    $nama  = $old['nama'] ?? $nama;
    $tempat  = $old['tempat'] ?? $tempat;
    $tanggal  = $old['tanggal'] ?? $tanggal;
    $hobi  = $old['hobi'] ?? $hobi;
    $pasangan  = $old['pasangan'] ?? $pasangan;
    $pekerjaan  = $old['pekerjaan'] ?? $pekerjaan;
    $ortu  = $old['ortu'] ?? $ortu;
    $kakak  = $old['kakak'] ?? $kakak;
    $adik  = $old['adik'] ?? $adik;
  }
?>

<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Judul Halaman</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <header>
      <h1>Ini Header</h1>
      <button class="menu-toggle" id="menuToggle" aria-label="Toggle Navigation">
        &#9776;
      </button>
      <nav>
        <ul>
          <li><a href="#home">Beranda</a></li>
          <li><a href="#about">Tentang</a></li>
          <li><a href="#contact">Kontak</a></li>
        </ul>
      </nav>
    </header>

    <main>
      <section id="biodata">
        <h2>Edit Biodata</h2>
        <?php if (!empty($flash_error)): ?>
          <div style="padding:10px; margin-bottom:10px; 
            background:#f8d7da; color:#721c24; border-radius:6px;">
            <?= $flash_error; ?>
          </div>
        <?php endif; ?>
        <form action="proses_updatebiodata.php" method="POST">

          <input type="text" name="cid" value="<?= (int)$cid; ?>">

          <label for="txtNim"><span>NIM:</span>
            <input type="text" id="txtNim" name="txtNimEd" 
              placeholder="Masukkan Nim" required autocomplete="nim"
              value="<?= !empty($nim) ? $nim : '' ?>">
          </label>

          <label for="txtNmLengkap"><span>Nama Lengkap:</span>
            <input type="text" id="txtNmLengkap" name="txtNmLengkapEd" 
              placeholder="Masukkan Nama Lengkap" required autocomplete="name lengkap"
              value="<?= !empty($nama) ? $nama : '' ?>">
          </label>

          <label for="txtT4Lhr"><span>Tempat Lahir:</span>
            <input type="text" id="txtT4Lhr" name="txtT4LhrEd" 
              placeholder="Masukkan Tempat Lahir" required autocomplete="tempat lahir"
              value="<?= !empty($tempat) ? $tempat : '' ?>">
          </label>

            <label for="txtTglLhr"><span>Tanggal Lahir:</span>
            <input type="text" id="txtTglLhr" name="txtTglLhrEd" 
              placeholder="Masukkan Tanggal Lahir" required autocomplete="name"
              value="<?= !empty($tanggal) ? $tanggal : '' ?>">
          </label>

          <label for="txtHobi"><span>Hobi:</span>
            <input type="text" id="txtHobi" name="txtHobiEd" 
              placeholder="Masukkan Hobi" required autocomplete="Hobi"
              value="<?= !empty($hobi) ? $hobi : '' ?>">
          </label>

          <label for="txtPasangan"><span>Pasangan:</span>
            <input type="text" id="txtPasangan" name="txtPasanganEd" 
              placeholder="Masukkan Pasangan" required autocomplete="pasangan"
              value="<?= !empty($pasangan) ? $pasangan : '' ?>">
          </label>

          <label for="txtKerja"><span>Pekerjaan:</span>
            <input type="text" id="txtKerja" name="txtKerjaEd" 
              placeholder="Masukkan Pekerjaan" required autocomplete="pekerjaan"
              value="<?= !empty($pekerjaan) ? $pekerjaan : '' ?>">
          </label>

          <label for="txtNmOrtu"><span>Nama Orang Tua:</span>
            <input type="text" id="txtNmOrtu" name="txtNmOrtuEd" 
              placeholder="Masukkan Nama orang Tua" required autocomplete="nam orang tua"
              value="<?= !empty($ortu) ? $ortu : '' ?>">
          </label>

          <label for="txtNmKakak"><span>Nama Kakak:</span>
            <input type="text" id="txtNmkakak" name="txtNmKakakEd" 
              placeholder="Masukkan Nama Kakak" required autocomplete="nama kakak"
              value="<?= !empty($kakak) ? $kakak : '' ?>">
          </label>

          <label for="txtNmAdik"><span>Nama Adik:</span>
            <input type="text" id="txtNmAdik" name="txtNmAdikEd" 
              placeholder="Masukkan Nama Adik" required autocomplete="nama adik"
              value="<?= !empty($adik) ? $adik : '' ?>">
          </label>


          <button type="submit">Kirim</button>
          <button type="reset">Batal</button>
          <a href="read_biodata.php" class="reset">Kembali</a>
        </form>
      </section>
    </main>

    <script src="script.js"></script>
  </body>
</html>