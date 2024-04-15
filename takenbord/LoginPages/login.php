<!doctype html>
<html lang="nl">
<?php require_once '../Configs/config.php'; ?>
<head>
    <title>Login Page</title>
    <meta charset="utf-8">
</head>

<body>
    <?php require_once '../resources/header.php'; ?>
    
    <div class="container home">
        <form action="<?php echo $base_url ?>/loginPages/loginController.php" method="POST">
            <input type="text" name="username" placeholder="Gebruikersnaam">
            <input type="password" name="password" placeholder="Wachtwoord">
            <input type="submit" value="Inloggen">
        </form>
    </div>
</body>

</html>
