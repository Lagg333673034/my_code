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
$upd = "UPDATE tusers SET 
        blocked=0,
        u_upd='" . $_SESSION['user'] . "', 
        d_upd=now()
        WHERE udln is null and id=$id_user";
if (mysqli_query($db, $upd) != true) exit('Внутренняя ошибка.');



?>