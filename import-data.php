<?php
    require 'controller.php';
    global $db;

    $data = $_GET['data'] ?? null;

    if($data == 'products'){
        $checkTable = "SELECT table_name FROM information_schema.tables WHERE table_schema = 'list_products' AND table_name = 'products'";
        $dbTable = dbPrepare($checkTable);
        
        if(mysqli_num_rows($dbTable) < 1){ 
            $createTable = "CREATE TABLE products (
                ID INT PRIMARY KEY AUTO_INCREMENT,
                namaProduk VARCHAR(100),
                varianProduk VARCHAR(100),
                jumlahProduk VARCHAR(100),
                hargaProduk INT(100)
            )";
            dbPrepare($createTable);
        }

        $queryInsert = "INSERT INTO products VALUES 
            ('', 'Laptop', 'Lenovo', '10' , '2000000'),
            ('', 'Laptop', 'MSI', '20', '5000000'),
            ('', 'Laptop', 'ASUS', '10', '3000000'),
            ('', 'Laptop', 'Acer', '4', '2000000'),
            ('', 'Monitor', 'Lenovo', '20', '1200000'),
            ('', 'Monitor', 'Samsung', '40', '2000000'),
            ('', 'Monitor', 'Xiaomi', '20', '1300000'),
            ('', 'Monitor', 'DELL', '10', '1200000'),
            ('', 'Speaker', 'Leviosa', '14', '400000'),
            ('', 'Speaker', 'JBL', '13', '500000'),
            ('', 'Speaker', 'Samsung', '11', '400000')
        ";

        $result = dbPrepare($queryInsert);
        if($result){
            header("Location: login.php?message=Data berhasil diproses");
            exit;
        }else{
            header("Location: login.php?error=Data gagal diproses");
            exit;
        }   
    }elseif($data == 'users'){
        $checkUsers = "SELECT table_name FROM information_schema.tables WHERE table_schema = 'list_products' AND table_name = 'users'";
        $tableUsers = dbPrepare($checkUsers);
        if(mysqli_num_rows($tableUsers) < 1){
            $createUsers = "CREATE TABLE users (
                ID INT PRIMARY KEY AUTO_INCREMENT,
                username VARCHAR(100),
                password VARCHAR(255)
            )";
            $result = dbPrepare($createUsers);
            if(!$result){
                header("Location: login.php?error=Periksa sintaks");
                exit;
            }
        }
        $password = password_hash('123', PASSWORD_DEFAULT);
        $insertUsers = "INSERT INTO users VALUE (
            '', 'fany', '$password'
        )";
        $result = dbPrepare($insertUsers);
        if($result){
            header("Location: login.php?message=Data users berhasil ditambahkan");
            exit;
        }else{
            header("Location: login.php?error=Data gagal ditambahkan, periksa sintaks");
            exit;
        }
    }else{
        header("Location: login.php?error=Masukkan perintah apa yang mau ditambah");
        exit;
    }


    function dbPrepare($query, $param = null, $value = null){
        global $db;
        $prepQuery = $db->prepare($query);
        if(!isset($prepQuery)){
            header("Location: login.php?error=Gagal, cek sintaks SQL");
            exit;
        }

        $queryExplode = explode(' ', $query)[0];
        if($queryExplode == 'INSERT'){
           return $prepQuery->execute();
        }
        $prepQuery->execute();
        $result = $prepQuery->get_result();
        return $result;
    }




?>