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

        header("Location: index.php?message=Anda berhasil login");
        exit;

    }


    function checkLogin(){
        session_start();
        if(!isset($_SESSION['user'])){
            header("Location: login.php?error=Anda harus login dahulu");
            exit;
        }
    }

    function dbPrepare($query, $param = null, $value = null){
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
        return $result;
    }


?>