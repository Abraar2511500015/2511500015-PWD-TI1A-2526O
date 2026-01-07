<?php
session_start();
require_once __DIR__ . '/fungsi.php';
?> 

<!DOCTYPE html>
<html lang="en">

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
    <section id="home">
      <h2>Selamat Datang</h2>
      <?php
      echo "nama saya Abraar";
      ?>
    </section>

    <?php
    $flash_sukses = $_SESSION['flash_sukses'] ?? ''; #jika query sukses
    $flash_error  = $_SESSION['flash_error'] ?? ''; #jika ada error
    $old          = $_SESSION['old'] ?? []; #untuk nilai lama form

    unset($_SESSION['flash_sukses'], $_SESSION['flash_error'], $_SESSION['old']); #bersihkan 3 session ini
    ?>

    <section id="biodata">
      <h2>Biodata Sederhana Mahasiswa</h2>
      <form action="biodata.php" method="POST">

      <label for="txtNim"><span>NIM:</span>
          <input type="text" id="txtNim" name="txtNim" placeholder="Masukkan NIM"
            required autocomplete="nim"
            value="<?= isset($old['nim']) ? htmlspecialchars($old['nim']) : '' ?>">
        </label>
      
        <label for="txtNamaLengkap"><span>Nama Lengkap:</span>
          <input type="text" id="txtNamaLengkap" name="txtNamaLengkap" placeholder="Masukkan Nama Lengkap"
            required autocomplete="nama lengkap"
            value="<?= isset($old['nama_lengkap']) ? htmlspecialchars($old['nama_lengkap']) : '' ?>">
        </label>

        <label for="txtTempatLahir"><span>Tempat Lahir:</span>
          <input type="text" id="txtTempatLahir" name="txtTempatLahir" placeholder="Masukkan Tempat Lahir"
            required autocomplete="tempat lahir"
            value="<?= isset($old['tempat_lahir']) ? htmlspecialchars($old['tempat_lahir']) : '' ?>">
        </label>

        <label for="txtTanggalLahir"><span>Tanggal Lahir:</span>
          <input type="date" id="txtTanggalLahir" name="txtTanggalLahir" placeholder="Masukkan Tanggal Lahir"
            required autocomplete="tanggal_lahir"
            value="<?= isset($old['tanggal_lahir']) ? htmlspecialchars($old['tanggal_lahir']) : '' ?>">
        </label>

        <label for="txtHobi"><span>Hobi:</span>
          <input type="text" id="txtHobi" name="txtHobi" placeholder="Masukkan Hobi"
            required autocomplete="hobi"
            value="<?= isset($old['hobi']) ? htmlspecialchars($old['hobi']) : '' ?>">
        </label>

        <label for="txtPasangan"><span>Pasangan:</span>
          <input type="text" id="txtPasangan" name="txtPasangan" placeholder="Masukkan Pasangan"
            required autocomplete="pasangan"
            value="<?= isset($old['pasangan']) ? htmlspecialchars($old['pasangan']) : '' ?>">
        </label>

        <label for="txtKerja"><span>Pekerjaan:</span>
          <input type="text" id="txtKerja" name="txtKerja" placeholder="Masukkan Pekerjaan"
            required autocomplete="pekerjaan"
            value="<?= isset($old['pekerjaan']) ? htmlspecialchars($old['pekerjaan']) : '' ?>">
        </label>

        <label for="txtNamaOrangTua"><span>Nama Orang Tua:</span>
          <input type="text" id="txtNamaOrangTua" name="txtNamaOrangTua" placeholder="Masukkan Nama Orang Tua"
            required autocomplete="nama_orang_tua"
            value="<?= isset($old['nama_orang_tua']) ? htmlspecialchars($old['nama_orang_tua']) : '' ?>">
        </label>

        <label for="txtNamaKakak"><span>Nama Kakak:</span>
          <input type="text" id="txtNamaKakak" name="txtNamaKakak" placeholder="Masukkan Nama kakak"
            required autocomplete="nama_kakak"
            value="<?= isset($old['nama_kakak']) ? htmlspecialchars($old['nama_kakak']) : '' ?>">
        </label>

        <label for="txtNamaAdik"><span>Nama Adik:</span>
          <input type="text" id="txtNamaAdik" name="txtNamaAdik" placeholder="Masukkan Nama Adik"
            required autocomplete="nama_adik"
            value="<?= isset($old['nama_adik']) ? htmlspecialchars($old['nama_adik']) : '' ?>">
        </label>

        <button type="submit">Kirim</button>
        <button type="reset">Batal</button>
      </form>

      <br>
      <hr>
      <h2>Biodata Mahasiswa</h2>
      <?php include 'readbiodata.php'; ?>
    
    </section>

    <?php
    $flash_sukses = $_SESSION['flash_sukses'] ?? ''; #jika query sukses
    $flash_error  = $_SESSION['flash_error'] ?? ''; #jika ada error
    $old          = $_SESSION['old'] ?? []; #untuk nilai lama form

    unset($_SESSION['flash_sukses'], $_SESSION['flash_error'], $_SESSION['old']); #bersihkan 3 session ini
    ?>

    <section id="contact">
      <h2>Kontak Kami</h2>

      <?php if (!empty($flash_sukses)): ?>
        <div style="padding:10px; margin-bottom:10px; background:#d4edda; color:#155724; border-radius:6px;">
          <?= $flash_sukses; ?>
        </div>
      <?php endif; ?>

      <?php if (!empty($flash_error)): ?>
        <div style="padding:10px; margin-bottom:10px; background:#f8d7da; color:#721c24; border-radius:6px;">
          <?= $flash_error; ?>
        </div>
      <?php endif; ?>

      <form action="proses.php" method="POST">

        <label for="txtNama"><span>Nama:</span>
          <input type="text" id="txtNama" name="txtNama" placeholder="Masukkan nama"
            required autocomplete="name"
            value="<?= isset($old['nama']) ? htmlspecialchars($old['nama']) : '' ?>">
        </label>

        <label for="txtEmail"><span>Email:</span>
          <input type="email" id="txtEmail" name="txtEmail" placeholder="Masukkan email"
            required autocomplete="email"
            value="<?= isset($old['email']) ? htmlspecialchars($old['email']) : '' ?>">
        </label>

        <label for="txtPesan"><span>Pesan Anda:</span>
          <textarea id="txtPesan" name="txtPesan" rows="4" placeholder="Tulis pesan anda..."
            required><?= isset($old['pesan']) ? htmlspecialchars($old['pesan']) : '' ?></textarea>
          <small id="charCount">0/200 karakter</small>
        </label>

        <label for="txtCaptcha"><span>Captcha 2 + 3 = ?</span>
          <input type="number" id="txtCaptcha" name="txtCaptcha" placeholder="Jawab Pertanyaan..."
            required
            value="<?= isset($old['captcha']) ? htmlspecialchars($old['captcha']) : '' ?>">
        </label>

        <button type="submit">Kirim</button>
          <button type="reset">Batal</button>
      </form>

      <br>
      <hr>
      <h2>Yang menghubungi kami</h2>
      <?php include 'read_inc.php'; ?>
    </section>
  </main>

  <footer>
    <p>&copy; 2025 Moh. Sayyid Abraar [2511500015]</p>
  </footer>

  <script src="script.js"></script>
</body>

</html>