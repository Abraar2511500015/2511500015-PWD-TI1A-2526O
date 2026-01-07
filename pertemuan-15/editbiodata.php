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
    redirect_ke('readbiodata.php');
  }

  /*
    Ambil data lama dari DB menggunakan prepared statement, 
    jika ada kesalahan, tampilkan penanda error.
  */
  $stmt = mysqli_prepare($conn, "SELECT cid, cnim, cnama_lengkap, ctempat_lahir, ctanggal_lahir, chobi, cpasangan, cpekerjaan, cnama_orang_tua, cnama_kakak, cnama_adik
                                    FROM tbl_biodata WHERE cid = ? LIMIT 1");
  if (!$stmt) {
    $_SESSION['flash_error'] = 'Query tidak benar.';
    redirect_ke('readbiodata.php');
  }

  mysqli_stmt_bind_param($stmt, "i", $cid);
  mysqli_stmt_execute($stmt);
  $res = mysqli_stmt_get_result($stmt);
  $row = mysqli_fetch_assoc($res);
  mysqli_stmt_close($stmt);

  if (!$row) {
    $_SESSION['flash_error'] = 'Record tidak ditemukan.';
    redirect_ke('readbiodata.php');
  }

  #Nilai awal (prefill form)
    $nim = $row['cnim'] ?? '';
    $namalengkap = $row['cnama_lengkap'] ?? '';
    $tempatlahir = $row['ctempat_lahir'] ?? '';
    $tanggallahir = $row['ctanggal_lahir'] ?? '';
    $hobi = $row['chobi'] ?? '';
    $pasangan = $row['cpasangan'] ?? '';
    $pekerjaan = $row['cpekerjaan'] ?? '';
    $namaOrangTua = $row['cnama_orang_tua'] ?? '';
    $namaKakak = $row['cnama_kakak'] ?? '';
    $namaAdik = $row['cnama_adik'] ?? '';

  #Ambil error dan nilai old input kalau ada
  $flash_error = $_SESSION['flash_error'] ?? '';
  $old = $_SESSION['old'] ?? [];
  unset($_SESSION['flash_error'], $_SESSION['old']);
  if (!empty($old)) {
    $nim = $old['nim'] ?? $nim;
    $namalengkap = $old['nama_lengkap'] ?? $nama;
    $tempatlahir = $old['tempat_lahir'] ?? $tempatlahir;
    $tanggallahir = $old['tanggal_lahir'] ?? $tanggallahir;
    $hobi = $old['hobi'] ?? $hobi;
    $pasangan = $old['pasangan'] ?? $pasangan;
    $pekerjaan = $old['pekerjaan'] ?? $pekerjaan;
    $namaOrangTua = $old['nama_orang_tua'] ?? $namaOrangTua;
    $namaKakak = $old['nama_kakak'] ?? $namaKakak;
    $namaAdik = $old['nama_adik'] ?? $namaAdik;
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
        <h2>Edit Buku Tamu</h2>
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
              placeholder="Masukkan NIM" required autocomplete="nim"
              value="<?= !empty($nim) ? $nim : '' ?>">
          </label>

            <label for="txtNamaLengkap"><span>Nama Lengkap:</span>
                <input type="text" id="txtNamaLengkap" name="txtNamaLengkapEd" 
                placeholder="Masukkan Nama Lengkap" required autocomplete="name"
                value="<?= !empty($namalengkap) ? $namalengkap : '' ?>">
            </label>

            <label for="txtTempatLahir"><span>Tempat Lahir:</span>
                <input type="text" id="txtTempatLahir" name="txtTempatLahirEd" 
                placeholder="Masukkan Tempat Lahir" required
                value="<?= !empty($tempatlahir) ? $tempatlahir : '' ?>">
            </label>

            <label for="txtTanggalLahir"><span>Tanggal Lahir:</span>
                <input type="date" id="txtTanggalLahir" name="txtTanggalLahirEd" 
                placeholder="Masukkan Tanggal Lahir" required
                value="<?= !empty($tanggallahir) ? $tanggallahir : '' ?>">
            </label>

            <label for="txtHobi"><span>Hobi:</span>
                <input type="text" id="txtHobi" name="txtHobiEd" 
                placeholder="Masukkan Hobi" required
                value="<?= !empty($hobi) ? $hobi : '' ?>">
            </label>

            <label for="txtPasangan"><span>Pasangan:</span>
                <input type="text" id="txtPasangan" name="txtPasanganEd" 
                placeholder="Masukkan Pasangan" required
                value="<?= !empty($pasangan) ? $pasangan : '' ?>">
            </label>

            <label for="txtKerja"><span>Pekerjaan:</span>
                <input type="text" id="txtKerja" name="txtKerjaEd" 
                placeholder="Masukkan Pekerjaan" required
                value="<?= !empty($pekerjaan) ? $pekerjaan : '' ?>">
            </label>

            <label for="txtNamaOrangTua"><span>Nama Orang Tua:</span>
                <input type="text" id="txtNamaOrangTua" name="txtNamaOrangTuaEd" 
                placeholder="Masukkan Nama Orang Tua" required
                value="<?= !empty($namaOrangTua) ? $namaOrangTua : '' ?>">
            </label>

            <label for="txtNamaKakak"><span>Nama Kakak:</span>
                <input type="text" id="txtNamaKakak" name="txtNamaKakakEd" 
                placeholder="Masukkan Nama Kakak" required
                value="<?= !empty($namaKakak) ? $namaKakak : '' ?>">
            </label>

            <label for="txtNamaAdik"><span>Nama Adik:</span>
                <input type="text" id="txtNamaAdik" name="txtNamaAdikEd" 
                placeholder="Masukkan Nama Adik" required
                value="<?= !empty($namaAdik) ? $namaAdik : '' ?>">
            </label>

          <button type="submit">Kirim</button>
          <button type="reset">Batal</button>
          <a href="readbiodata.php" class="reset">Kembali</a>
        </form>
      </section>
    </main>

    <script src="script.js"></script>
  </body>
</html>