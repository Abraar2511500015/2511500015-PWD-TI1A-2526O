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
    redirect_ke('readbiodatadosen.php');
  }

  /*
    Ambil data lama dari DB menggunakan prepared statement, 
    jika ada kesalahan, tampilkan penanda error.
  */
  $stmt = mysqli_prepare($conn, "SELECT cid, cKodeDosen, cNamaDosen, cAlamat, cTanggalJadiDosen, cJJA, cNamaPasangan, cNomorHP, cHomebaseProdi, cNamaAnak, cBidangIlmuDosen
                                    FROM tbl_biodata_dosen WHERE cid = ? LIMIT 1");
  if (!$stmt) {
    $_SESSION['flash_error'] = 'Query tidak benar.';
    redirect_ke('readbiodatadosen.php');
  }

  mysqli_stmt_bind_param($stmt, "i", $cid);
  mysqli_stmt_execute($stmt);
  $res = mysqli_stmt_get_result($stmt);
  $row = mysqli_fetch_assoc($res);
  mysqli_stmt_close($stmt);

  if (!$row) {
    $_SESSION['flash_error'] = 'Record tidak ditemukan.';
    redirect_ke('readbiodatadosen.php');
  }

  #Nilai awal (prefill form)
    $kodedosen = $row['cKodeDosen'];
    $namadosen = $row['cNamaDosen'];
    $alamat = $row['cAlamat'];
    $tanggaljadidosen = $row['cTanggalJadiDosen'];
    $jja = $row['cJJA'];
    $namapasangan = $row['cNamaPasangan'];
    $nomorhp = $row['cNomorHP'];
    $homebaseprodi = $row['cHomebaseProdi'];
    $namaanak = $row['cNamaAnak'];
    $bidangilmudosen = $row['cBidangIlmuDosen'];

  #Ambil error dan nilai old input kalau ada
  $flash_error = $_SESSION['flash_error'] ?? '';
  $old = $_SESSION['old'] ?? [];
  unset($_SESSION['flash_error'], $_SESSION['old']);
  if (!empty($old)) {
    $kodedosen = $old['kodedosen'] ?? $kodedosen;
    $namadosen = $old['namadosen'] ?? $namadosen;
    $alamat = $old['alamat'] ?? $alamat;
    $tanggaljadidosen = $old['tanggaljadidosen'] ?? $tanggaljadidosen;
    $jja = $old['jja'] ?? $jja;
    $namapasangan = $old['namapasangan'] ?? $namapasangan;
    $nomorhp = $old['nomorhp'] ?? $nomorhp;
    $homebaseprodi = $old['homebaseprodi'] ?? $homebaseprodi;
    $namaanak = $old['namaanak'] ?? $namaanak;
    $bidangilmudosen = $old['bidangilmudosen'] ?? $bidangilmudosen;
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
        <form action="prosesupdatebiodatadosen.php" method="POST">

          <input type="text" name="cid" value="<?= (int)$cid; ?>">

          <label for="txtKodeDosen"><span>Kode Dosen:</span>
            <input type="text" id="txtKodeDosen" name="txtKodeDosenEd" 
              placeholder="Masukkan Kode Dosen" required autocomplete="kodedosen"
              value="<?= !empty($kodedosen) ? $kodedosen : '' ?>">
          </label>

            <label for="txtNmDosen"><span>Nama Dosen:</span>
                <input type="text" id="txtNmDosen" name="txtNmDosenEd" 
                placeholder="Masukkan Nama Dosen" required autocomplete="name"
                value="<?= !empty($namadosen) ? $namadosen : '' ?>">
            </label>

            <label for="txtAlRmh"><span>Alamat Rumah:</span>
                <input type="text" id="txtAlRmh" name="txtAlRmhEd" 
                placeholder="Masukkan Alamat" required
                value="<?= !empty($alamat) ? $alamat : '' ?>">
            </label>

            <label for="txtTglDosen"><span>Tanggal Jadi Dosen:</span>
                <input type="date" id="txtTglDosen" name="txtTglDosenEd" 
                placeholder="Masukkan Tanggal Jadi Dosen" required
                value="<?= !empty($tanggaljadidosen) ? $tanggaljadidosen : '' ?>">
            </label>

            <label for="txtJJA"><span>JJA:</span>
                <input type="text" id="txtJJA" name="txtJJAEd" 
                placeholder="Masukkan Hobi" required
                value="<?= !empty($jja) ? $jja : '' ?>">
            </label>

            <label for="txtNamaPasangan"><span>NamaPasangan:</span>
                <input type="text" id="txtNamaPasangan" name="txtNamaPasanganEd" 
                placeholder="Masukkan Nama Pasangan" required
                value="<?= !empty($namapasangan) ? $namapasangan : '' ?>">
            </label>

            <label for="txtNoHP"><span>Nomor Hp:</span>
                <input type="text" id="txtNoHP" name="txtNoHPEd" 
                placeholder="Masukkan Nomor HP" required
                value="<?= !empty($nomorhp) ? $nomorhp : '' ?>">
            </label>

            <label for="txtHomebaseProdi"><span>Homebase:</span>
                <input type="text" id="txtHomebaseProdi" name="txtHomebaseProdiEd" 
                placeholder="Masukkan Homebase" required
                value="<?= !empty($homebaseprodi) ? $homebaseprodi : '' ?>">
            </label>

            <label for="txtNmAnak"><span>Nama Anak:</span>
                <input type="text" id="txtNmAnak" name="txtNmAnakEd" 
                placeholder="Masukkan Nama Anak" required
                value="<?= !empty($namaAnak) ? $namaAnak : '' ?>">
            </label>

            <label for="txtBidangIlmu"><span>Bidang Ilmu Dosen:</span>
                <input type="text" id="txtBidangIlmu" name="txtBidangIlmuEd" 
                placeholder="Masukkan Bidang Ilmu Dosen" required
                value="<?= !empty($bidangilmu) ? $bidangilmu : '' ?>">
            </label>

          <button type="submit">Kirim</button>
          <button type="reset">Batal</button>
          <a href="readbiodatadosen.php" class="reset">Kembali</a>
        </form>
      </section>
    </main>

    <script src="script.js"></script>
  </body>
</html>