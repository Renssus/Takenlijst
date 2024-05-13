<?php

if($_GET['action'] == 'create') { 
    //Variabelen vullen
    $taak = $_POST['taak']; 
    $sector = $_POST['sector']; 
    $deadline = $_POST['deadline'];
    $assignedToUserId = $_POST['assignedToUserId'];
    $status = $_POST['status'];
    $createdByUserId = $_POST['createdByUserId'];

    
    
    //1. Verbinding
    require_once '../Configs/conn.php';

    //2. Query

    $query = "INSERT INTO taken (taak, sector, deadline, assignedToUserId, status, createdByUserId) VALUES (:taak, :sector, :deadline, :assignedToUserId, :status, :createdByUserId)";

    //3. Prepare
    $statement = $conn->prepare($query);
        
    //4. Execute
    $statement->execute([
        ":taak" => $taak,
        ":sector" => $sector,
        ":deadline" => $deadline,
        ":assignedToUserId" => $assignedToUserId,
        ":status" => $status,
        ":createdByUserId" => $createdByUserId,
    ]);

    header("location: ". $base_url ."/stommeBugSysteemVanCurio/index.php");
}


// edit code
if($_GET['action'] == 'edit') { 
    //Variabelen vullen
    $taak = $_POST['taak'];
    $sector = $_POST['sector']; 
    $assignedToUserId = $_POST['assignedToUserId'];
    $status = $_POST['status'];

    //1. Verbinding
    require_once '../Configs/conn.php';

    //2. Query

    $query = "UPDATE taken SET taak = :taak, sector = :sector, deadline = :deadline, assignedToUserId = :assignedToUserId, status = :status WHERE id = :id";

    //3. Prepare
    $statement = $conn->prepare($query);

        
    //4. Execute
    $statement->execute([
        ":taak" => $taak,
        ":sector" => $sector,
        ":deadline" => $deadline,
        ":assignedToUserId" => $assignedToUserId,
        ":status" => $status,
        ":id" => $_POST['id'],
    ]);

    header("location: ". $base_url ."/stommeBugSysteemVanCurio/index.php");
}

// delete-code

if($_GET['action'] == 'delete') { 
    $id = $_GET['id'];
    require_once '../Configs/conn.php';
    $query = "DELETE FROM taken WHERE id = :id";
    $statement = $conn->prepare($query);
    $statement->execute([
        ":id" => $id,
    ]);
    header("location: ". $base_url ."/stommeBugSysteemVanCurio/index.php");

}

?>


