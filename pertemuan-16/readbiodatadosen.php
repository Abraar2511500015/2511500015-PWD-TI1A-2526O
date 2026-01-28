<?php
  session_start();
  require 'koneksi.php';
  require 'fungsi.php';

  $sql = "SELECT * FROM tbl_biodata ORDER BY cid DESC";
  $q = mysqli_query($conn, $sql);
  if (!$q) {
    die("Query error: " . mysqli_error($conn));
  }
?>

<?php
  $flash_sukses = $_SESSION['flash_sukses'] ?? ''; #jika query sukses
  $flash_error  = $_SESSION['flash_error'] ?? ''; #jika ada error
  #bersihkan session ini
  unset($_SESSION['flash_sukses'], $_SESSION['flash_error']); 
?>

<?php if (!empty($flash_sukses)): ?>
        <div style="padding:10px; margin-bottom:10px; 
          background:#d4edda; color:#155724; border-radius:6px;">
          <?= $flash_sukses; ?>
        </div>
<?php endif; ?>

<?php if (!empty($flash_error)): ?>
        <div style="padding:10px; margin-bottom:10px; 
          background:#f8d7da; color:#721c24; border-radius:6px;">
          <?= $flash_error; ?>
        </div>
<?php endif; ?>

<table border="1" cellpadding="8" cellspacing="0">
  <tr>
    <th>No</th>
    <th>Aksi</th>
    <th>ID</th>
    <th>Kode Dosen</th>
    <th>Nama Dosen</th>
    <th>Alamat</th>
    <th>Tanggal Jadi Dosen</th>
    <th>JJA</th>
    <th>Nama Pasangan</th>
    <th>Nomor HP</th>
    <th>Homebase Prodi</th>
    <th>Nama Anak</th>
    <th>Bidang Ilmu Dosen</th>
    <th>Created At</th>
  </tr>
  <?php $i = 1; ?>
  <?php while ($row = mysqli_fetch_assoc($q)): ?>
    <tr>
      <td><?= $i++ ?></td>
      <td>
        <a href="editbiodatadosen.php?cid=<?= (int)$row['cid']; ?>">Edit</a>
        <a onclick="return confirm('Hapus <?= htmlspecialchars($row['cNamaDosen']); ?>?')" href="prosesdeletebiodatadosen.php?cid=<?= (int)$row['cid']; ?>">Delete</a>
      </td>
        <td><?= $row['cid']; ?></td>
        <td><?= htmlspecialchars($row['cKodeDosen']); ?></td>
        <td><?= htmlspecialchars($row['cNamaDosen']); ?></td>
        <td><?= htmlspecialchars($row['cAlamat']); ?></td>
        <td><?= htmlspecialchars($row['cTanggalJadiDosen']); ?></td>
        <td><?= htmlspecialchars($row['cJJA']); ?></td>
        <td><?= htmlspecialchars($row['cNamaPasangan']); ?></td>
        <td><?= htmlspecialchars($row['cNomorHP']); ?></td>
        <td><?= htmlspecialchars($row['cHomebaseProdi']); ?></td>
        <td><?= htmlspecialchars($row['cNamaAnak']); ?></td>
        <td><?= formatTanggal(htmlspecialchars($row['dcreated_at'])); ?></td>
    </tr>
  <?php endwhile; ?>
</table>