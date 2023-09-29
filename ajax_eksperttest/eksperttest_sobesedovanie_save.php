<?php
require_once("../_functions.php");
// Если запрос идёт не из Ajax
if( $_SERVER['HTTP_X_REQUESTED_WITH'] != "XMLHttpRequest" )
{
    exit("Access denied!");
}
//-------------------------------------------------------------------------------------------------//
if($_SESSION['gryppa'] != md5('ekspert'.$sol_user_gryppa)){
    exit("Access denied!");
}
//-------------------------------------------------------------------------------------------------//
//-------------------------------------------------------------------------------------------------//
$sobesedovanie=check_mass_primechanie($_POST['sobesedovanie']);
$sobesedovanie_otvet=check_mass_primechanie($_POST['sobesedovanie_otvet']);
//-------------------------------------------------------------------------------------------------//
//-------------------------------------------------------------------------------------------------//
$sql_user_id="SELECT id FROM tusers WHERE udln is null and md5(concat(id,'".$sol_user_id."')) = '".$_SESSION['user_id']."'";
$res_user_id = mysqli_query($db,$sql_user_id);
$line_user_id=mysqli_fetch_array($res_user_id,MYSQLI_NUM);
$user_id=$line_user_id[0];

$sql_eksperttest_id="SELECT id FROM teksperttest WHERE udln is null and id_user=$user_id";
$res_eksperttest_id = mysqli_query($db,$sql_eksperttest_id);
$line_eksperttest_id=mysqli_fetch_array($res_eksperttest_id,MYSQLI_NUM);
$eksperttest_id=$line_eksperttest_id[0];
//-------------------------------------------------------------------------------------------------//
//-------------------------------------------------------------------------------------------------//
$sql_check = "SELECT id FROM teksperttest WHERE udln is null and id=$eksperttest_id and test_result_confirm is null";
$res_check = mysqli_query($db, $sql_check);
if($res_check->num_rows == 0) {
    exit('Ошибка. Результат теста уже подтверждён.');
}
//-------------------------------------------------------------------------------------------------//
//-------------------------------------------------------------------------------------------------//
if(count((array)$sobesedovanie)>0){
    for($i=0;$i<count((array)$sobesedovanie);$i++) {
        if($sobesedovanie[$i]!='' && $sobesedovanie_otvet[$i]!='') {
            $sql = "UPDATE teksperttest_sobesedovanie SET
            u_upd='" . $_SESSION['user'] . "', 
            d_upd=now(),
            sobesedovanie_otvet='$sobesedovanie_otvet[$i]' 
            WHERE udln is null and id=$sobesedovanie[$i]";
            if (mysqli_query($db, $sql) != true) exit('Неизвестная ошибка при сохранении данных (teksperttest_sobesedovanie)(обновление).');
        }
    }
}

?>