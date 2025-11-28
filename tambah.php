<?php 
    require 'controller.php';
    checkLogin();
    if(isset($_POST['btn-tambah'])){
        tambah();
    }
?>

<!DOCTYPE html>
<html> 
<head>
    <title> Tambah Data </title>
    <link rel="stylesheet" href="css-index.css">
</head>
<body> 

    <h3>Tambah data product</h3>
    <a href="index.php">Kembali ke beranda</a>
    <br><br>
    <form method="POST" action="" enctype="multipart/form-data">
        <table>
            <tr> 
                <td> <label for="namaProduk">Nama Produk</label> </td>
                <td> <input type="text" name="namaProduk" id="namaProduk" required> </td>
            </tr>
            <tr>
                <td> <label for="varianProduk">Varian Produk</label></td>
                <td> <input type="text" name="varianProduk" id="varianProduk" required></td>
            </tr>
            <tr>
                <td> <label for="jumlahProduk">Jumlah Produk</label> </td>
                <td> <input type="text" name="jumlahProduk" id="jumlahProduk" required></td>
            </tr>
            <tr>
                <td> <label for="hargaProduk">Harga Produk</label></td>
                <td> <input type="hargaProduk" name="hargaProduk" id="hargaProduk" required></td>
            </tr>
            <tr> 
                <td> <label for="image">Upload File:</label> </td>
                <td> <input type="file" name="image" id="image" required> </td>
            <tr> 
                <td colspan="2" class="ct">
                    <button type="submit" name="btn-tambah">Tambah</button>
                </td> 
            </tr>
        </table>
    </form>
</body>
</html>