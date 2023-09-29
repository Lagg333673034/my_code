<?php
require_once("../../_functions.php");
require_once("../../_check_for_admin.php");
// Если запрос идёт не из Ajax
if( $_SERVER['HTTP_X_REQUESTED_WITH'] != "XMLHttpRequest" )
{
    exit("Access denied!");
}
//-------------------------------------------------------------------------------------------------//
$id=check_number($_GET['id']);
//-------------------------------------------------------------------------------------------------//
print"<table class='tbl_tmp w100'>";
print"<thead>";
print"<tr>";
print"<th class='w30px'>№<br>п.п.</th>";
print"<th class='w120px'>Пользователь</th>";
print"<th class='w120px'>Дата создания</th>";
print"<th class='w120px'>Пользователь</th>";
print"<th class='w120px'>Дата обновления</th>";
print"<th class='w120px'>Таблица</th>";
print"<th></th>";
print"</tr>";
print"</thead>";
print"<tbody>";
$npp=1;
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
    "tproverka_sovmestno"
);
for($i=0,$sql_log="";$i<count($tables);$i++,$sql_log.=" union "){
    $sql_log .= "select u_cr a1, DATE_FORMAT(d_cr, '%d.%m.%Y - %H:%i:%s') a2, u_upd a3, DATE_FORMAT(d_upd, '%d.%m.%Y - %H:%i:%s') a4, '$tables[$i]' a5 FROM $tables[$i] WHERE DATE_FORMAT(d_cr, '%d.%m.%Y')=DATE_FORMAT(now(), '%d.%m.%Y') or DATE_FORMAT(d_upd, '%d.%m.%Y')=DATE_FORMAT(now(), '%d.%m.%Y')";
}
$sql_log=substr($sql_log, 0, -7);
$sql_log.=" order by a4 desc";
$res_log = mysqli_query($db, $sql_log);
if($res_log->num_rows > 0) {
    while ($line_log = mysqli_fetch_array($res_log, MYSQLI_NUM)) {
        print"<tr>";
        print"<td class='w30px'>$npp</td>";
        print"<td class='w120px'>$line_log[0]</td>";
        print"<td class='w120px'>$line_log[1]</td>";
        print"<td class='w120px'>$line_log[2]</td>";
        print"<td class='w120px'>$line_log[3]</td>";
        print"<td class='w120px'>$line_log[4]</td>";
        print"</tr>";
        $npp += 1;
    }
}
print"</tbody>";
print"</table>";


?>