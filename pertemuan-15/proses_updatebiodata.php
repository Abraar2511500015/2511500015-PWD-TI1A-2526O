<?php
  session_start();
  require __DIR__ . '/koneksi.php';
  require_once __DIR__ . '/fungsi.php';

  #cek method form, hanya izinkan POST
  if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['flash_error'] = 'Akses tidak valid.';
    redirect_ke('readbiodata.php');
  }

  #validasi cid wajib angka dan > 0
  $cid = filter_input(INPUT_POST, 'cid', FILTER_VALIDATE_INT, [
    'options' => ['min_range' => 1]
  ]);

  if (!$cid) {
    $_SESSION['flash_error'] = 'CID Tidak Valid.';
    redirect_ke('editbiodata.php?cid='. (int)$cid);
  }

  #ambil dan bersihkan (sanitasi) nilai dari form
  $nim = bersihkan($_POST['txtNimEd'] ?? '');
  $nama = bersihkan($_POST['txtNamaLengkapEd'] ?? '');
  $tempatlahir = bersihkan($_POST['txtTempatLahirEd'] ?? '');
  $tanggallahir = bersihkan($_POST['txtTanggalLahirEd'] ?? '');
  $hobi = bersihkan($_POST['txtHobiEd'] ?? '');
  $pasangan = bersihkan($_POST['txtPasanganEd'] ?? '');
  $pekerjaan = bersihkan($_POST['txtKerjaEd'] ?? '');
  $namaOrangTua = bersihkan($_POST['txtNamaOrangTuaEd'] ?? '');
  $namaKakak = bersihkan($_POST['txtNamaKakakEd'] ?? '');
  $namaAdik = bersihkan($_POST['txtNamaAdikEd'] ?? '');
  #Validasi sederhana
  $errors = []; #ini array untuk menampung semua error yang ada

    if ($nim === '') {
        $errors[] = 'NIM wajib diisi.';
    }

    if ($nama === '') {
        $errors[] = 'Nama Lengkap wajib diisi.';
    }

    if($tempatlahir === '') {
        $errors[] = 'Tempat Lahir wajib diisi.';
    }

    if ($tanggallahir === '') {
        $errors[] = 'Tanggal Lahir wajib diisi.';
    }

    if ($hobi === '') {
        $errors[] = 'Hobi wajib diisi.';
    }

    if ($pasangan === '') {
        $errors[] = 'Pasangan wajib diisi.';
    }

    if ($pekerjaan === '') {
        $errors[] = 'Pekerjaan wajib diisi.';
    }

    if ($namaOrangTua === '') {
        $errors[] = 'Nama Orang Tua wajib diisi.';
    }

    if ($namaKakak === '') {
        $errors[] = 'Nama Kakak wajib diisi.';
    }

    if ($namaAdik === '') {
        $errors[] = 'Nama Adik wajib diisi.';
    }

    

  /*
  kondisi di bawah ini hanya dikerjakan jika ada error, 
  simpan nilai lama dan pesan error, lalu redirect (konsep PRG)
  */
  if (!empty($errors)) {
    $_SESSION['old'] = [
        'nim'  => $nim,
        'nama_lengkap' => $nama,
        'tempat_lahir' => $tempatlahir,
        'tanggal_lahir' => $tanggallahir,
        'hobi' => $hobi,
        'pasangan' => $pasangan,
        'pekerjaan' => $pekerjaan,
        'nama_orang_tua' => $namaOrangTua,
        'nama_kakak' => $namaKakak,
        'nama_adik' => $namaAdik,
    ];

    $_SESSION['flash_error'] = implode('<br>', $errors);
    redirect_ke('editbiodata.php?cid='. (int)$cid);
  }

  /*
    Prepared statement untuk anti SQL injection.
    menyiapkan query UPDATE dengan prepared statement 
    (WAJIB WHERE cid = ?)
  */
  $stmt = mysqli_prepare($conn, "UPDATE tbl_biodata 
                                SET cnim = ?, cnama_lengkap = ?, ctempat_lahir = ?, ctanggal_lahir = ?, chobi = ?, cpasangan = ?, cpekerjaan = ?, cnama_orang_tua = ?, cnama_kakak = ?, cnama_adik = ? 
                                WHERE cid = ?");
  if (!$stmt) {
    #jika gagal prepare, kirim pesan error (tanpa detail sensitif)
    $_SESSION['flash_error'] = 'Terjadi kesalahan sistem (prepare gagal).';
    redirect_ke('editbiodata.php?cid='. (int)$cid);
  }

  #bind parameter dan eksekusi (s = string, i = integer)
  mysqli_stmt_bind_param($stmt, "sssi", $nim, $nama, $tempatlahir, $tanggallahir, $hobi, $pasangan, $pekerjaan, $namaOrangTua, $namaKakak, $namaAdik, $cid);
  if (mysqli_stmt_execute($stmt)) { #jika berhasil, kosongkan old value
    unset($_SESSION['old']);
    /*
      Redirect balik ke read.php dan tampilkan info sukses.
    */
    $_SESSION['flash_sukses'] = 'Terima kasih, data Anda sudah diperbaharui.';
    redirect_ke('readbiodata.php'); #pola PRG: kembali ke data dan exit()
  } else { #jika gagal, simpan kembali old value dan tampilkan error umum
    $_SESSION['old'] = [
        'nim'  => $nim,
        'nama_lengkap' => $nama,
        'tempat_lahir' => $tempatlahir,
        'tanggal_lahir' => $tanggallahir,
        'hobi' => $hobi,
        'pasangan' => $pasangan,
        'pekerjaan' => $pekerjaan,
        'nama_orang_tua' => $namaOrangTua,
        'nama_kakak' => $namaKakak,
        'nama_adik' => $namaAdik,
    ];
    $_SESSION['flash_error'] = 'Data gagal diperbaharui. Silakan coba lagi.';
    redirect_ke('editbiodata.php?cid='. (int)$cid);
  }
  #tutup statement
  mysqli_stmt_close($stmt);

  redirect_ke('editbiodata.php?cid='. (int)$cid);