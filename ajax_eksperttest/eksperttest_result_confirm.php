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
$sql="SELECT id FROM tusers WHERE udln is null and md5(concat(id,'".$sol_user_id."')) = '".$_SESSION['user_id']."'";
$res = mysqli_query($db,$sql);
$line=mysqli_fetch_array($res,MYSQLI_NUM);
if($line[0]==''){
    exit("Не обнаружен 'user_id'");
}else{
    $user_id=$line[0];
}
//-------------------------------------------------------------------------------------------------//
//-------------------------------------------------------------------------------------------------//
$sql = "UPDATE teksperttest SET
        u_upd='" . $_SESSION['user'] . "', 
        d_upd=now(), 
        sobesedovanie_time_end=now(), 
        test_result_confirm=1 
        WHERE udln is null and id_user=$user_id";
if(mysqli_query($db, $sql)!=true) exit('Неизвестная ошибка при сохранении данных (test_result_confirm)(обновление).');
//-------------------------------------------------------------------------------------------------//
//-------------------------------------------------------------------------------------------------//
?>