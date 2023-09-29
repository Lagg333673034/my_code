<?php
session_start();
if(
    !isset($_SESSION['user']) || empty($_SESSION['user']) ||
    !isset($_SESSION['user_id']) || empty($_SESSION['user_id']) ||
    !isset($_SESSION['gryppa']) || empty($_SESSION['gryppa']) ||
    !isset($_SESSION['ip']) || empty($_SESSION['ip']) ||
    !isset($_SESSION['web']) || empty($_SESSION['web']) ||
    (
        $_SESSION['gryppa'] != md5('admin'.$sol_user_gryppa) &&
        $_SESSION['gryppa'] != md5('user'.$sol_user_gryppa)
    )
){
    header("Location: http://" . $_SERVER['SERVER_NAME'] . "/index.php");exit();
}
?>