<?php session_start();
require_once '../resources/header.php';
require_once '../config/conn.php';
require_once '../controller/helperFunctions.php';
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../login/login.php");
    die();
}

require_once '../resources/head.php';
setTitle("Takenlijst Create - " . $_SESSION["user_name"]);

$users = getUsers($conn);
?>

<body>
    <div class="container">
        <h1>Maak een taak aan!</h1>

        <form action="<?php echo $base_url; ?>/Controller/taskController.php?action=create" method="POST">
            <label for="taak">De taak:</label>
            <input type="text" name='taak' />
            <br>
            <label for="persoonText">Wie de taak moet doen:</label>
            <select name="assignedToUserId" id="assignedToUserId">
                <option value="">Kies een persoon</option>
                <?php foreach ($users as $user) {
                    echo '<option value="' . $user["id"] . '">' . $user["username"] . '</option>';
                }
                ?>
            </select>
            <br>
            <label for="sector">Sector:</label>
            <input type="text" name='sector' />
            <br>
            <label for="deadline">Wanneer moest het af zijn:</label>
            <input type="date" name='deadline' />
            <br>
            <label for="status">Wat is de status van de taak:</label>
            <select name="status">
                <option value="">Status van de taak</option>
                <option value="ToDo">TODO</option>
                <option value="Doing">Doing</option>
                <option value="Done">Done</option>
            </select>
            <br>
  
            <input type="hidden" name="createdByUserId" value="<?php echo $_SESSION['user_id']; ?>">
            <input type="submit" value="Create nieuwe taak">
        </form>
    </div>

</body>

</html>