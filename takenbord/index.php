<?php
include_once "Configs/config.php";


session_start();

if (!isset($_SESSION["user_id"]) && !$DEBUG_MODE)
    header("Location: LoginPages/login.php");
else
    header("Location: stommeBugSysteemVanCurio/index.php");

//Redirect