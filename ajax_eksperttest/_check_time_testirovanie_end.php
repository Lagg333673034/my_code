<?php
require_once("../_functions.php");
// Если запрос идёт не из Ajax
if( $_SERVER['HTTP_X_REQUESTED_WITH'] != "XMLHttpRequest" )
{
    exit("Access denied!");
}
//------------------------------------------------------------------------------------------------//
if(
    (isset($_SESSION['gryppa']) && !empty($_SESSION['gryppa']) && $_SESSION['gryppa']==md5('ekspert' . $sol_user_gryppa))
){
    exit("".check_testirovanie_time()[0]);
}
//------------------------------------------------------------------------------------------------//

?>