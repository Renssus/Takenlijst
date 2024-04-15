<?php
session_start();
require_once '../configs/config.php';
require_once '../configs/conn.php';
echo '<link rel="stylesheet" type="text/css" href="../css/style.css">';

// Controleer of de gebruiker een admin is
if (isset($_SESSION['ISADMIN']) && $_SESSION['ISADMIN'] === true) {
    // Als de gebruiker een admin is, stuur ze naar de admin-pagina
} else {
    // Als de gebruiker geen admin is, toon een bericht
    echo "U bent geen administrator";
    // Stop de uitvoering van verdere code om te voorkomen dat het formulier wordt getoond
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $admin = isset($_POST['admin']) ? 1 : 0;

    $hash = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO users (username, password, admin) VALUES (:username, :password, :admin)";
    $statement = $conn->prepare($query);
    $statement->execute([
        ':username' => $username, 
        ':password' => $hash,
        ':admin' => $admin
    ]);

    header("location: " . $base_url . "/stommeBugSysteemVanCurio/index.php");
}

    
?>

<!DOCTYPE html>
<html>
<?php require_once '../Configs/config.php'; ?>
<head>
<?php require_once '../resources/header.php'; ?>
    <title>Create Account</title>
</head>
<body>
    <form method="POST" action="">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br>

        <label for="admin">Admin:</label>
        <input type="checkbox" name="admin" id="admin"><br>

        <input type="submit" value="Create Account">
    </form>

</body>
</html>
