<?php 
    require 'controller.php';
    checkLogin();


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
    <table class="br"> 
        <tr>
            <th> No. </th>
            <th> Nama Barang </th>
            <th> Variasi </th>
            <th> Jumlah Barang</th>
            <th> Harga Barang</th>
        </tr>
        <tr> 
            <td class="ct"> </td>
            <td class="ct"> </td>
            <td class="ct"> </td>
            <td class="ct"> </td>
            <td class="ct"> </td>
        </tr>
    </table>
</body>