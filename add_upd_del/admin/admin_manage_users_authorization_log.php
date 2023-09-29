<?php
require_once("../../_functions.php");
require_once("../../_check_for_admin.php");
// Если запрос идёт не из Ajax
if( $_SERVER['HTTP_X_REQUESTED_WITH'] != "XMLHttpRequest" )
{
    exit("Access denied!");
}
//-------------------------------------------------------------------------------------------------//
/*print"<table class='tbl_tmp'>
    <thead>
    <tr>
        <th>ID</th>
        <th>User</th>
        <th>Дата блокировки</th>
    </tr>
    </thead>";
$sql_tblack_list_users = "select id, user, DATE_FORMAT(data, '%d.%m.%Y - %H:%i:%s') from tblack_list_users";
$res_tblack_list_users = mysqli_query($db, $sql_tblack_list_users);
if($res_tblack_list_users->num_rows == 0){
    print"<tr><td colspan='3'>(пусто)</td></tr>";
}else {
    while ($line_tblack_list_users = mysqli_fetch_array($res_tblack_list_users, MYSQLI_NUM)) {
        print"<tr>";
        print"<td>$line_tblack_list_users[0]</td>";
        print"<td>$line_tblack_list_users[1]</td>";
        print"<td>$line_tblack_list_users[2]</td>";
        print"</tr>";
    }
}
print"</table>";
print"<br>";*/

print"<table class='tbl_tmp w100'>";
print"<thead>";
print"<tr>";
print"<th class='w30px'>ID</th>";
print"<th class='w120px'>Дата попытки</th>";
print"<th class='w110px'>IP</th>";
print"<th>Браузер</th>";
print"<th class='w90px'>Логин</th>";
print"<th class='w75px'>Пароль</th>";
print"</tr>";
print"</thead>";
print"<tbody>";
$sql_tconnections = "SELECT id, DATE_FORMAT(data, '%d.%m.%Y - %H:%i:%s'), s_kakogo_ip, brayzer, login, pass FROM tconnections";
$res_tconnections = mysqli_query($db, $sql_tconnections);
while ($line_tconnections = mysqli_fetch_array($res_tconnections, MYSQLI_NUM)) {
    print"<tr>";
    print"<td class='w30px'>$line_tconnections[0]</td>";
    print"<td class='w120px'>$line_tconnections[1]</td>";
    print"<td class='w110px'>".long2ip($line_tconnections[2])."</td>";
    print"<td class='textl'>".$line_tconnections[3]."</td>";
    print"<td class='w90px'>$line_tconnections[4]</td>";
    print"<td class='w75px'>$line_tconnections[5]</td>";
    print"</tr>";
}
print"</tbody>";
print"</table>";

?>