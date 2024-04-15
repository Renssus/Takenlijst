<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Controleer of de gebruiker een admin is
if (isset($_SESSION['ISADMIN']) && $_SESSION['ISADMIN'] === true) {
    echo '<a  href="' . $base_url . '/LoginPages/admin.php">Maak een account</a>';
    exit;
} else {
    echo 'Je hebt geen toegang tot het admin panel.';
    exit;
}
?>
