<?php
session_start();

$sesnama = "";
if (isset($_SESSION["sesnama"])):
  $sesnama = $_SESSION["sesnama"];
endif;

$sesemail = "";
if (isset($_SESSION["sesemail"])):
  $sesemail = $_SESSION["sesemail"];
endif;

$sespesan = "";
if (isset($_SESSION["sespesan"])):
  $sespesan = $_SESSION["sespesan"];
endif;
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
      echo "nama saya abraar";
      ?>
      <p>Ini contoh paragraf HTML.</p>
    </section>

    <section id="about">
      <?php
      $nim = 2511500015;
      $NIM = '2511500015';
      $nama = "Moh. Sayyid Abraar";
      $Nama = 'Abraar';
      $tempat = "Selindung";
      ?>
      <h2>Tentang Saya</h2>
      <p><strong>NIM:</strong>
        <?php
        echo $NIM;
        ?>
      </p>
      <p><strong>Nama Lengkap:</strong>
        <?php
        echo $nama;
        ?> &#128526;
      </p>
      <p><strong>Tempat Lahir:</strong> Sungailiat</p>
      <p><strong>Tanggal Lahir:</strong> 26 Januari 2007</p>
      <p><strong>Hobi:</strong> Bermain game dan membaca novel </p>
      <p><strong>Pasangan:</strong> Karinia Dwi Indah Suryani &#128525;&hearts;</p>
      <p><strong>Pekerjaan:</strong> Mahasiswa</p>
      <p><strong>Nama Orang Tua:</strong> Bapak Suhidin dan Ibu Affika Kushana</p>
      <p><strong>Nama Kakak:</strong> <?php echo $sespesan ?></p>
      <p><strong>Nama Adik:</strong> Moch. Faaiq Al-Tsaqiif</p>
    </section>

    <section id="contact">
      <h2>Kontak Kami</h2>
      <form action="proses.php" method="POST">

        <label for="txtNama"><span>Nama:</span>
          <input type="text" id="txtNama" name="txtNama" placeholder="Masukkan nama" required autocomplete="name">
        </label>

        <label for="txtEmail"><span>Email:</span>
          <input type="email" id="txtEmail" name="txtEmail" placeholder="Masukkan email" required autocomplete="email">
        </label>

        <label for="txtPesan"><span>Pesan Anda:</span>
          <textarea id="txtPesan" name="txtPesan" rows="4" placeholder="Tulis pesan anda..." required></textarea>
          <small id="charCount">0/200 karakter</small>
        </label>


        <button type="submit">Kirim</button>
        <button type="reset">Batal</button>
      </form>

      <?php if (!empty($sesnama)): ?>
        <br><hr>
        <h2>Yang menghubungi kami</h2>
        <p><strong>Nama :</strong> <?php echo $sesnama ?></p>
        <p><strong>Email :</strong> <?php echo $sesemail ?></p>
        <p><strong>Pesan :</strong> <?php echo $sespesan ?></p>
      <?php endif; ?>



    </section>
    <section id="Pendaftaran Profil Pengunjung">
      <h2>Pendaaftaran Profil Pengunjung </h2>
      <form action="proses.php" method="POST">

      <label for="txtNim"><span>Nim:</span>
          <input type="text" id="txtNim" name="txtNim" placeholder="Masukkan NIM" required autocomplete="nim">
        </label>
  </main>

  <footer>
    <p>&copy; 2025 Moh. Sayyid Abraar [2511500015]</p>
  </footer>

  <script src="script.js"></script>
</body>

</html>