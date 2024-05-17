<?php
require_once '../config/config.php';
require_once '../resources/head.php';
setTitle("Admin Page");
?>

<body>
    <?php require_once '../resources/header.php'; ?>

    <div class="container home">
        <form action="<?php echo $base_url ?>/login/authController.php?action=register" method="POST">
            <h1>Register Niuewe Gebruiker</h1>
            
            <input type="text" name="username" placeholder="Gebruikersnaam">
            <input type="password" name="password" placeholder="Wachtwoord">
            
            <input type="checkbox" name="admin" id="admin">
            <label for="admin">Admin</label>

            <input type="submit" value="Inloggen">

            <a href="login.php">Heb je een account?</a>
        </form>
    </div>
</body>