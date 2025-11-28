<?php 
    require 'controller.php';
    checkLogin();
    if(!isset($_GET['ID'])){
        header("Location: index.php?error=Pilih data yang akan dihapus dahulu");
        exit;
    }

    $queryDelete = "DELETE FROM products WHERE ID = ?";
    $result = dbPrepare($queryDelete, 's', [$_GET['ID']], null);
    if($result){
        header("Location: index.php?message=Data berhasil dihapus");
        exit;
    }else{
        header("Location: index.php?error=Data gagal dihapus");
        exit;
    }

?>