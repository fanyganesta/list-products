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
?>