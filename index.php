<?php
include "koneksi.php";
$sql = "SELECT * FROM data_barang ORDER BY id_barang DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
    <title>Data Barang</title>
</head>

<body>
    <div class="container">
        <h1>Data Barang</h1>

        <p>
            <a class="btn" href="tambah.php">+ Tambah Data</a>
        </p>

        <table>
            <thead>
                <tr>
                    <th>Gambar</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Harga Beli</th>
                    <th>Harga Jual</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                <?php if ($result && $result->num_rows > 0): while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td>
                            <?php if (!empty($row['gambar']) && file_exists($row['gambar'])): ?>
                                <img src="<?= htmlspecialchars($row['gambar']) ?>" width="80">
                            <?php else: ?>
                                <span class="noimg">No Image</span>
                            <?php endif; ?>
                        </td>

                        <td><?= htmlspecialchars($row['nama']) ?></td>
                        <td><?= htmlspecialchars($row['kategori']) ?></td>
                        <td><?= number_format($row['harga_beli']) ?></td>
                        <td><?= number_format($row['harga_jual']) ?></td>
                        <td><?= $row['stok'] ?></td>

                        <td>
                            <a href="ubah.php?id=<?= $row['id_barang'] ?>">Ubah</a> |
                            <a href="hapus.php?id=<?= $row['id_barang'] ?>" onclick="return confirm('Hapus?')">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; else: ?>
                    <tr>
                        <td colspan="7">Belum ada data</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
