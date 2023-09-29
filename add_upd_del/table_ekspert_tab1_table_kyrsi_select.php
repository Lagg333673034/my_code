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
$sql = "select id,
id_zanyatie, 
nazvanie_kyrsov, 
profil_kvalifik, 
spec_kvalifik,
if(god_prohojd=0,'',god_prohojd) 
from tekspert_kyrsi 
where udln is null 
and id_ekspert=$id_ekspert 
and id=$id_kyrsi";
$res = mysqli_query($db, $sql);
$line = mysqli_fetch_array($res, MYSQLI_NUM);
echo
    htmlspecialchars_decode($line[1], ENT_QUOTES)."@%#$!^*!".
    htmlspecialchars_decode($line[2], ENT_QUOTES)."@%#$!^*!".
    htmlspecialchars_decode($line[3], ENT_QUOTES)."@%#$!^*!".
    htmlspecialchars_decode($line[4], ENT_QUOTES)."@%#$!^*!".
    htmlspecialchars_decode($line[5], ENT_QUOTES);

?>