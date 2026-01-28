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
      echo "halo dunia!<br>";
      echo "nama saya Abraar";
      ?>
      <p>Ini contoh paragraf HTML.</p>
    </section>

    <section id="biodata">
      <h2>Biodata Dosen</h2>
      <form action="proses_bio.php" method="POST">

      <label for="txtKodeDos"><span>Kode Dosen:</span>
          <input type="text" id="txtKodeDos" name="txtKodeDos" placeholder="Masukkan Kode Dosen"
            required autocomplete="kode_dos"
            value="<?= isset($old['kode_dos']) ? htmlspecialchars($old['kode_dos']) : '' ?>">
        </label>
      
        <label for="txtNmDosen"><span>Nama Dosen:</span>
          <input type="text" id="txtNmDosen" name="txtNmDosen" placeholder="Masukkan Nama Dosen"
            required autocomplete="nama_dosen"
            value="<?= isset($old['nama_dosen']) ? htmlspecialchars($old['nama_dosen']) : '' ?>">
        </label>

        <label for="txtAlRmh"><span>Alamat Rumah:</span>
          <input type="text" id="txtAlRmh" name="txtAlRmh" placeholder="Masukkan Alamat Rumah"
            required autocomplete="alamat_rumah"
            value="<?= isset($old['alamat_rumah']) ? htmlspecialchars($old['alamat_rumah']) : '' ?>">
        </label>

        <label for="txtTglDosen"><span>Tanggal Jadi Dosen:</span>
          <input type="date" id="txtTglDosen" name="txtTglDosen" placeholder="Masukkan Tanggal Jadi Dosen"
            required autocomplete="tanggal_jadi_dosen"
            value="<?= isset($old['tanggal_jadi_dosen']) ? htmlspecialchars($old['tanggal_jadi_dosen']) : '' ?>">
        </label>

        <label for="txtJJA"><span>JJA Dosen:</span>
          <input type="text" id="txtJJA" name="txtJJA" placeholder="Masukkan JJA Dosen"
            required autocomplete="jja_dosen"
            value="<?= isset($old['jja_dosen']) ? htmlspecialchars($old['jja_dosen']) : '' ?>">
        </label>

        <label for="txtNamaPasangan"><span>Nama Pasangan:</span>
          <input type="text" id="txtNamaPasangan" name="txtNamaPasangan" placeholder="Masukkan Nama Pasangan"
            required autocomplete="nama_pasangan"
            value="<?= isset($old['nama_pasangan']) ? htmlspecialchars($old['nama_pasangan']) : '' ?>">
        </label>

        <label for="txtNoHP"><span>Nomor Hp:</span>
          <input type="text" id="txtNoHP" name="txtNoHP" placeholder="Masukkan Nomor HP"
            required autocomplete="nomor_hp"
            value="<?= isset($old['nomor_hp']) ? htmlspecialchars($old['nomor_hp']) : '' ?>">
        </label>

        <label for="txtHomebaseProdi"><span>Homebase Prodi:</span>
          <input type="text" id="txtHomebaseProdi" name="txtHomebaseProdi" placeholder="Masukkan Homebase Prodi"
            required autocomplete="homebase_prodi"
            value="<?= isset($old['homebase_prodi']) ? htmlspecialchars($old['homebase_prodi']) : '' ?>">
        </label>

        <label for="txtNmAnak"><span>Nama Anak:</span>
          <input type="text" id="txtNmAnak" name="txtNmAnak" placeholder="Masukkan Nama Anak"
            required autocomplete="nama_anak"
            value="<?= isset($old['nama_anak']) ? htmlspecialchars($old['nama_anak']) : '' ?>">
        </label>

        <label for="txtBidangIlmu"><span>Bidang Ilmu Dosen:</span>
          <input type="text" id="txtBidangIlmu" name="txtBidangIlmu" placeholder="Masukkan Bidang Ilmu Dosen"
            required autocomplete="bidang_ilmu_dosen"
            value="<?= isset($old['bidang_ilmu_dosen']) ? htmlspecialchars($old['bidang_ilmu_dosen']) : '' ?>">
        </label>

        <button type="submit">Kirim</button>
        <button type="reset">Batal</button>
      </form>

      <br>
      <hr>
      <h2>Data Biodata Dosen</h2>
      <?php include 'readbiodatadosen_inc.php'; ?>
    </section>

    <?php
    $biodata = $_SESSION["biodata"] ?? [];

    $fieldConfig = [
      "kodedos" => ["label" => "Kode Dosen:", "suffix" => ""],
      "nama" => ["label" => "Nama Dosen:", "suffix" => " &#128526;"],
      "alamat" => ["label" => "Alamat Rumah:", "suffix" => ""],
      "tanggal" => ["label" => "Tanggal Jadi Dosen:", "suffix" => ""],
      "jja" => ["label" => "JJA Dosen:", "suffix" => " &#127926;"],
      "prodi" => ["label" => "Homebase Prodi:", "suffix" => " &hearts;"],
      "nohp" => ["label" => "Nomor HP:", "suffix" => " &copy; 2025"],
      "pasangan" => ["label" => "Nama Pasangan:", "suffix" => ""],
      "anak" => ["label" => "Nama Anak:", "suffix" => ""],
      "ilmu" => ["label" => "Bidang Ilmu Dosen:", "suffix" => ""],
    ];
    ?>

    <section id="about">
      <h2>Tentang Saya</h2>
      <?= tampilkanBiodata($fieldConfig, $biodata) ?>
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

        <button type=" submit">Kirim</button>
          <button type="reset">Batal</button>
      </form>

      <br>
      <hr>
      <h2>Yang menghubungi kami</h2>
      <?php include 'read_inc.php'; ?>
    </section>
  </main>

  <footer>
    <p>&copy; 2025 Moh.Sayyid Abraar [2511500015]</p>
  </footer>

  <script src="script.js"></script>
</body>

</html>