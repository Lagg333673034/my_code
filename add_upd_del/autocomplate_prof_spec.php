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
$sql = "SELECT 
concat(kod, ' -- ', name), 
if(kod like '%.%', substring(kod,1,2),kod) a1, 
if(kod like '%.%', substring(kod,4,2),kod) a2, 
if(kod like '%.%', substring(kod,7,2),kod) a3,
rf 
FROM tvidi_prof_spec WHERE udln is null order by a2,a1,a3";
$res = mysqli_query($db, $sql);
while($line = mysqli_fetch_array($res, MYSQLI_NUM)) {
    //-------------------------------------------------------------------------------------------------//
    if($line[4]==1){
        $str .= htmlspecialchars_decode($line[0].$rf, ENT_QUOTES) . "@%#$!^*!";
    }else{
        $str .= htmlspecialchars_decode($line[0], ENT_QUOTES) . "@%#$!^*!";
    }
    //-------------------------------------------------------------------------------------------------//
}
$str = check_string(substr($str,0,-8));

echo $str;



?>