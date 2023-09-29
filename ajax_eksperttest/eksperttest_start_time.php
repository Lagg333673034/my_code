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
//-------------------------------------------------------------------------------------------------//
$sql="SELECT id, DATE_FORMAT(now(), '%d.%m.%Y %H:%i')
FROM tusers 
WHERE udln is null 
and md5(concat(id,'".$sol_user_id."')) = '".$_SESSION['user_id']."'";
$res = mysqli_query($db,$sql);
if($res->num_rows>0){
    $line=mysqli_fetch_array($res,MYSQLI_NUM);
    exit($line[1]);
}
?>