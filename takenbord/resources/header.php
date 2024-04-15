<?php
require_once '../configs/config.php';
require_once '../configs/conn.php';
?>

<header>
    <div class="container">
        <nav class="d-flex align-items-center">
            <h1 class="me-4">Takenbord DeveloperLand!</h1>
            <a class="me-4" href="<?php echo $base_url; ?>/stommeBugSysteemVanCurio/index.php">Home</a>
            <a class="me-4" href="<?php echo $base_url; ?>/stommeBugSysteemVanCurio/Create.php">Create</a>
            <div>
                <?php 
                if(isset($_SESSION['user_id'])) {
                    $ingelogd = true;
                } else {
                    $ingelogd = false;
                }
                if($ingelogd): ?>
                    <p><a class="me-4" href="<?php echo $base_url; ?>/LoginPages/logout.php">Uitloggen</a></p>
                <?php else: ?>
                    <p><a class="me-4" href="<?php echo $base_url; ?>/LoginPages/login.php">Inloggen</a></p>
                <?php endif; ?>
            </div>
            <?php 
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            // Controleer of de gebruiker een admin is
            if (isset($_SESSION['ISADMIN']) && $_SESSION['ISADMIN'] === true) {
                // Als de gebruiker een admin is, stuur ze naar de admin-pagina
                echo '<a  href="' . $base_url . '/stommeBugSysteemVanCurio/adminpanel.php">Maak een account (Admin Page)</a>';
            }    
            ?>
        </nav>
    </div>
</header>
