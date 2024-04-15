<?php session_start();

if (!isset($_SESSION["user_id"]))
{
    header("Location: LoginPages/login.php");
    die();
}
   
?>
<body>
<?php require_once '../resources/header.php'; ?>
<link rel="stylesheet" type="text/css" href="../css/Create.css">
    <div class="container">
        <h1>Maak een taak aan!</h1>

        <!-- "persoon moet iemand zijn uit de taken lijst" zelfde gelt voro sector maak een dropdown worden, edit moet dan ook veranderd worden. -->

        <form action="<?php echo $base_url; ?>/Controller/TaakController.php?action=create" method="POST">
            <label for="taak">De taak:</label>
            <input type="text" name= 'taak' />
            <br>
            <label for="persoon">Wie de taak moet doen:</label>
            <input type="text" name= 'persoon' />
            <br>
            <select name="sector">
                    <option value="">Welke sector moet deze taak doen?</option>
                    <option value="personeel">Personeel</option>
                    <option value="horeca">Horeca</option>
                    <option value="techniek">Techniek</option>
                    <option value="inkoop">Inkoop</option>
                    <option value="klantenservice">Klantenservice</option>
                    <option value="groen">Groen</option>
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
        
            <input type="submit" value="Create nieuwe taak">

        </form>
    </div>

</body>

</html>