<?php
require_once("../_functions.php");
require_once("../_check_for_admin.php");
// Если запрос идёт не из Ajax
if( $_SERVER['HTTP_X_REQUESTED_WITH'] != "XMLHttpRequest" )
{
    exit("Access denied!");
}
//-------------------------------------------------------------------------------------------------//
unset($one_array);
$one_array[] = '';
//-------------------------------------------------------------------------------------------------//
$sql = "SELECT t1.name1 
from( 
select otch as name1 FROM tekspert WHERE udln is null 
)t1 
group by t1.name1 
order by t1.name1";
$res = mysqli_query($db, $sql);
while($line = mysqli_fetch_array($res, MYSQLI_NUM)) {
    $one_array[] = $line[0];
}
//-------------------------------------------------------------------------------------------------//
if($db_proverki!='') {
    $sql_proverki = "SELECT t1.name1
    from( 
    select ryk_otchestvo as name1 FROM torg WHERE udln is null
    )t1 
    group by t1.name1 
    order by t1.name1";
    $res_proverki = mysqli_query($db_proverki, $sql_proverki);
    while ($line_proverki = mysqli_fetch_array($res_proverki, MYSQLI_NUM)) {
        $one_array[] = $line_proverki[0];
    }
}
//-------------------------------------------------------------------------------------------------//
$array = array_values(array_unique($one_array));
//-------------------------------------------------------------------------------------------------//
$str='';
for ($i = 0; $i < count($array); $i++) {
    $str .= htmlspecialchars_decode($array[$i], ENT_QUOTES) . "@%#$!^*!";
}
$str = check_string(substr($str,0,-8));
//-------------------------------------------------------------------------------------------------//
echo $str;
?>