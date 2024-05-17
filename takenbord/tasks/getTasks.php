<?php
function getTasks($conn, $status, $sector)
{
    $query = "SELECT * FROM taken";
    $statement = 0;

    if ($status && $sector
    && $sector != "Alles" && $status != "Alles") {
        $query = "SELECT * FROM taken WHERE status=:status AND sector=:sector";
        $statement = $conn->prepare($query);
        $statement->execute([':status' => $status, ':sector' => $sector]);
    } else if ($status && $status != "Alles") {
        $query = "SELECT * FROM taken WHERE status=:status";
        $statement = $conn->prepare($query);
        $statement->execute([':status' => $status]);
    } else if ($sector && $sector != "Alles") {
        $query = "SELECT * FROM taken WHERE sector=:sector";
        $statement = $conn->prepare($query);
        $statement->execute([':sector' => $sector]);
    } else {
        $statement = $conn->prepare($query);
        $statement->execute();
    }

    $tasks = $statement->fetchAll(PDO::FETCH_ASSOC);

    $ret = array();

    $todo = array();
    $doing = array();
    $done = array(); 

    if ($status && $status != "Alles")
    {
        $ret["filtered"] = $tasks;
        return $ret;
    }
    else
    {
        foreach ($tasks as $task) {
            if (strtolower($task["status"]) == "todo") {
                $todo[] = $task;
            }
            if (strtolower($task["status"]) == "doing") {
                $doing[] = $task;
            }
            if (strtolower($task["status"]) == "done") {
                $done[] = $task;
            }
        }
    }
   
    $ret["todo"] = $todo;
    $ret["doing"] = $doing;
    $ret["done"] = $done;

    return $ret;
}
