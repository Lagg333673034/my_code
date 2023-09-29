<?php
session_start();

$downtime = 60*60*10; //na 10 chasov bezdeistviya

if(isset($_SESSION['downtime']) or !empty($_SESSION['downtime'])) {
    if (time() - $_SESSION['downtime'] > $downtime) {
        session_unset();
        session_destroy();
        header("Location: http://" . $_SERVER['SERVER_NAME'] . "/index.php");
        exit();
    }
}
?>