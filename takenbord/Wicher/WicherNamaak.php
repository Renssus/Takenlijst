<?php

// Databaseverbinding
require_once '../resources/header.php';
global $conn;
echo '<link rel="stylesheet" type="text/css" href="../css/Create.css">';

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



// Controleren of een sector is geselecteerd
if (isset($_GET['sector'])) {
    $selected_sector = $_GET['sector'];
    // Query om alleen taken van de geselecteerde sector op te halen
    $query = "SELECT * FROM taken WHERE sector = :sector";
    try {
        $statement = $conn->prepare($query);
        $statement->bindParam(':sector', $selected_sector);
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

?>

<html>
    <body>

<form action="WicherNamaak.php" method="get">
    <select name="sector">
        <option value="Personeel">Personeel</option>
        <option value="Horeca">Horeca</option>
        <option value="Techniek">Techniek</option>
        <option value="Inkoop">Inkoop</option>
        <option value="Klantenservice">Klantenservice</option>
        <option value="Groen">Groen</option>
    </select>
    <table>
        <tr>
            <th>Taak</th>
            <th>Sector</th>
            <th>Persoon</th>
        </tr>
        <?php
        foreach($taken as $taak) {
            echo '<tr>';
            echo '<td>' . $taak['taak'] . '</td>';
            echo '<td>' . $taak['sector'] . '</td>';
            echo '<td>' . $taak['persoon'] . '</td>';
            echo '</tr>';
        }
        ?>
    </table>
    <input type="submit" value="Submit">
</form>

</body>
</html>
