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
if(md5($id_user.$sol_user_id)==$_SESSION['user_id']){
    exit('Вы не можете удалить свою учётную запись.');
}

$sql = "update tusers set 
        udln=now(), 
        u_upd='".$_SESSION['user']."', 
        d_upd=now() 
        where udln is null and id = $id_user";
if (mysqli_query($db, $sql) != true) exit('Внутренняя ошибка.');

?>