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
print"<th class='w30px'>ID</th>";
print"<th class='w80px'>User</th>";
print"<th class='w120px'>Time</th>";
print"<th>Log</th>";
print"</tr>";
print"</thead>";
print"<tbody>";
$sql_log = "SELECT tusers_log.id, tusers.user, DATE_FORMAT(tusers_log.d_cr, '%d.%m.%Y - %H:%i:%s'), tusers_log.log 
FROM tusers_log 
left join tusers on tusers.id=tusers_log.id_user 
where tusers.id=$id 
order by tusers_log.d_cr";
$res_log = mysqli_query($db, $sql_log);
while ($line_log = mysqli_fetch_array($res_log, MYSQLI_NUM)) {
    print"<tr>";
    print"<td class='w30px'>$line_log[0]</td>";
    print"<td class='w80px'>$line_log[1]</td>";
    print"<td class='w120px'>$line_log[2]</td>";
    print"<td class='textl'>" . $line_log[3] . "</td>";
    print"</tr>";
}
print"</tbody>";
print"</table>";


?>