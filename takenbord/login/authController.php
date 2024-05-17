<?php
session_start();

require_once '../config/conn.php';

$username = $_POST['username'];
$password = $_POST['password'];

enum STATUS
{
    case NOT_FOUND;
    case INVALID_PASSWORD;
    case SUCCESS;
}

function loginUser($username, $password, $conn)
{
    $query = "SELECT * FROM users WHERE username = :username";
    $statement = $conn->prepare($query);
    $statement->execute([':username' => $username]);
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    if ($statement->rowCount() < 1) {
        return STATUS::NOT_FOUND;
    }

    if (!password_verify($password, $user['password'])) {
        return STATUS::INVALID_PASSWORD;
    }

    $_SESSION['logged_in'] = true;
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_name'] = $user['username'];

    if ($user['admin']) {
        $_SESSION["is_admin"] = true;
    }

    return STATUS::SUCCESS;
}

function registerUser($username, $password, $admin, $conn)
{
    $query = "INSERT INTO users (username, password, admin) VALUES(:username, :password, :admin)";

    $statement = $conn->prepare($query);
    $statement->execute([
        ':username' => $username,
        ":password" => password_hash($password, PASSWORD_DEFAULT),
        ":admin" => $admin
    ]);

    return $statement->fetch(PDO::FETCH_ASSOC);
}

function fetchData($id, $conn)
{
    $query = "SELECT * FROM users WHERE id = :id";
    $statement = $conn->prepare($query);
    $statement->execute([':id' => $id]);
    $user = $statement->fetch(PDO::FETCH_ASSOC);
    return $user;
}

if ($_GET["action"] == "login") {
    if (isset($_POST["username"]) && isset($_POST["password"])) {
        if ($status = loginUser($_POST["username"], $_POST["password"], $conn)) {
            if ($status == STATUS::SUCCESS) {
                header("location: " . $base_url . "/tasks/index.php");
                die();
            } else if ($status == STATUS::INVALID_PASSWORD) {
                header("location: " . $base_url . "/login/login.php?msg=Wachtwoord klopt niet!");
                die();
            } else if ($status == STATUS::NOT_FOUND) {
                header("location: " . $base_url . "/login/login.php?msg=Geen account gevonden!");
                die();
            }
        }
    }
}

if ($_GET["action"] == "register") {
    if (isset($_POST["username"]) && isset($_POST["password"])) {

        $admin = 0;
        if (isset($_POST["admin"]))
            $admin = 1;
        
        if ($status = registerUser($_POST["username"], $_POST["password"],$admin, $conn) && $status) {
            header("location: " . $base_url . "/login/login.php?msg=Je mag nu inloggen!");
            die();
        }
    }
}

header("location: " . $base_url . "/login/login.php");
die();
