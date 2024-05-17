<?php 
// Verbinding maken in de database
require_once '../configs/conn.php';
$query = "SELECT * FROM taken";
$statement = $conn->prepare($query);
$statement->execute();
$taken =  $statement->fetchAll(PDO::FETCH_ASSOC);

// Filteren van de taken
function GetTasksFromDb($sector, $status, $persoonId)
{
    global $conn;
    $query = "SELECT * FROM taken";

    if($sector != null || $status != null){
        $query .= " WHERE ";
    
    if($sector != null){
        $query .= "sector = :sector";
    }

    if($status != null){
        if($sector != null){
            $query .= " AND ";
        }
        $query .= "status = :status";
    }

    $statement = $conn->prepare($query);

    if($sector != null){
        $statement->bindParam(':sector', $sector);
    }

    if($status != null){
        $statement->bindParam(':status', $status);
    }

    $statement->execute();
    $taken =  $statement->fetchAll(PDO::FETCH_ASSOC);
    return $taken;
}}

// SECTOR FILTERING

// Controleren of een sector is geselecteerd
if (isset($_GET['sector'])) {
    $selected_sector = $_GET['sector'];
    // Query om alleen taken van de geselecteerde sector op te halen
    if ($selected_sector == "") {
        $query = "SELECT * FROM taken";
    } else {
        $query = "SELECT * FROM taken WHERE sector = :sector";
    }
    try {
        $statement = $conn->prepare($query);
        if ($selected_sector != "") {
            $statement->bindParam(':sector', $selected_sector);
        }
        $statement->execute();
        $taken = $statement->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
} else {
    // Als geen sector is geselecteerd, toon alle taken
    $query = "SELECT * FROM taken";
    try {
        $statement = $conn->query($query);
        $taken = $statement->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
}

// STATUS FILTERING not working
if (isset($_GET['status'])) {
    $selected_status = $_GET['status'];
    // Query om alleen taken van de geselecteerde status op te halen
    if ($selected_status == "") {
        $query = "SELECT * FROM taken";
    } else {
        $query = "SELECT * FROM taken WHERE status = :status";
    }
    try {
        $statement = $conn->prepare($query);
        if ($selected_status != "") {
            $statement->bindParam(':status', $selected_status);
        }
        $statement->execute();
        $taken = $statement->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
} else {
    // Als geen status is geselecteerd, toon alle taken
    $query = "SELECT * FROM taken";
    try {
        $statement = $conn->query($query);
        $taken = $statement->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
}

// Filteren van de taken op status
if (isset($_GET['status'])) {
    $selected_status = $_GET['status'];
    // Query om alleen taken van de geselecteerde status op te halen
    if ($selected_status == "") {
        $query = "SELECT * FROM taken";
    } else {
        $query = "SELECT * FROM taken WHERE status = :status";
    }
    try {
        $statement = $conn->prepare($query);
        if ($selected_status != "") {
            $statement->bindParam(':status', $selected_status);
        }
        $statement->execute();
        $taken = $statement->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
} else {
    // Als geen status is geselecteerd, toon alle taken
    $query = "SELECT * FROM taken";
    try {
        $statement = $conn->query($query);
        $taken = $statement->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
}
header("Location: index.php");
?>
