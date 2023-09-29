<?php
require_once("../../_functions.php");
require_once("../../_check_for_admin.php");
// Если запрос идёт не из Ajax
if( $_SERVER['HTTP_X_REQUESTED_WITH'] != "XMLHttpRequest" )
{
    exit("Access denied!");
}
//-------------------------------------------------------------------------------------------------//
$upd = "UPDATE tusers SET 
        blocked=1,
        u_upd='".$_SESSION['user']."', 
        d_upd=now()
        WHERE udln is null and gryppa!='admin'";
if (mysqli_query($db, $upd) != true) exit('Внутренняя ошибка.');

?>