<?php
require_once '../config/config.php';
require_once '../config/conn.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$url = $base_url . "/login/login.php";
$text = "Login";

if (isset($_SESSION['user_id'])) {
    $url = $base_url . "/login/logout.php";
    $text = "Uitloggen";
}
?>

<header>
    <div class="container">
        <div class="header">
            <h1>Takenbord DeveloperLand!</h1>
            <div>     
                    <a href="<?php echo $base_url; ?>/tasks/index.php">Home</a>
                    <a href="<?php echo $base_url; ?>/tasks/create.php">Create</a>
                    <a href="<?php echo $url; ?>"><?php echo $text; ?></a>
                    <?php
                    if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true) {
                        echo '<a  href="' . $base_url . '/tasks/admin.php">Maak een account (Admin Page)</a>';
                    }
                    ?>
           
            </div>
        </div>
    </div>
</header>