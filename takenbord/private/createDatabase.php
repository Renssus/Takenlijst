<?php

include_once '../config/conn.php';

function createDatabase($conn)
{
    $query = "CREATE TABLE taken (
        id int UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        taak varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
        sector varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
        asignedTo int NOT NULL,
        deadline date DEFAULT NULL,
        status varchar(255) NOT NULL,
        createdBy int NOT NULL
      )";


    $statement = $conn->prepare($query);
    $statement->execute([]);

    $query = "CREATE TABLE users (
        id int UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        username text NOT NULL,
        password text NOT NULL,
        admin tinyint(1) DEFAULT NULL
      )";

    $statement = $conn->prepare($query);
    $statement->execute([]);
}


createDatabase($conn);
