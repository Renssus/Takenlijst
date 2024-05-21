<?php

require_once '../resources/header.php';
require_once '../config/conn.php';
require_once '../controller/helperFunctions.php';
require_once 'getTasks.php';

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../login/login.php");
    die();
}
?>

<?php require_once '../resources/head.php';
setTitle("Takenlijst - " . $_SESSION["user_name"]);
?>

<body>
    <?php require_once '../resources/header.php';

    $sectoren = [];
    $sectoren = array_column(getSectors($conn), 'sector');
    $statussen = [
        'Alles',
        'TODO',
        'Doing',
        'Done'
    ];
    ?>

    <div class="container">
        <div class="filters">
            <div>
                <h1 class="title">Taakbeheer</h1>
                <h2 class="title">Welkom <?php echo $_SESSION["user_name"]; ?></h2>
            </div>
            <div class="task-management">
                <form action="index.php" method="get">
                    <select name="sector">
                        <option value="">-- Sector --</option>
                        <?php foreach ($sectoren as $sector) {
                            if (isset($_GET['sector']) && $_GET['sector'] == $sector) {
                                echo '<option value="' . $sector . '" selected>' . $sector . '</option>';
                            } else {
                                echo '<option value="' . $sector . '">' . $sector . '</option>';
                            }
                        }
                        ?>
                    </select>
                    <select name="status">
                        <option value="">-- Status --</option>
                        <?php foreach ($statussen as $status) {
                            if (isset($_GET['status']) && $_GET['status'] == $status) {
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

        <div class="taken-container">
            <?php
            $sector = 0;
            $status = 0;
            if (isset($_GET["sector"]) && $_GET["sector"])
                $sector = $_GET["sector"];
            if (isset($_GET["status"]) && $_GET["status"])
                $status = $_GET["status"];
            $tasks = getTasks($conn, $status, $sector);
            ?>

            <div <?php if (sizeof($tasks) != 1) echo "class='columns'"; else echo "class='center'"; ?>>
                <?php foreach ($tasks as $statusName => $statusTasks) : ?>
                    <div>
                        <h2 class="title"><?php echo strtoupper($statusName); ?></h2>
                        <table class='center'>
                            <tr>
                                <th>Klaar</th>
                                <th>Taak</th>
                                <th>Sector</th>
                                <th>Deadline</th>
                                <th>Persoon</th>
                                <th>Status</th>
                                <th>Edit</th>
                            </tr>
                            <?php foreach ($statusTasks as $taak) : ?>
                                <tr>
                                    <td><a href="taskSetComplete.php?id=<?php echo $taak["id"];?>">Klaar</a></td>
                                    <td><?php echo $taak['taak']; ?></td>
                                    <td><?php echo $taak['sector']; ?></td>
                                    <td><?php echo $taak['deadline']; ?></td>
                                    <td><?php echo getPersonNameFromID($taak['asignedTo'], $conn); ?></td>
                                    <td><?php echo $taak['status']; ?></td>
                                    <td><a href="edit.php?id=<?php echo $taak['id']; ?>">Edit</a></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                <?php endforeach; ?>
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