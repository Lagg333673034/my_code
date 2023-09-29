<?php
require_once("../../_functions.php");
require_once("../../_check_for_admin.php");
// Если запрос идёт не из Ajax
if( $_SERVER['HTTP_X_REQUESTED_WITH'] != "XMLHttpRequest" )
{
    exit("Access denied!");
}
//-----------------------------------------------------------------------------------------------------------//
//-----------------------------------------------------------------------------------------------------------//
$sql = "select 
id, 
user, 
gryppa, 
if(blocked=0,'OK','locked'), 
DATE_FORMAT(last_authorization_data, '%d.%m.%Y - %H:%i:%s'), 
DATE_FORMAT(last_activity_data, '%d.%m.%Y - %H:%i:%s'),
DATE_FORMAT(last_connection_data, '%d.%m.%Y - %H:%i:%s'), 
if(gryppa='admin',0,if(gryppa='user','1','2')) gryppa1 
from tusers  
where udln is null 
order by gryppa1, blocked, user";
$res = mysqli_query($db, $sql);
$npp=1;
while ($line = mysqli_fetch_array($res, MYSQLI_NUM)) {
    //--------------------------------------------------------------------------------------//
    $name_color='';
    //--------------------------------------------------------------------------------------//
    if($line[2]=='admin') $name_color='red1';
    //--------------------------------------------------------------------------------------//
    if($line[2]=='ekspert') {
        $est_test = "<span class='glyphicon glyphicon-minus color_red5 floatr' title='Тест НЕ проходил'></span>";

        $sql_eksperttest = "select id from teksperttest where udln is null and id_user=$line[0]";
        $res_eksperttest = mysqli_query($db, $sql_eksperttest);
        if ($res_eksperttest->num_rows > 0) {
            $line_eksperttest = mysqli_fetch_array($res_eksperttest, MYSQLI_NUM);

            $sql_eksperttest_vopros = "select id from teksperttest_vopros where udln is null and id_eksperttest=$line_eksperttest[0]";
            $res_eksperttest_vopros = mysqli_query($db, $sql_eksperttest_vopros);
            if ($res_eksperttest_vopros->num_rows > 0) {
                $est_test = "<span class='glyphicon glyphicon-ok color_green10 floatr' title='Тест проходил'></span>";
            }
        }
    }
    //--------------------------------------------------------------------------------------//
    print"<tr>";
    print"<td class='w30px'>$npp</td>";
    print"<td class='w20px'><input type='checkbox' id='ch" . $npp++ . "' value='" . $line[0] . "'></td>";
    print"<td class='w150px textl padding_left10 padding_right5 $name_color'>$line[1] $est_test</td>";
    print"<td class='w90px'>$line[2]</td>";
    print"<td class='w60px'>$line[3]</td>";
    print"<td class='w150px'>$line[4]</td>";
    print"<td class='w150px'>$line[5]</td>";
    print"<td class='w150px'>$line[6]</td>";
    print"<td class='w100px'>";
    print"<button disabled class='btn btn-xs btn-default w100 btn_activity_log' value='$line[0]'>select only</button>";
    print"</td>";
    print"</tr>";
}
//-----------------------------------------------------------------------------------------------------------//



?>