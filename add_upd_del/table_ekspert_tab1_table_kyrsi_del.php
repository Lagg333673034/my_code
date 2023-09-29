<?php
require_once("../_functions.php");
require_once("../_check_for_admin.php");
require_once("../_mark_activity.php");
// Если запрос идёт не из Ajax
if( $_SERVER['HTTP_X_REQUESTED_WITH'] != "XMLHttpRequest" )
{
    exit("Access denied!");
}
//-------------------------------------------------------------------------------------------------//
$id_ekspert=check_string($_GET['id_ekspert']);
$id_kyrsi=check_string($_GET['id_kyrsi']);
//-------------------------------------------------------------------------------------------------//
if($id_ekspert=='') $id_ekspert=0;
if($id_kyrsi=='') $id_kyrsi=0;
//-------------------------------------------------------------------------------------------------//
if($id_ekspert>0 && $id_kyrsi>0){
    $sql = "UPDATE tekspert_kyrsi SET 
    u_upd = '" . $_SESSION['user'] . "', 
    d_upd = now(), 
    udln=now() 
    WHERE udln is null 
    and id_ekspert=$id_ekspert 
    and id=$id_kyrsi";
    if(mysqli_query($db, $sql)!=true) exit('Неизвестная ошибка при удалении.');
}
//-------------------------------------------------------------------------------------------------//
print check_string($_GET['action']);
?>