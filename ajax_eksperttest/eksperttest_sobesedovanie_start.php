<?php
require_once("../_functions.php");
// Если запрос идёт не из Ajax
if( $_SERVER['HTTP_X_REQUESTED_WITH'] != "XMLHttpRequest" )
{
    exit("Access denied!");
}
//-------------------------------------------------------------------------------------------------//
if($_SESSION['gryppa'] != md5('ekspert'.$sol_user_gryppa)){
    exit("Access denied!");
}
//-------------------------------------------------------------------------------------------------//
$sql_user_id="SELECT id FROM tusers WHERE udln is null and md5(concat(id,'".$sol_user_id."')) = '".$_SESSION['user_id']."'";
$res_user_id = mysqli_query($db,$sql_user_id);
$line_user_id=mysqli_fetch_array($res_user_id,MYSQLI_NUM);
$user_id=$line_user_id[0];
//-------------------------------------------------------------------------------------------------//
//-------------------------------------------------------------------------------------------------//
if(1){
    $sql = "UPDATE teksperttest SET 
    u_upd='" . $_SESSION['user'] . "', 
    d_upd=now(), 
    sobesedovanie_time_start=now() 
    WHERE udln is null and id_user=$user_id";
    if (mysqli_query($db, $sql) != true) exit('Неизвестная ошибка при добавлении teksperttest собеседование.');
}

?>