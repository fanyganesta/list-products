<?php 
    require 'controller.php';
    checkLogin();
    $rows= index();
?>

<!DOCTYPE html>
<html> 
<head> 
    <title>List Product</title>
    <link rel="stylesheet" href="css-index.css">
</head>
<body> 
    <?php if(isset($_GET['message'])) : ?>
        <p class="message"> <?= $_GET['message'] ?></p>
    <?php elseif(isset($_GET['error'])) : ?>
        <p class="error"> <?= $_GET['error'] ?></p>
    <?php endif ?>

    <h3> Selamat datang</h3>
    <a href="tambah.php">Tambah Data</a> <p style="display: inline">|</p>
    <a href="logout.php">Keluar</a>
    <br> <br>
    <table class="br"> 
        <tr>
            <th> No. </th>
            <th> Nama Barang </th>
            <th> Variasi </th>
            <th> Jumlah Barang</th>
            <th> Harga Barang</th>
        </tr>
        <?php $i = 1; foreach($rows as $row) : ?>
            <tr> 
                <td class="ct"> <?= $i ?> </td>
                <td class="ct"> <?= $row['namaProduk'];?> </td>
                <td class="ct"> <?= $row['varianProduk'] ?> </td>
                <td class="ct"> <?= $row['jumlahProduk'] ?> </td>
                <td class="ct"> <?= $row['hargaProduk']; $i++ ?> </td>
            </tr>
        <?php endforeach ?>
    </table>
</body>