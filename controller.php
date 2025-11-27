<?php 
    $db = mysqli_connect('localhost', 'root', '', 'list_products');

    function login(){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $rememberme = isset($_POST['rememberme']) ?? null;

        var_dump($username,$password,$rememberme);die;
    }


?>