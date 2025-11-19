<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once 'koneksi.php';
$errors=[];
if($_SERVER['REQUEST_METHOD']==='POST'){
    $nama=$_POST['nama']; $kategori=$_POST['kategori'];
    $harga_jual=(float)$_POST['harga_jual']; $harga_beli=(float)$_POST['harga_beli'];
    $stok=(int)$_POST['stok']; $gambar_path=null;
    if(!empty($_FILES['file_gambar'])&&$_FILES['file_gambar']['error']===0){
        $fn=preg_replace('/[^A-Za-z0-9_\.]/','_',$_FILES['file_gambar']['name']);
        $dir=__DIR__.'/gambar/';
        if(!is_dir($dir)) mkdir($dir,0755,true);
        $target=$dir.time().'_'.$fn;
        if(move_uploaded_file($_FILES['file_gambar']['tmp_name'],$target))
            $gambar_path='gambar/'.basename($target);
    }
    $stmt=$conn->prepare("INSERT INTO data_barang (nama,kategori,harga_jual,harga_beli,stok,gambar) VALUES (?,?,?,?,?,?)");
    $stmt->bind_param("ssddis",$nama,$kategori,$harga_jual,$harga_beli,$stok,$gambar_path);
    if($stmt->execute()) { header("Location: index.php"); exit; }
    else { $errors[] = "Error: " . $stmt->error; }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
    <title>Tambah Barang</title>
    <style>
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input, .form-group select { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; }
        .form-group input[type="file"] { padding: 5px; }
        .form-buttons { margin-top: 20px; }
        .form-buttons button { padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; }
        .form-buttons button:hover { background-color: #0056b3; }
        .error-msg { color: red; margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Tambah Barang</h1>
        <?php if(!empty($errors)): ?>
            <div class="error-msg">
                <?php foreach($errors as $error) echo "<p>$error</p>"; ?>
            </div>
        <?php endif; ?>
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>Nama Barang</label>
                <input type="text" name="nama" required>
            </div>
            <div class="form-group">
                <label>Kategori</label>
                <select name="kategori" required>
                    <option value="">-- Pilih Kategori --</option>
                    <option value="Komputer">Komputer</option>
                    <option value="Elektronik">Elektronik</option>
                    <option value="Hand Phone">Hand Phone</option>
                </select>
            </div>
            <div class="form-group">
                <label>Harga Jual</label>
                <input type="number" name="harga_jual" step="0.01" required>
            </div>
            <div class="form-group">
                <label>Harga Beli</label>
                <input type="number" name="harga_beli" step="0.01" required>
            </div>
            <div class="form-group">
                <label>Stok</label>
                <input type="number" name="stok" required>
            </div>
            <div class="form-group">
                <label>File Gambar</label>
                <input type="file" name="file_gambar" accept="image/*">
            </div>
            <div class="form-buttons">
                <button type="submit">Simpan</button>
            </div>
        </form>
    </div>
</body>
</html>