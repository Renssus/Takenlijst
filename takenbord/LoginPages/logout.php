<?php
require_once '../Configs/config.php';
session_start();
session_destroy();
header("location: ". $base_url ."/StommeBugSysteemVanCurio/index.php");
exit;