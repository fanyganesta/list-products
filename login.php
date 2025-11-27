<!DOCTYPE html>
<html> 
<head> 
    <title>Login</title>
</head>
<body> 
    <?php if(isset($_GET['message'])) : ?>
        <p class="message"> <?= $_GET['message'] ?></p>
    <?php elseif(isset($_GET['error'])) : ?>
        <p class="error"> <?= $_GET['error'] ?></p>
    <?php endif ?>

    <h3> Selamat datang, silahkan login</h3>
</body>