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
            $Pasangan = "Karinia Dwi Indah Suryani&#128525";
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

        <section id="IPK">
            <h2>IPK Saya</h2>
            <?php
            $namaMatkul1 = "Logika Informatika";
            $namaMatkul2 = "Pengantar Teknik Informatika";
            $namaMatkul3 = "Kalkulus";
            $namaMatkul4 = "Wawasan Berbudi Luhur";
            $namaMatkul5 = "Aplikasi Perkantoran";

            $sksMatkul1 = 4;
            $sksMatkul2 = 4;
            $sksMatkul3 = 4;
            $sksMatkul4 = 4;
            $sksMatkul5 = 4;

            $nilaiHadir1 = 100;
            $nilaiTugas1 = 90;
            $nilaiUTS1 = 92;
            $nilaiUAS1 = 88;
            $nilaiAkhir1 = (0.1 * $nilaiHadir1) + (0.2 * $nilaiTugas1) + (0.3 * $nilaiUTS1) + (0.4 * $nilaiUAS1);

            $nilaiHadir2 = 95;
            $nilaiTugas2 = 96;
            $nilaiUTS2 = 92;
            $nilaiUAS2 = 88;
            $nilaiAkhir2 = (0.1 * $nilaiHadir2) + (0.2 * $nilaiTugas2) + (0.3 * $nilaiUTS2) + (0.4 * $nilaiUAS2);

            $nilaiHadir3 = 100;
            $nilaiTugas3 = 90;
            $nilaiUTS3 = 92;
            $nilaiUAS3 = 90;
            $nilaiAkhir3 = (0.1 * $nilaiHadir3) + (0.2 * $nilaiTugas3) + (0.3 * $nilaiUTS3) + (0.4 * $nilaiUAS3);

            $nilaiHadir4 = 100;
            $nilaiTugas4 = 95;
            $nilaiUTS4 = 95;
            $nilaiUAS4 = 90;
            $nilaiAkhir4 = (0.1 * $nilaiHadir4) + (0.2 * $nilaiTugas4) + (0.3 * $nilaiUTS4) + (0.4 * $nilaiUAS4);

            $nilaiHadir5 = 100;
            $nilaiTugas5 = 98;
            $nilaiUTS5 = 92;
            $nilaiUAS5 = 95;
            $nilaiAkhir5 = (0.1 * $nilaiHadir5) + (0.2 * $nilaiTugas5) + (0.3 * $nilaiUTS5) + (0.4 * $nilaiUAS5);
            // Diatas ini adalah variabel untuk store value dari tiap variabel dan menghitung nilai akhir

            function hitungGrade($hadir, $akhir): string 
            {
                if ($hadir <70) return "E"; 
                elseif ($akhir >= 90) return "A";
                elseif ($akhir >= 80) return "A-"; 
                elseif ($akhir >= 75) return "B+";
                elseif ($akhir >= 70) return "B";
                elseif ($akhir >= 65) return "B-";
                elseif ($akhir >= 60) return "C+";
                elseif ($akhir >= 55) return "C";
                elseif ($akhir >= 50) return "C-";
                elseif ($akhir >= 35) return "D";
                else return "E";
            }

            function hitungMutu($grade): float
            {
                switch ($grade) {
                    case "A":
                        return 4.0;
                    case "A-":
                        return 3.7;
                    case "B+":
                        return 3.3;
                    case "B":
                        return 3.0;
                    case "B-":
                        return 2.7;
                    case "C+":
                        return 2.3;
                    case "C":
                        return 2.0;
                    case "C-":
                        return 1.7;
                    case "D":
                        return 1.0;
                    default:
                        return 0.0;
                }
            }
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


