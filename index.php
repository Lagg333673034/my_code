<?php
require_once("_functions.php");
//--------------------------------------------------------------------------------------------------------------//
if (
    $_SESSION['gryppa'] == md5('admin'.$sol_user_gryppa)
) {
    header("Location: http://" . $_SERVER['SERVER_NAME'] . "/ekspert.php");exit();
}
//--------------------------------------------------------------------------------------------------------------//
if (
    $_SESSION['gryppa'] == md5('ekspert'.$sol_user_gryppa)
) {
    header("Location: http://" . $_SERVER['SERVER_NAME'] . "/guest/form_eksperttest.php");exit();
}
//--------------------------------------------------------------------------------------------------------------//
header("Location: http://" . $_SERVER['SERVER_NAME'] . "/guest/form_eksperttest.php");exit();
?>