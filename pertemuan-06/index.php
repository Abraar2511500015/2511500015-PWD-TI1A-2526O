<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moh. Sayyid Abraar</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <h1>Moh. Sayyid Abraar</h1>
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
            echo "halo dunia!";
            echo "Perkenalkan nama saya Moh. Sayyid Abraar";
            ?>
            <p>Contoh paragraf html</p>
        </section>
        <section id="about">
            <?php
            $nim = "2511500015";
            $Nama = "Moh. Sayyid Abraar";
            $nama = "Abraar";
            $Tempatlahir = "Sungailiat";
            $Tanggallahir = "26 Januari 2007";
            $Hobi = "Bermain game dan membaca novel";
            $Pasangan = "Karinia Dwi Indah Suryani&heart;&#128525";
            $Pekerjaan ="Belum Ada";
            $NamaOrangTua = "Ayah Suhidin dan Ibu Affika Kushana";
            $NamaKakak = "-";
            $NamaAdik ="Moch Faaiq Al-Tsaqiif";
            ?>

            <h2>Tentang Saya</h2>
                <p><strong>NIM:</strong>
                    <?php
                        echo $nim;
                    ?>
                </p>
                <p><strong>Nama:</strong>
                    <?php
                        echo $Nama
                    ?>
                </p>
                <p><strong>Tempat Lahir:</strong>
                    <?php
                        echo $Tempatlahir
                    ?>
                </p>
                <p><strong>Tanggal Lahir:</strong>
                    <?php
                        echo $Tanggallahir
                    ?>
                </p>
                <p><strong>Hobi:</strong>
                    <?php
                        echo $Hobi
                    ?>
                </p>
                <p><strong>Pasangan:</strong>
                    <?php
                        echo $Pasangan
                    ?>
                </p>
                <p><strong>Pekerjaan:</strong>
                    <?php
                        echo $Pekerjaan
                    ?>
                </p>
                <p><strong>Nama Orang Tua:</strong>
                    <?php
                        echo $NamaOrangTua
                    ?>
                </p>
                <p><strong>Nama Kakak:</strong>
                    <?php
                        echo $NamaKakak
                    ?>
                </p>
                <p><strong>Nama Adik:</strong>
                    <?php
                        echo $NamaAdik
                    ?>
                </p>
        </section>
        <section id="contact">
            <h2>Kontak Saya</h2>
            <form action="" method="GET">
                <input type="color">
                <label for="txtNama"><span>Nama:</span>
                    <input maxlength="10" type="text" id="txtNama" name="txtNama" placeholder="Masukkan nama" required autocomplete="name">
                </label>    

                <label for="txtEmail"><span>Email:</span>
                     <input type="email" id="txtEmail" name="txtEmail" placeholder="Masukkan email" required autocomplete="email">
                </label>

                <label for="txtPesan"><span>Pesan:</span>
                     <textarea rows="4" id="txtPesan" name="txtPesan" placeholder="Tulis pesan anda..." required></textarea>
                     <small id="charCount">0/200 karakter</small>
                </label>
                <button type="submit">Kirim</button>
                <button type="reset">Batal</button>
            </form>
        </section>
    </main>
    <footer>
        <p>&copy; 2025 Moh. Sayyid Abraar [2511500015]</p>
    </footer>
    <script src="script.js"></script>
</body>
</html>


