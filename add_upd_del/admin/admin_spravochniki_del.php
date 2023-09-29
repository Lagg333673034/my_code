<?php
require_once("../../_functions.php");
require_once("../../_check_for_admin.php");
// Если запрос идёт не из Ajax
if( $_SERVER['HTTP_X_REQUESTED_WITH'] != "XMLHttpRequest" )
{
    exit("Access denied!");
}
//-------------------------------------------------------------------------------------------------//
$tbl_num=check_number($_GET['tbl_num']);
$id=check_number($_GET['id']);
//------------------------------------------------------------//
if($id=='') $id=0;
//------------------------------------------------------------//
$sql = "UPDATE $tables[$tbl_num] SET 
        u_upd = '" . $_SESSION['user'] . "', 
        d_upd = now(), 
        udln = now()
        WHERE udln is null and id=$id";
if(mysqli_query($db, $sql)!=true) exit('Неизвестная ошибка при удалении данных.');

?>