<?php
session_start();
require_once("_functions.php");
// Если запрос идёт не из Ajax
if( $_SERVER['HTTP_X_REQUESTED_WITH'] != "XMLHttpRequest" )
{
    exit("Access denied!");
}
//------------------------------------------------------------------------------------------------//
if(
    (isset($_SESSION['gryppa']) && !empty($_SESSION['gryppa'])) ||
    (isset($_SESSION['ip']) && !empty($_SESSION['ip'])) ||
    (isset($_SESSION['web']) && !empty($_SESSION['web']))
){
    $sql = "UPDATE tusers SET last_connection_data = now() WHERE udln is null and md5(concat(id,'$sol_user_id')) = '".$_SESSION['user_id']."'";
    mysqli_query($db, $sql);
    //------------------------------------------------------------------------------------------------//
    //proverka na blokirovanie polzovatela
    $sql = "select blocked from tusers WHERE udln is null and md5(concat(id,'$sol_user_id')) = '".$_SESSION['user_id']."'";
    $res = mysqli_query($db, $sql);
    $line = mysqli_fetch_array($res, MYSQLI_NUM);
    if($line[0]==1){
        session_unset();
        session_destroy();
        exit('2');
    }else{
        exit('1');
    }
}
//------------------------------------------------------------------------------------------------//
?>