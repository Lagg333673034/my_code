<?php
require_once("../../_functions.php");
require_once("../../_check_for_admin.php");
// Если запрос идёт не из Ajax
if( $_SERVER['HTTP_X_REQUESTED_WITH'] != "XMLHttpRequest" )
{
    exit("Access denied!");
}
//-------------------------------------------------------------------------------------------------//
$id_user=check_number($_GET['id_user']);
//-------------------------------------------------------------------------------------------------//
$sql = "select user, '********', gryppa from tusers where udln is null and id = $id_user";
$res=mysqli_query($db, $sql);
$line=mysqli_fetch_array($res,MYSQLI_NUM);

echo $line[0].'@%#$!%$@'.$line[1].'@%#$!%$@'.$line[2];


?>