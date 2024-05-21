<?php

require_once '../resources/header.php';
require_once '../config/conn.php';
require_once '../controller/helperFunctions.php';

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../login/login.php");
    die();
}

if (!isset($_GET["id"])) {
    header("Location: index.php");
    die();
}

$task = getTaskFromID($_GET["id"], $conn);
$users = getUsers($conn);

require_once '../resources/head.php';
setTitle("Takenlijst Edit - " . $_SESSION["user_name"]);
?>


<body>
    <?php require_once '../resources/header.php'; ?>

    <div class="container home">
        <h1>Editing: <?php echo $task["taak"]; ?> <br> van <?php echo $task["sector"]; ?></h1>

        <div>
            <form action="<?php echo $base_url; ?>/controller/taskController.php?action=edit" method="POST">

                <input type="hidden" name="id" id="id" value="<?php echo $task['id']; ?>">
                <label for="taak">Taak:</label>
                <input type="text" id="taak" name="taak" value="<?php echo $task['taak']; ?>" required><br><br>

                <label for="sector">Sector:</label>
                <input type="text" id="sector" name="sector" value="<?php echo $task['sector']; ?>" required><br><br>

                <label for="deadline">Deadline:</label>
                <input type="date" id="deadline" name="deadline" value="<?php echo $task['deadline']; ?>" required><br><br>

                <label for="assignedToUserId">Voor:</label>
                <select name="assignedToUserId" id="assignedToUserId">
                    <option value="">Kies een persoon</option>
                    <?php foreach ($users as $user) {
                        $selected = ($user["id"] == $task['asignedTo']) ? 'selected' : '';
                        echo '<option value="' . $user["id"] . '" ' . $selected . '>' . $user["username"] . '</option>';
                    }
                    ?>
                </select>

                <label for="status">Status:</label>
                <select name="status">
                    <option value="ToDo" <?php echo ($task['status'] == 'ToDo') ? 'selected' : ''; ?>>TODO</option>
                    <option value="Doing" <?php echo ($task['status'] == 'Doing') ? 'selected' : ''; ?>>Doing</option>
                    <option value="Done" <?php echo ($task['status'] == 'Done') ? 'selected' : ''; ?>>Done</option>
                </select>

                <input type="submit" value="Edit">

            </form>

            <form action="<?php echo $base_url; ?>/controller/taskController.php?action=delete&id=<?php echo $_GET['id']; ?>" method="POST">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <input type="submit" value="Verwijder bericht">
            </form>
        </div>
    </div>
</body>