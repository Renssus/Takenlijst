<?php

$a_names = array('Jan', 'Piet', 'Klaas', 'Rens');
// Vul taken, met de relevante taken, bijv:
// Alleen taken die "niet done" zijn, als iemand op "Todo"
// gefilterd heeft, of alle taken die aan Jan assigned zijn,
// of alle taken die door Piet gemaakt zijn.

$a_taken[] = array(
    'done' => false,
    'afdeling' => 'HR',
    'persoon' => 'Jan'
);

$a_taken[] = array(
    'done' => false,
    'afdeling' => 'Sales',
    'persoon' => 'Piet'
);

$a_taken[] = array(
    'done' => false,
    'afdeling' => 'IT',
    'persoon' => 'Klaas'
);

?>

<html>
    <body>

<form action="wicher.php" method="get">
    <select name="afdeling">
        <option value="HR">HR</option>
        <option value="Sales">Sales</option>
        <option value="IT">IT</option>
        <option value="Finance">Finance</option>
        <option value="Marketing">Marketing</option>
    </select>
    <select name="persoon">
        <?php
            foreach($a_names as $s_name) {
                echo '<option value="' . $s_name . '">' . $s_name . '</option>';
            }
        ?>
    </select>
    <div class="taskContainer">
        <div class="task" style="display: flex;">Task</div>
            <div class="taskDone">Done</div>
            <div class="taskAfdeling">Afdeling</div>
            <div class="taskPersoon">Persoon</div>
        </div>
        <?php
        foreach($a_taken as $task) {
            echo '<div class="taskContainer">';
            echo '<div class="task"  style="display: flex;">' . $task['done'] . '</div>';
            echo '<div class="taskDone">' . $task['afdeling'] . '</div>';
            echo '<div class="taskAfdeling">' . $task['persoon'] . '</div>';
            echo '</div>';
        }
        ?>
    </div>


    <input type="submit" value="Submit">
</form>

<?php
if(isset($_GET['afdeling']) && isset($_GET['persoon'])) {
    $afdeling = $_GET['afdeling'];
    $persoon = $_GET['persoon'];
    echo 'Hallo ' . $persoon . ' welkom op de ' . $afdeling;
}
?>

</body>
</html>