<?php
require_once("../_functions.php");
require_once("../_check_for_admin.php");
// Если запрос идёт не из Ajax
if( $_SERVER['HTTP_X_REQUESTED_WITH'] != "XMLHttpRequest" )
{
    exit("Access denied!");
}
//-------------------------------------------------------------------------------------------------//
$tabl='t'.check_number($_GET['tabl']);
$column=check_number($_GET['column']);
$hide=check_number($_GET['hide']); //shifrovanie

if($hide==1){
    $column=" aes_decrypt(unhex($column),'$sol_hex_fio') ";
}

$str='';
$sql = "SELECT $column FROM $tabl WHERE udln is null group by $column order by $column";
$res = mysqli_query($db, $sql);
while($line = mysqli_fetch_array($res, MYSQLI_NUM))
    $str.= htmlspecialchars_decode($line[0], ENT_QUOTES)."@%#$!^*!";
$str = check_string(substr($str,0,-8));

echo $str;


?>