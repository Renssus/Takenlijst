<?php
require_once '../config/config.php';
session_start();
session_destroy();
header("location: ". $base_url ."/login/login.php");
exit;