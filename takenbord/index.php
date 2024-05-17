<?php
include_once "config/config.php";

session_start();

if (!isset($_SESSION["user_id"]) && !$DEBUG_MODE)
    header("Location: login/login.php");
else
    header("Location: tasks/index.php");
