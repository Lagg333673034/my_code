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
$id_ekspert=check_number($_GET['id_ekspert']);
if($id_ekspert=='') $id_ekspert=0;
//-------------------------------------------------------------------------------------------------//
print $action;

?>