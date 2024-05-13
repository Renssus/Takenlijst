<?php session_start();
// Database verbindingen + header
require_once '../resources/header.php'; 
require_once '../configs/conn.php';
// checken of de gebruiker is ingelogd
if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../loginpages/login.php");
    exit;
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

// Verwijderen van divs
if (isset($_GET['status'])) {
    $selectedStatus = $_GET['status'];
    if ($selectedStatus == 'Todo') {
        // Verwijderen van Doing en done classes
        echo '<style>.doing, .done { display: none; }</style>';
    } elseif ($selectedStatus == 'Doing') {
        // Vederijden van ToDo en done classes
        echo '<style>.todo, .done { display: none; }</style>';
    } elseif ($selectedStatus == 'Done') {
        // Verwijderen van todo and doing classes
        echo '<style>.todo, .doing { display: none; }</style>';
    }
}


$statement = $conn->prepare($query);
$statement->execute($placeholders);
$taken =  $statement->fetchAll(PDO::FETCH_ASSOC);


// Filteren van de taken
// TODO: Deze array moet eigenlijk uit de database komen, zodat nieuwe sectoren automatisch worden toegevoegd
// Create an array for the sectors, add all sectors
$sectoren = [];


$sectoren = [
    'personeel',
    'horeca',
    'techniek',
    'inkoop',
    'klantenservice',
    'groen'
];
$statussen = [
    'ToDo',
    'Doing',
    'Done'
];

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
                    <option value="">-- Sector --</option>
                    <?php foreach($sectoren as $sector)
                        {
                            if(isset($_GET['sector']) && $_GET['sector'] == $sector) {
                                echo '<option value="' . $sector . '" selected>' . $sector . '</option>';
                            } else {
                                echo '<option value="' . $sector . '">' . $sector . '</option>';
                            }
                        }
                    ?>
                </select>
                <select name="status">
                    <option value="">-- Status --</option>
                    <?php foreach($statussen as $status)
                        {
                            if(isset($_GET['status']) && $_GET['status'] == $status) {
                                echo '<option value="' . $status . '" selected>' . $status . '</option>';
                            } else {
                                echo '<option value="' . $status . '">' . $status . '</option>';
                            }
                        }
                    ?>
                </select>
                <input type="submit" value="Taken Filteren">
            </form>
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
                <th>deadline</th>
                <th>Persoon ID</th>
                <th>Status</th>
                <th>Edit de taak</th>
            </tr>
            <?php foreach($taken as $taak): ?>
                <?php if ($taak['status'] == 'ToDo'): ?>
                    <tr>
                        <td><input type="checkbox" class="Completed" data-task-id="<?php echo $taak['id']; ?>"></td>
                        <td><?php echo $taak['taak']; ?></td>
                        <td><?php echo $taak['sector']; ?></td>
                        <td><?php echo $taak['deadline']; ?></td>
                        <td><?php echo $taak['assignedToUserId']; ?></td>
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
                    <th>deadline</th>
                    <th>Persoon ID</th>
                    <th>Status</th>
                    <th>Edit de taak</th>
                </tr>
                <?php foreach($taken as $taak): ?>
                    <?php if ($taak['status'] == 'Doing'): ?>
                        <tr>
                            <td><input type="checkbox" class="Completed" data-task-id="<?php echo $taak['id']; ?>"></td>
                            <td><?php echo $taak['taak']; ?></td>
                            <td><?php echo $taak['sector']; ?></td>
                            <td><?php echo $taak['deadline']; ?></td>
                            <td><?php echo $taak['assignedToUserId']; ?></td>
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
            <th>klaar</th>
            <th>Taak</th>
            <th>Sector</th>
            <th>Deadline</th>
            <th>Persoon ID</th>
            <th>Status</th>
            <th>Edit de taak</th>
        </tr>
        <?php foreach($taken as $taak): ?>
            <?php if ($taak['status'] == 'Done'): ?>
                <tr>
                    <td>Done</td>
                    <td><?php echo $taak['taak']; ?></td>
                    <td><?php echo $taak['sector']; ?></td>
                    <td><?php echo $taak['deadline']; ?></td>
                    <td><?php echo $taak['assignedToUserId']; ?></td>
                    <td><?php echo $taak['status']; ?></td>
                    <td><a href="edit.php?id=<?php echo $taak['id']; ?>">Edit</a></td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
    </table>
    </div>
</div>
</body>
<?php
if (isset($_POST['complete'])) {
    $taskId = $_POST['taskId'];
    $query = "UPDATE taken SET status = 'Done' WHERE id = :taskId";
    $statement = $conn->prepare($query);
    $statement->bindParam(':taskId', $taskId);
    $statement->execute();
    header("Location: index.php");
    exit;
}
?>
</form>
</html> 