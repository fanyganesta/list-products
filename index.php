<?php 
    require 'controller.php';
    checkLogin();
    $result = index();
    if(isset($_POST['cari'])){
        $result = cari();
    }
    $rows = $result[0];
    $jumlahHalaman = $result[2];
    $halamanAktif = $result[1];
    $cari = $result[3] ?? null;
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

    <form method="POST" action="index.php">
        <label for="cari"> Cari Produk:</label>
        <input type="text" name="cari" id="cari" value="<?= $cari ?>">
        <button type="submit" name="btn-cari">Cari</button>
    </form>

    <br>
    <table class="br"> 
        <tr>
            <?php if(count($rows) < 1) : ?>
                    <th> Tidak ada data ditemukan </th>
                </tr>
            </table>
            <?php else : ?>
                <th> No. </th>
                <th> Foto Produk </th>
                <th> Nama Barang </th>
                <th> Variasi </th>
                <th> Jumlah Barang</th>
                <th> Harga Barang</th>
                <th> Action </th>
            </tr>
            <?php $i = 1; foreach($rows as $row) : ?>
                <tr> 
                    <td class="ct"> <?= $i ?> </td>
                    <td class="ct">
                        <?php if(isset($row['img'])) : ?>   
                            <img src="img/<?= $row['img'] ?>" width=150>
                        </td>
                        <?php else : ?>
                            <p style="font-style:italic"> (Gambar belum tersedia)</p>
                        </td>
                        <?php endif ?>
                    <td class="ct"> <?= $row['namaProduk'];?> </td>
                    <td class="ct"> <?= $row['varianProduk'] ?> </td>
                    <td class="ct"> <?= $row['jumlahProduk'] ?> </td>
                    <td class="ct"> <?= $row['hargaProduk']; $i++ ?> </td>
                    <td class="ct"> 
                        <a href="ubah.php?ID=<?= $row['ID']?>">Ubah</a> 
                        <p style="display:inline">|</p>
                        <a href="hapus.php?ID=<?= $row['ID']?>" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                    </td>
                </tr>
            <?php endforeach ?>
            <?php if($jumlahHalaman > 1) : ?>
                <tr>
                    <th colspan="7">
                        <?php if($halamanAktif > 1) : ?>
                            <a href="?halaman=<?= $halamanAktif - 1 ?>" style="font-size: 12px"> <</a>
                        <?php endif ?>                            
                        <?php for($j = 1; $j <= $jumlahHalaman; $j++): ?>
                            <?php if($j < $halamanAktif+2 && $j > $halamanAktif-2) : ?>
                                <?php if($j == $halamanAktif) : ?>
                                    <p style="color:black; font-weight:bold; font-size:19px; display:inline;"><?= $j?></p>
                                <?php else : ?>
                                    <a href="?halaman=<?= $j?>"> <?= $j ?></a>
                                <?php endif ?>
                            <?php endif ?>
                        <?php endfor ?>
                        <?php if($halamanAktif < $jumlahHalaman-2) : ?>
                            <p style="display: inline"> ... </p>
                        <?php endif ?>
                        <?php if($halamanAktif != $jumlahHalaman && $halamanAktif < $jumlahHalaman-1) : ?>
                            <a href="?halaman=<?= $jumlahHalaman?>"><?= $jumlahHalaman ?></a>
                        <?php endif ?>
                        <?php if($halamanAktif != $jumlahHalaman) : ?>
                            <a href="?halaman=<?= $halamanAktif + 1 ?>" style="font-size:12px"> ></a>
                        <?php endif ?>
                    </th>
                </tr> 
            <?php endif ?>

        </table>
        <?php endif ?>
</body>