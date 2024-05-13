<?php
session_start();

require_once '../Configs/conn.php';

$username = $_POST['username'];
$password = $_POST['password'];

$query = "SELECT * FROM users WHERE username = :username";
$statement= $conn->prepare($query);
$statement->execute([':username' => $username]);
$user = $statement->fetch(PDO::FETCH_ASSOC);

if($statement->rowCount() < 1){
    echo "Gebruiker niet gevonden";
    exit;
}

if(!password_verify($password , $user['password'])) {
    echo "Wachtwoord incorrect";
    echo "<br> <a href='../loginpages/login.php'>Terug naar inloggen</a>";
    exit;
}
// Login op true zetten
$_SESSION['logged_in'] = true;
// Informatie opslaan
$_SESSION['user_id'] = $user['id'];
$_SESSION['user_name'] = $user['username'];
$user = array( 'admin' => $user['admin'] );

$userId = $_SESSION['user_id'];

if ($user['admin'] == 1) {
    $ISADMIN = true;

    $_SESSION['ISADMIN'] = true;
} else {
    $ISADMIN = false;
}

header("location: ". $base_url ."/StommeBugSysteemVanCurio/index.php");

?>