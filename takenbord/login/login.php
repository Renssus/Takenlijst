<?php
require_once '../config/config.php';
require_once '../resources/head.php';
setTitle("Login Page");
?>

<body>
    <?php require_once '../resources/header.php'; ?>

    <div class="container home">
        <h1>Login</h1>
        
        <form action="<?php echo $base_url ?>/login/authController.php?action=login" method="POST">
            <input type="text" name="username" placeholder="Gebruikersnaam">
            <input type="password" name="password" placeholder="Wachtwoord">
            <input type="submit" value="Inloggen">

            <a href="register.php">Heb je geen account?</a>
        </form>
    </div>
</body>