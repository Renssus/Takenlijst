<?php session_start();

if (!isset($_SESSION["user_id"]))
{
    header("Location: ../LoginPages/login.php");
    die();
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <title>Takenbord</title>
    
</head>
<body>
<?php require_once '../resources/header.php'; ?>

<?php 
// Verbinding maken in de database
require_once '../configs/conn.php';
$query = "SELECT * FROM taken";
$sectorSelected = false;
$placeholders = [];

if (isset($_GET['sector'])) {
    if ($sectorSelected) {
        $query .= " AND sector = :sector ";
    } else {
        $query .= " WHERE sector = :sector ";
        $sectorSelected = True;
    }
    $placeholders[':sector'] = $_GET['sector'];
}
if (isset($_GET['status'])) {
    if ($sectorSelected) {
        $query .= " AND status = :status ";
    } else {
        $query .= " WHERE status = :status ";
        $sectorSelected = True;
    }
    $placeholders[':status'] = $_GET['status'];
}


$statement = $conn->prepare($query);
$statement->execute($placeholders);
$taken =  $statement->fetchAll(PDO::FETCH_ASSOC);


// Filteren van de taken



?>

<!-- SOON moeten allebij uit de takenlijst komen , persoon moet uit de database dus niet dat je iemand random kan type of selecteren of Sector.  -->
<div class="container">
    <div class="filters">
        <h1>Taakbeheer</h1>
        <div class="task-management">
            <!-- <select id="filter-person">
                <option value="">-- Persoon (Soon) --</option>
                <option value="SOON">SOON</option>
                <option value="SOON">SOON</option>
                <option value="SOON">SOON</option>
            </select> -->
            <form action="index.php" method="get" id="Filter-Sector">
            <select name="sector">
                <option value="">-- Sector (SOON) --</option>
                <option value="personeel">Personeel</option>
                <option value="horeca">Horeca</option>
                <option value="techniek">Techniek</option>
                <option value="inkoop">Inkoop</option>
                <option value="klantenservice">Klantenservice</option>
                <option value="groen">Groen</option>
            </select>
            <select id="status">
                <option value="">-- Status --</option>
                <option value="todo">Todo</option>
                <option value="doing">Doing</option>
                <option value="done">Done</option>
            </select>
            <input type="submit" value="Taken-Filteren">
        </div>
    </div>

    <!-- Todo list tonen -->
<div class="taken-container">
    <div class="todo">
            <h2>TODO</h2>
            <table>
            <tr>
                <th>Klaar</th>
                <th>Taak</th>
                <th>Sector</th>
                <th>Persoon</th>
                <th>Status</th>
                <th>Edit de taak</th>
            </tr>
            <?php foreach($taken as $taak): ?>
                <?php if ($taak['status'] == 'ToDo'): ?>
                    <tr>
                        <td><?php echo $taak['taak']; ?></td>
                        <td><?php echo $taak['sector']; ?></td>
                        <td><?php echo $taak['persoonId']; ?></td>
                        <td><?php echo $taak['status']; ?></td>
                        <td><a href="edit.php?id=<?php echo $taak['id']; ?>">Edit</a></td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </table>
    </div>

        <!-- Doing list tonen -->
        <div class="doing">
                <h2>Doing</h2>
                <table>
                <tr>
                    <th>klaar</th>
                    <th>Taak</th>
                    <th>Sector</th>
                    <th>Persoon</th>
                    <th>Status</th>
                    <th>Edit de taak</th>
                </tr>
                <?php foreach($taken as $taak): ?>
                    <?php if ($taak['status'] == 'Doing'): ?>
                        <tr>
                            <td><?php echo $taak['taak']; ?></td>
                            <td><?php echo $taak['sector']; ?></td>
                            <td><?php echo $taak['persoonId']; ?></td>
                            <td><?php echo $taak['status']; ?></td>
                            <td><a href="edit.php?id=<?php echo $taak['id']; ?>">Edit</a></td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </table>
        </div>

        <!-- Done list tonen -->
    <div class="done">
        <h2>Done</h2>
        <table>
        <tr>
            <th>Taak</th>
            <th>Sector</th>
            <th>Persoon</th>
            <th>Status</th>
            <th>Edit de taak</th>
        </tr>
        <?php foreach($taken as $taak): ?>
            <?php if ($taak['status'] == 'Done'): ?>
                <tr>
                    <td><?php echo $taak['taak']; ?></td>
                    <td><?php echo $taak['sector']; ?></td>
                    <td><?php echo $taak['persoonId']; ?></td>
                    <td><?php echo $taak['status']; ?></td>
                    <td><a href="edit.php?id=<?php echo $taak['id']; ?>">Edit</a></td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
    </table>
    </div>
</div>
</body>
<!-- 
    TODO:
    1. Maak een div waarin je de taken kunt zetten, bijv:
    <div id="takenContainer">
        <div id="singleTask">
            <h1>Title</h1>
            <div>Done</div>
            <div>Task</div>
            <div>Sector</div>
            <div>Person</div>
            <div>Status</div>
            <div>Edit</div>
        </div>
    </div>

    2. Voeg een "singleTask" aan takenContainer toe per taak in de database
    3. Stel de tekst van de (bijv) Done-div, op bijv "Todo"

    Note: Ik weet nog even niet hoe je één div selecteert, aamgezien ze een class moeten hebben
    
-->
</html> 