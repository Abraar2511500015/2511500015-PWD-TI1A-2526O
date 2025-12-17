<?php
require 'koneksi.php';

$sql = "SELECT * FROM tbl_tamu ORDER BY cid DESC";
$q = mysqli_query($conn, $sql);
?>
<table border="1" cellpadding="8" cellspacing="0">
  <tr>
    <th>No</th>
    <th>Aksi</th>
    <th>ID</th>
    <th>Nama</th>
    <th>Email</th>
    <th>Pesan</th>
    <th>Tanggal dan Waktu</th>
  </tr>

  <?php $no = 1; 
    while ($row = mysqli_fetch_assoc($q)): ?>
    <tr>
    <td><?= $no++; ?></td>
    <td><a href="edit.php?cid=<?= $row['cid']; ?>">Edit</a></td>
    <td><?= $row['cid']; ?></td>
    <td><?= htmlspecialchars($row['cnama']); ?></td>
    <td><?= htmlspecialchars($row['cemail']); ?></td>
    <td><?= nl2br(htmlspecialchars($row['cpesan'])); ?></td>
    <td><?= $row['dcreated_at']; ?></td>
    </tr>
    <?php endwhile; ?>
</table>
