<?php 
    require 'controller.php';
    checkLogin();
    $rows = get_ubah()[0];
    if(isset($_POST['btn-ubah'])){
        ubah();
    }

?>

<!DOCTYPE html>
<html>
<head> 
    <title>Ubah Data</title>
    <link rel="stylesheet" href="css-index.css">
</head>
<body> 

    <h3>Ubah data, <?= $rows['namaProduk']?></h3>
    <a href="index.php">Kembali ke beranda</a>
    <br><br>

    <form method="POST" action="" enctype="multipart/form-data">
        <input type="hidden" name="ID" value="<?= $rows['ID']?>">
        <input type="hidden" name="oldImg" value="<?= $rows['img']?>">
        <table> 
            <tr> 
                <td class="ct" colspan="2"> 
                    <?php if(isset($rows['img'])) : ?>
                        <img style="margin-left: -60px" src="img/<?=$rows['img']?>" width="150">
                    <?php else : ?>
                        <p style="font-style:italic; margin-left: -60px"> (Gambar belum tersedia) </p>
                    <?php endif ?>
                </td>
            </tr>
            <tr> 
                <td> <label for="namaProduk">Nama Produk:</label> </td>
                <td> <input type="text" name="namaProduk" id="namaProduk" required value="<?= $rows['namaProduk']?>"> </td>
            </tr>
            <tr> 
                <td> <label for="varianProduk">Varian Produk</label></td>
                <td> <input type="text" name="varianProduk" id="varianProduk" required value="<?= $rows['varianProduk']?>"> </td>
            </tr>
            <tr> 
                <td> <label for="jumlahProduk">Jumlah Produk</label></td>
                <td> <input type="text" name="jumlahProduk" id="jumlahProduk" required value="<?= $rows['jumlahProduk']?>"> </td>
            </tr>
            <tr> 
                <td> <label for="hargaProduk">Harga Produk</label> </td>
                <td> <input type="hargaProduk" name="hargaProduk" id="hargaProduk" required value="<?= $rows['hargaProduk']?>"> </td>
            </tr>
            <tr> 
                <td> <label for="image">Upload file:</label> </td>
                <td> <input type="file" name="image" id="image"> </td>
            </tr>
            <tr> 
                <td colspan="2" class="ct"> 
                    <button type="submit" name="btn-ubah">Ubah</button>
                </td>
        </table>
    </form>

</body>
</html>