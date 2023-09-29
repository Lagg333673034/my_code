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

$id_zanyatie=check_string($_GET['id_zanyatie']);
$nazvanie_kyrsov=check_string($_GET['nazvanie_kyrsov']);
$profil_kvalifik=check_string($_GET['profil_kvalifik']);
$spec_kvalifik=check_string($_GET['spec_kvalifik']);
$god_prohojd=check_string($_GET['god_prohojd']);
//-------------------------------------------------------------------------------------------------//
if($id_ekspert=='') $id_ekspert=0;
if($id_kyrsi=='') $id_kyrsi=0;

if($id_zanyatie=='') $id_zanyatie=0;
if($nazvanie_kyrsov=='') $nazvanie_kyrsov='';
if($profil_kvalifik=='') $profil_kvalifik='';
if($spec_kvalifik=='') $spec_kvalifik='';
if($god_prohojd=='') $god_prohojd=0;
//-------------------------------------------------------------------------------------------------//
//-------------------------------------------------------------------------------------------------//
if($id_ekspert>0 && $id_zanyatie!=0){
    if($id_kyrsi==0 && check_number($_GET['action_value'])==1){
        $sql = "INSERT INTO tekspert_kyrsi(
        u_cr, d_cr, u_upd, d_upd,
        id_ekspert,
        id_zanyatie,
        nazvanie_kyrsov,
        profil_kvalifik,
        spec_kvalifik,
        god_prohojd
        ) VALUES (
        '" . $_SESSION['user'] . "', now(), '" . $_SESSION['user'] . "', now(),
        $id_ekspert,
        $id_zanyatie,
        '" . $nazvanie_kyrsov . "',
        '" . $profil_kvalifik . "',
        '" . $spec_kvalifik . "',
        $god_prohojd
        )";
        if (mysqli_query($db, $sql) != true) exit('Неизвестная ошибка при добавлении курсов.');
    }
    if($id_kyrsi>0 && check_number($_GET['action_value'])==2){
        $sql = "UPDATE tekspert_kyrsi SET 
        u_upd = '" . $_SESSION['user'] . "', 
        d_upd = now(), 
  
        id_zanyatie=$id_zanyatie,
        nazvanie_kyrsov='" . $nazvanie_kyrsov . "',
        profil_kvalifik='" . $profil_kvalifik . "',
        spec_kvalifik='" . $spec_kvalifik . "',
        god_prohojd=$god_prohojd 
        
        WHERE udln is null 
        and id_ekspert=$id_ekspert 
        and id=$id_kyrsi";
        if (mysqli_query($db, $sql) != true) exit('Неизвестная ошибка при редактировании курсов');
    }
}
//-------------------------------------------------------------------------------------------------//
print check_string($_GET['action']);
?>