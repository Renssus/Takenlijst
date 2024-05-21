<?php
require_once '../config/config.php';
require_once '../resources/head.php';
setTitle("Register Page");
?>

<body>
    <?php require_once '../resources/header.php'; ?>

    <div class="container home">
        <h1>Register</h1>
        <form action="<?php echo $base_url ?>/login/authController.php?action=register" method="POST">
            <input type="text" name="username" placeholder="Gebruikersnaam">
            <input type="password" name="password" placeholder="Wachtwoord">
            <input type="submit" value="Inloggen">

            <a href="login.php">Heb je een account?</a>
        </form>
    </div>
</body>