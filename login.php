<?php 
    require 'controller.php';
    if(isset($_POST['btn-login'])){
        login();
    }

?>

<!DOCTYPE html>
<html> 
<head> 
    <title>Login</title>
    <link rel="stylesheet" href="css-index.css">
</head>
<body> 
    <?php if(isset($_GET['message'])) : ?>
        <p class="message"> <?= $_GET['message'] ?></p>
    <?php elseif(isset($_GET['error'])) : ?>
        <p class="error"> <?= $_GET['error'] ?></p>
    <?php endif ?>

    <h3> Selamat datang, silahkan login</h3>

    <form method="POST" action=""> 
        <table> 
            <tr>
                <td> <label for="username">Username:</label> </td>
                <td> <input name="username" id="username" type="text"> </td>
            </tr>
            <tr> 
                <td> <label for="password">Password:</label> </td>
                <td> <input name="password" type="password" id="password"> </td>
            </tr>
            <tr> 
                <td colspan="2" class="ct">
                    <input type="checkbox" name="rememberme" id="rememberme">
                    <label for="rememberme">Remember Me</label>
                </td>
            </tr>
            <tr> 
                <td colspan="2" class="ct"> 
                    <button type="submit" name="btn-login">Login</button>
                </td>
            </tr>
        </table>
    </form>
</body>