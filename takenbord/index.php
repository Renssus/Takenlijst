<?php
session_start();

if (!isset($_SESSION["user_id"]))
    header("Location: LoginPages/login.php");
else
    header("Location: stommeBugSysteemVanCurio");

//Redirect