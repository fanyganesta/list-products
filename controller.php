<?php 
    $db = mysqli_connect('localhost', 'root', '', 'list_products');

    function login(){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $rememberme = isset($_POST['rememberme']) ?? null;
 
        $checkUsername = "SELECT * FROM users WHERE username = ?";
        $value[] = $username; 
        $resultCheck = dbPrepare($checkUsername, 's', $value);
        if(mysqli_num_rows($resultCheck) < 1){
            header("Location: login.php?error=Username atau Password salah");
            exit;
        }
        $rows = $resultCheck->fetch_assoc();
        $dbPassword = $rows['password'];
        $checkPassword = password_verify($password, $dbPassword);
        if(!$checkPassword){
            header("Location: login.php?error=Username atau Password salah");
            exit;
        }
        session_start();
        $_SESSION['user'] = $username;

        $token = hash('sha512', $username);
        if($rememberme){
            setcookie('key', $rows['ID'], time()+3600);
            setcookie('token', $token, time()+3600);
        }

        header("Location: index.php?message=Anda berhasil login");
        exit;

    }


    function checkLogin(){
        session_start();
        if(isset($_COOKIE['key']) && isset($_COOKIE['token'])){
            $checkID = "SELECT * FROM users WHERE ID = ?";
            $value[] = $_COOKIE['key']; 
            $result = dbPrepare($checkID, 's', $value);
            if(mysqli_num_rows($result) < 1){
                header("Location: login.php?error=Anda harus login dahulu");
                exit;
            }
            $dbUsername = $result->fetch_assoc()['username'];
            if($_COOKIE['token'] === hash('sha512', $dbUsername)){
                $_SESSION['user'] = $dbUsername;
            }else{
                header("Location: login.php?error=Anda tidak punya akses, harus login dahulu");
                exit;
            }
        }elseif(!isset($_SESSION['user'])){
            header("Location: login.php?error=Anda harus login dahulu");
            exit;
        }
    }

    function dbPrepare($query, $param = null, $value = null, $stack = null){
        global $db;
        $checker = explode(' ', $query)[0];
        $prepQuery = $db->prepare($query);
        if($param){
            $prepQuery->bind_param($param, ...$value);    
        }
        if($checker == 'INSERT'){
            return $prepQuery->execute();
        }
        $prepQuery->execute();
        $result = $prepQuery->get_result();
        if($checker == 'SELECT' && isset($stack)){
            $rows = [];
            while($fetch = $result->fetch_assoc()){
                $rows[] = $fetch;
            }
            $result = $rows;
        }
        return $result;
    }


    function index(){
        $limit = 10;
        global $db;
        $totalDatas = mysqli_num_rows(mysqli_query($db, "SELECT * FROM products"));
        $jumlahHalaman = ceil($totalDatas / $limit);
        $halaman = $_GET['halaman'] ?? null;
        if(!$halaman || $halaman < 1 ){
            $halamanAktif = 1;
        }else{
            $halamanAktif = $_GET['halaman'];
        }
        $index = $halamanAktif * $limit - $limit;

        $query = "SELECT * FROM products LIMIT $index, $limit";
        $result = dbPrepare($query, null, null, true);
        $result = [$result, $halamanAktif, $jumlahHalaman];
        return $result;
    }


    function tambah(){
        $data = $_POST;
        $namaProduk = htmlspecialchars($data['namaProduk']);
        $varianProduk = htmlspecialchars($data['varianProduk']);
        $jumlahProduk = htmlspecialchars($data['jumlahProduk']);
        $hargaProduk = htmlspecialchars($data['hargaProduk']);
        $image = fileProcessing($_FILES['image']);


        $queryTambah = "INSERT INTO products (namaProduk, varianProduk, JumlahProduk, hargaProduk, img) VALUE(
            ?, ?, ?, ?, ?
        )";
        
        $result = dbPrepare($queryTambah, 'sssss', [$namaProduk, $varianProduk, $jumlahProduk, $hargaProduk, $image], null);
        if($result){
            header("Location: index.php?message=Data berhasil ditambahkan");
            exit;
        }else{
            header("Location: Gagal, periksa sintaks/code");
            exit;
        }
    }


    function get_ubah(){
        if(!isset($_GET['ID'])){
            header("Location: index.php?error=Pilih data yang akan dirubah dahulu");
            exit;
        }

        $queryGet = "SELECT * FROM products WHERE ID = ?";
        $result = dbPrepare($queryGet, 's', [$_GET['ID']], true);
        return $result;
    }



    function fileProcessing($data){
        $allowedExt = 'webp';
        $namaFile = $_FILES['image']['name'];
        $explodeName = explode('.', $namaFile);
        $extention = strtolower(end($explodeName));
        if($extention != $allowedExt){
            header("Location: index.php?error=Gambar tidak diperbolehkan");
            exit;
        }
        $size = $_FILES['image']['size'];
        $allowedSize = 100000;
        if($size >= $allowedSize){
            header("Location: index.php?error=File terlalu besar");
            exit;
        }
        $fileNewName = uniqid($explodeName[0]) . $extention;
        move_uploaded_file($_FILES['image']['tmp_name'], 'img/'.$fileNewName);

        return $fileNewName;
    }


    function ubah(){
        $ID = $_POST['ID'];
        $oldImage = htmlspecialchars($_POST['oldImg']) ?? null;
        $namaProduk = htmlspecialchars($_POST['namaProduk']);
        $varianProduk = htmlspecialchars($_POST['varianProduk']);
        $jumlahProduk = htmlspecialchars($_POST['jumlahProduk']);
        $hargaProduk = htmlspecialchars($_POST['hargaProduk']);
        $file = $_FILES['image'];

        if(!$oldImage && $file['error'] == 4){
            $image = null;
        }elseif($file['error'] == 4){
            $image = $oldImage;
        }else{
            $image = fileProcessing($file);
        }
        
        $queryUpdate = "UPDATE products SET
            namaProduk = ?, varianProduk = ?, jumlahProduk = ?, hargaProduk = ?, img = ?
         WHERE ID = ?";

        $result = dbPrepare($queryUpdate, 'ssssss', [$namaProduk, $varianProduk, $jumlahProduk, $hargaProduk, $image, $ID], null);

        var_dump($result);die;
    }
?>