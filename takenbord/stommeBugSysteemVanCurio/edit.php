<?php session_start(); ?>
<body>

    <?php require_once '../resources/header.php'; ?>
    <link rel="stylesheet" type="text/css" href="../css/Create.css">
    <div class="container">
        <h1>verander de taak</h1>


        <?php
        $id = $_GET['id'];
        require_once '../configs/conn.php';
        $query = "SELECT * FROM taken WHERE id = :id";
        $statement = $conn->prepare($query);
        $statement->bindParam(':id', $id);
        $statement->execute();
        $taak = $statement->fetch(PDO::FETCH_ASSOC);
        ?>


        <form action="<?php echo $base_url; ?>/Controller/TaakController.php?action=edit" method="POST">
            <label for="taak">De taak:</label>
            <input type="text" name= 'taak' value="<?php echo $taak['taak'];?>" />
            <br>
            <label for="persoon">Wie de taak moet doen:</label>
            <input type="text" name= 'persoon' value="<?php echo $taak['persoon'];?>" />
            <br>
            <select name="sector">
                    <option value="">welk sector moet het doen:</option>
                    <option value="personeel" <?php if ($taak['sector'] == "personeel") { echo "selected"; }?>>Personeel</option>
                    <option value="horeca" <?php if ($taak['sector'] == "horeca") { echo "selected"; }?>>Horeca</option>
                    <option value="techniek" <?php if ($taak['sector'] == "techniek") { echo "selected"; }?>>Techniek</option>
                    <option value="inkoop" <?php if ($taak['sector'] == "inkoop") { echo "selected"; }?>>Inkoop</option>
                    <option value="klantenservice" <?php if ($taak['sector'] == "klantenservice") { echo "selected"; }?>>Klantenservice</option>
                    <option value="groen" <?php if ($taak['sector'] == "groen") { echo "selected"; }?>>Groen</option>
            </select>
            <br>
            <label for="status">Wat is de status van de taak:</label>
            <select name="status">
                    <option value="">Status van de taak</option>
                    <option value="ToDo" <?php if ($taak['status'] == "ToDo") { echo "selected"; }?>>ToDo</option>
                    <option value="Doing" <?php if ($taak['status'] == "Doing") { echo "selected"; }?>>Doing</option>
                    <option value="Done" <?php if ($taak['status'] == "Done") { echo "selected"; }?>>Done</option>
            </select>
            <br>
        
            <input type="submit" value="edit de taak">

        </form>
        <!-- delete sector -->
        <form action="<?php echo $base_url; ?>/Controller/TaakController.php?action=delete&id=<?php echo $_GET['id'];?>" method="POST">
            <input type="hidden" name="action" value="delete">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="submit" value="Verwijder bericht">
        </form>
    </div>

</body>

</html>