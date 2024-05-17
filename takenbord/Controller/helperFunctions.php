<?php

function getPersonNameFromID($id, $conn)
{
    $query = "SELECT username FROM users WHERE id=:id";

    $statement = $conn->prepare($query);
    $statement->execute([
        ":id" => $id,
    ]);
    
    $result = $statement->fetch(PDO::FETCH_ASSOC);

    if ($result)
    {
        return $result["username"];
    }

    return "nill";
}

function getUsers($conn)
{
    $query = "SELECT username, id FROM users";

    $statement = $conn->prepare($query);
    $statement->execute([]);
    
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    if ($result)
    {
        return $result;
    }

    return array();   
}

function getSectors($conn)
{
    $query = "SELECT sector FROM taken";

    $statement = $conn->prepare($query);
    $statement->execute([]);
    
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    if ($result)
    {
        return $result;
    }

    $ret = array();

    foreach($result as $sector){
        if(!in_array($ret, $sector, true)){
            array_push($ret, $sector);
        }
    }

    return array();   
}

function getTaskFromID($id, $conn)
{
    $query = "SELECT * FROM taken WHERE id=:id";

    $statement = $conn->prepare($query);
    $statement->execute([
        ":id" => $id
    ]);
    
    $result = $statement->fetch(PDO::FETCH_ASSOC);

    if ($result)
    {
        return $result;
    }

    return array();
}

function getIDFromUsername($username, $conn)
{
    $query = "SELECT id FROM users WHERE username=:username";

    $statement = $conn->prepare($query);
    $statement->execute([
        ":username" => $username,
    ]);
    
    $result = $statement->fetch(PDO::FETCH_ASSOC);

    if ($result)
    {
        return $result["id"];
    }

    return 0;
}