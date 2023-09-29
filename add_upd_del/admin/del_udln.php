<?php
require_once("../../_functions.php");
require_once("../../_check_for_admin.php");
// Если запрос идёт не из Ajax
if( $_SERVER['HTTP_X_REQUESTED_WITH'] != "XMLHttpRequest" )
{
    exit("Access denied!");
}
//-------------------------------------------------------------------------------------------------//
$num=0;
//-------------------------------------------------------------------------------------------------//
//del udln
/*
$tables = array(
    "torg",
    "torg_akkred",
    "torg_akkred_osn",
    "torg_kod_ved",
    "torg_licenziya_dop",
    "torg_licenziya_osn",
    "tproverka",
    "tproverka_informirovanie",
    "tproverka_obrashenie",
    "tproverka_plan",
    "tproverka_pochta",
    "tproverka_predpisanie",
    "tproverka_proveraysh",
    "tproverka_sovmestno",
    "tusers",
    "tvidi_ate",
    "tvidi_cel_proverki",
    "tvidi_doljnost",
    "tvidi_forma_proverki",
    "tvidi_kod_ved",
    "tvidi_kvartal",
    "tvidi_obrazov_progr",
    "tvidi_organiz_prav_forma",
    "tvidi_org_name",
    "tvidi_osnovanie_proverki",
    "tvidi_podvid_dop_obr",
    "tvidi_prof_spec",
    "tvidi_prof_spec_ykrypn",
    "tvidi_spisok_lydei",
    "tvidi_tip_obr_org",
    "tvidi_vid_rezyltata_proverki",
    "tvidi_years",
    "tvidi_yroven_obrazov"
);
for($i=0;$i<count($tables);$i++){
    $sql = "DELETE FROM $tables[$i] WHERE udln is not null";
    if(mysqli_query($db, $sql)!=true){
        exit('Неизвестная ошибка при удалении строк в таблице '.$tables[$i]);
    }else{
        $num+=mysqli_affected_rows($db);
    }
}
exit('Количество удалённых строк (udln): '.$num);
*/
//-------------------------------------------------------------------------------------------------//
//celostnost dannih (ydalit lishnee)
//iz torg
/*
$tables = array(
    "torg_akkred",
    "torg_akkred_osn",
    "torg_kod_ved",
    "torg_licenziya_dop",
    "torg_licenziya_osn"
);
$sql = "SELECT group_concat(id) FROM torg WHERE udln is not null";
$res = mysqli_query($db, $sql);
$id_org = mysqli_fetch_array($res, MYSQLI_NUM);
if($id_org[0]=='') $id_org[0]=0;
for($i=0;$i<count($tables);$i++){
    $sql = "DELETE FROM $tables[$i] WHERE udln is not null and id_org in ($id_org[0])";
    if(mysqli_query($db, $sql)!=true){
        exit('Неизвестная ошибка при удалении строк в таблице '.$tables[$i]);
    }else{
        $num+=mysqli_affected_rows($db);
    }
}
exit('Количество удалённых строк (torg): '.$num);
*/

//iz tproverka
/*
$tables = array(
    "tproverka_informirovanie",
    "tproverka_obrashenie",
    "tproverka_pochta",
    "tproverka_predpisanie",
    "tproverka_proveraysh",
    "tproverka_sovmestno"
);
$sql = "SELECT id FROM tproverka WHERE udln is not null";
$res = mysqli_query($db, $sql);
$id_proverka = mysqli_fetch_array($res, MYSQLI_NUM);
if($id_proverka[0]=='') $id_proverka[0]=0;
$num=0;
for($i=0;$i<count($tables);$i++){
    $sql = "DELETE FROM $tables[$i] WHERE udln is not null and id_proverka in ($id_proverka[0])";
    if(mysqli_query($db, $sql)!=true){
        exit('Неизвестная ошибка при удалении строк в таблице '.$tables[$i]);
    }else{
        $num+=mysqli_affected_rows($db);
    }
}
exit('Количество удалённых строк (tproverka): '.$num);
*/
//-------------------------------------------------------------------------------------------------//
?>