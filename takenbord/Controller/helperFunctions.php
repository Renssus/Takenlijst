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