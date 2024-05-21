<?php
require_once '../config/conn.php';
require_once 'helperFunctions.php';

if ($_GET['action'] == 'create') {
    $taak = $_POST['taak'];
    $sector = $_POST['sector'];
    $deadline = $_POST['deadline'];
    $assignedToUserId = $_POST['assignedToUserId'];
    $status = $_POST['status'];
    $createdByUserId = $_POST['createdByUserId'];

    $query = "INSERT INTO taken (taak, sector, deadline, asignedTo, status, createdBy) VALUES (:taak, :sector, :deadline, :asignedTo, :status, :createdBy)";

    $statement = $conn->prepare($query);

    $statement->execute([
        ":taak" => $taak,
        ":sector" => $sector,
        ":deadline" => $deadline,
        ":asignedTo" => $assignedToUserId,
        ":status" => $status,
        ":createdBy" => $createdByUserId,
    ]);

    header("location: " . $base_url . "/tasks/index.php");

    die();
}

if ($_GET['action'] == 'edit') {
    $taak = $_POST['taak'];
    $sector = $_POST['sector'];
    $assignedToUserId = $_POST['assignedToUserId'];
    $status = $_POST['status'];
    $deadline = $_POST["deadline"];
    $query = "UPDATE taken SET taak = :taak, sector = :sector, deadline = :deadline, asignedTo = :asignedTo, status = :status WHERE id = :id";

    $statement = $conn->prepare($query);

    $statement->execute([
        ":taak" => $taak,
        ":sector" => $sector,
        ":deadline" => $deadline,
        ":asignedTo" => $assignedToUserId,
        ":status" => $status,
        ":id" => $_POST['id'],
    ]);

    header("location: " . $base_url . "/tasks/index.php");

    die();
}

if ($_GET['action'] == 'delete') {
    $id = $_GET['id'];

    $query = "DELETE FROM taken WHERE id = :id";
    $statement = $conn->prepare($query);
    $statement->execute([
        ":id" => $id,
    ]);
    header("location: " . $base_url . "/tasks/index.php");
}

die();