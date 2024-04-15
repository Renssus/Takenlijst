<?php
require_once '../configs/config.php';
require_once '../configs/conn.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$url = $base_url . "/LoginPages/login.php";
$text = "Login";

if (isset($_SESSION['user_id'])) {
    $url = $base_url . "/LoginPages/logout.php";
    $text = "Uitloggen";
}
?>

<header>
    <div class="container">
        <nav class="d-flex align-items-center">
            <h1 class="me-4">Takenbord DeveloperLand!</h1>
            <a class="me-4" href="<?php echo $base_url; ?>/stommeBugSysteemVanCurio/index.php">Home</a>
            <a class="me-4" href="<?php echo $base_url; ?>/stommeBugSysteemVanCurio/Create.php">Create</a>
            <div>
                <p>
                    <a class="me-4" href="<?php echo $url; ?>"><?php echo $text; ?></a>
                </p>
            </div>
            <?php
            if (isset($_SESSION['ISADMIN']) && $_SESSION['ISADMIN'] === true) {
                echo '<a  href="' . $base_url . '/stommeBugSysteemVanCurio/adminpanel.php">Maak een account (Admin Page)</a>';
            }
            ?>
        </nav>
    </div>
</header>
