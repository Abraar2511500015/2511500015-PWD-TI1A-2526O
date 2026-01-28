
<?php
  session_start();
  require __DIR__ . '/koneksi.php';
  require_once __DIR__ . '/fungsi.php';

  #cek method form, hanya izinkan POST
  if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['flash_error'] = 'Akses tidak valid.';
    redirect_ke('read.php');
  }

  #validasi cid wajib angka dan > 0
  $cid = filter_input(INPUT_POST, 'cid', FILTER_VALIDATE_INT, [
    'options' => ['min_range' => 1]
  ]);

  if (!$cid) {
    $_SESSION['flash_error'] = 'CID Tidak Valid.';
    redirect_ke('edit.php?cid='. (int)$cid);
  }

  #ambil dan bersihkan (sanitasi) nilai dari form
  $KodeDos = bersihkan($_POST['txtKodeDosEd'] ?? '');
  $NamaDosen = bersihkan($_POST['txtNmDosEd'] ?? '');
  $Alamat = bersihkan($_POST['txtAlRmhEd'] ?? '');
  $TanggalJadiDosen = bersihkan($_POST['txtTglDosenEd'] ?? '');
  $JJA = bersihkan($_POST['txtJJAEd'] ?? '');
  $NamaPasangan = bersihkan($_POST['txtNamaPasanganEd'] ?? '');
  $NomorHp = bersihkan($_POST['txtNoHPEd'] ?? '');
  $HomebaseProdi = bersihkan($_POST['txtProdiEd'] ?? '');
  $NamaAnak = bersihkan($_POST['txtNmAnakEd'] ?? '');
  $BidangIlmuDosen = bersihkan($_POST['txtBidangIlmuEd'] ?? '');
  #Validasi sederhana
  $errors = []; #ini array untuk menampung semua error yang ada

    if ($KodeDos === '') {
        $errors[] = 'Kode Dosen wajib diisi.';
    }

    if ($NamaDosen === '') {
        $errors[] = 'Nama Dosen wajib diisi.';
    }

    if($Alamat === '') {
        $errors[] = 'Alamat wajib diisi.';
    }

    if ($TanggalJadiDosen === '') {
        $errors[] = 'Tanggal Jadi Dosen wajib diisi.';
    }

    if ($JJA === '') {
        $errors[] = 'JJA wajib diisi.';
    }

    if ($NamaPasangan === '') {
        $errors[] = 'Nama Pasangan wajib diisi.';
    }

    if ($NomorHp === '') {
        $errors[] = 'Nomor HP wajib diisi.';
    }

    if ($HomebaseProdi === '') {
        $errors[] = 'Homebase Prodi wajib diisi.';
    }

    if ($NamaAnak === '') {
        $errors[] = 'Nama Anak wajib diisi.';
    }

    if ($BidangIlmuDosen === '') {
        $errors[] = 'Bidang Ilmu Dosen wajib diisi.';
    }

    

  /*
  kondisi di bawah ini hanya dikerjakan jika ada error, 
  simpan nilai lama dan pesan error, lalu redirect (konsep PRG)
  */
  if (!empty($errors)) {
    $_SESSION['old'] = [
        'kodedosen'  => $KodeDos,
        'namadosen' => $NamaDosen,
        'alamat' => $Alamat,
        'tanggaljadidosen' => $TanggalJadiDosen,
        'jja' => $JJA,
        'namapasangan' => $NamaPasangan,
        'nomorhp' => $NomorHp,
        'homebaseprodi' => $HomebaseProdi,
        'namaanak' => $NamaAnak,
        'bidangilmudosen' => $BidangIlmuDosen,
    ];

    $_SESSION['flash_error'] = implode('<br>', $errors);
    redirect_ke('edit.php?cid='. (int)$cid);
  }

  /*
    Prepared statement untuk anti SQL injection.
    menyiapkan query UPDATE dengan prepared statement 
    (WAJIB WHERE cid = ?)
  */
  $stmt = mysqli_prepare($conn, "UPDATE tbl_biodata_dosen
                                SET cKodeDosen = ?, cNamaDosen = ?, cAlamat = ?, cTanggalJadiDosen = ?, cJJA = ?, cNamaPasangan = ?, cNomorHp = ?, cHomebaseProdi = ?, cNamaAnak = ?, cBidangIlmuDosen = ? 
                                WHERE cid = ?");
  if (!$stmt) {
    #jika gagal prepare, kirim pesan error (tanpa detail sensitif)
    $_SESSION['flash_error'] = 'Terjadi kesalahan sistem (prepare gagal).';
    redirect_ke('edit.php?cid='. (int)$cid);
  }

  #bind parameter dan eksekusi (s = string, i = integer)
  mysqli_stmt_bind_param($stmt, "ssssssssssi", $KodeDos, $NamaDosen, $Alamat, $TanggalJadiDosen, $JJA, $NamaPasangan, $NomorHp, $HomebaseProdi, $NamaAnak, $BidangIlmuDosen, $cid);
  if (mysqli_stmt_execute($stmt)) { #jika berhasil, kosongkan old value
    unset($_SESSION['old']);
    /*
      Redirect balik ke read.php dan tampilkan info sukses.
    */
    $_SESSION['flash_sukses'] = 'Terima kasih, data Anda sudah diperbaharui.';
    redirect_ke('readbiodata.php'); #pola PRG: kembali ke data dan exit()
  } else { #jika gagal, simpan kembali old value dan tampilkan error umum
    $_SESSION['old'] = [
        'kodedosen'  => $KodeDos,
        'namadosen' => $NamaDosen,
        'alamat' => $Alamat,
        'tanggaljadidosen' => $TanggalJadiDosen,
        'jja' => $JJA,
        'namapasangan' => $NamaPasangan,
        'nomorhp' => $NomorHp,
        'homebaseprodi' => $HomebaseProdi,
        'namaanak' => $NamaAnak,
        'bidangilmudosen' => $BidangIlmuDosen,
    ];
    $_SESSION['flash_error'] = 'Data gagal diperbaharui. Silakan coba lagi.';
    redirect_ke('edit.php?cid='. (int)$cid);
  }
  #tutup statement
  mysqli_stmt_close($stmt);

  redirect_ke('edit.php?cid='. (int)$cid);