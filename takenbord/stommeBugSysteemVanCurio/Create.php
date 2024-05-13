<?php session_start();
    // Database verbindingen + header s
    require_once '../resources/header.php'; 
    require_once '../configs/conn.php';
    // checken of de gebruiker is ingelogd
    if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        // Als de gebruiker niet is ingelogd, stuur ze door naar de inlogpagina
        header("Location: ../loginpages/login.php");
        exit;
    }
    

    // checken van de gebruikers
    $user_query = "SELECT id, username FROM users";
    $user_statement = $conn->query($user_query);
    $users = array();
    while ($row = $user_statement->fetch(PDO::FETCH_ASSOC)) {
        $users[$row['id']] = $row['username']; // Sla ID en gebruikersnaam op in de array

    }    
    // checken van de sectoren
    $sector_query = "SELECT * FROM sectoren";
    $sector_statement = $conn->query($sector_query);
    $sectornName = array();
    while ($row = $sector_statement->fetch(PDO::FETCH_ASSOC)) {
        $sectornName[] = $row['sectorName'];
    }
?>
<body>
<link rel="stylesheet" type="text/css" href="../css/Create.css">
    <div class="container">
        <h1>Maak een taak aan!</h1>
        <!-- Als je een taak create moet hij de userid laten zien in de database wie de taak aanmaakt. -->
        <!-- De "Wie moet de taak maken" moet een dropdown en type worden waar mensen kunnen type en selecteren -->

        <form action="<?php echo $base_url; ?>/Controller/TaakController.php?action=create" method="POST">
            <label for="taak">De taak:</label>
            <input type="text" name= 'taak' />
            <br>
            <label for="persoonText">Wie de taak moet doen:</label>
            <select name="assignedToUserId" id="assignedToUserId">
                <option value="">Kies een persoon</option>
                <?php foreach($users as $id => $username)
                    {
                        if(isset($_GET['username']) && $_GET['username'] == $user) {
                            echo '<option value="' . $id . '" selected>' . $username . '</option>';
                        } else {
                            echo '<option value="' . $id . '">' . $username . '</option>';
                        }
                    }
                ?>
            </select>
            <br>
            <label for="sectorText">Welke sector moet de  taak doen:</label>
            <select name="sector">
                <option value="">Kies een sector</option>
                    <?php foreach($sectornName as $sector)
                        {
                            if(isset($_GET['sector']) && $_GET['sector'] == $sector) {
                                echo '<option value="' . $sector . '" selected>' . $sector . '</option>';
                            } else {
                                echo '<option value="' . $sector . '">' . $sector . '</option>';
                            }
                        }
                    ?>
            </select>
            <br>
            <label for="deadline">Wanneer moest het af zijn:</label>
            <input type="date" name= 'deadline' />
            <br>
            <label for="status">Wat is de status van de taak:</label>
            <select name="status">
                    <option value="">Status van de taak</option>
                    <option value="ToDo">ToDo</option>
                    <option value="Doing">Doing</option>
                    <option value="Done">Done</option>
            </select>
            <br>
            <!-- Zorgen dat hun ID word meegestuurd -->
            <input type="hidden" name="sectorId" value="<?php echo $_POST['sectorId']; ?>">
            <input type="hidden" name="createdByUserId" value="<?php echo $_SESSION['user_id']; ?>">
            <input type="submit" value="Create nieuwe taak">
        </form>
    </div>

</body>

</html>