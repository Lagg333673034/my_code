<?php
require_once("../_functions.php");
require_once("../_check_for_admin.php");
// Если запрос идёт не из Ajax
if( $_SERVER['HTTP_X_REQUESTED_WITH'] != "XMLHttpRequest" )
{
    exit("Access denied!");
}
//-------------------------------------------------------------------------------------------------//
$str='';
$sql = "SELECT t1.name1 
from( 
select obych_nazv_kyrsov as name1 FROM tekspert WHERE udln is null 
)t1 
group by t1.name1 
order by t1.name1";
$res = mysqli_query($db, $sql);
while($line = mysqli_fetch_array($res, MYSQLI_NUM)) {
    $str .= htmlspecialchars_decode($line[0], ENT_QUOTES) . "@%#$!^*!";
}
$str = check_string(substr($str,0,-8));
echo $str;

?>