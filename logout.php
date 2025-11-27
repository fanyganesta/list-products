<?php 
    session_start();
    $_SESSION['user'] = '';
    session_destroy();
    header("Location: login.php?message=Anda berhasil keluar");



?>