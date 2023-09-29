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
$filtr_yroven_obrazov=check_number($_POST['filtr_yroven_obrazov']);
$fio=check_string($_POST['fio']);
$vopros=check_matr($_POST['vopros']);
$vopros_variant=check_matr($_POST['vopros_variant']);
//-------------------------------------------------------------------------------------------------//
if($filtr_yroven_obrazov=='') $filtr_yroven_obrazov=0;
if($fio=='') $fio='';
//-------------------------------------------------------------------------------------------------//
if($filtr_yroven_obrazov==0){
    exit('Выберите уровень образования');
}
if($fio==''){
    exit('Введите ФИО');
}
//-------------------------------------------------------------------------------------------------//
$sql = "select count(id) from tvidi_vopros where udln is null and id_yroven_obrazov=$filtr_yroven_obrazov";
$res = mysqli_query($db, $sql);
$line = mysqli_fetch_array($res, MYSQLI_NUM);
$vsego_nyjno_otvetit=$line[0];

$vsego_otvecheno = 0;
for($i=0;$i<count((array)$vopros);$i++) {
    if(count((array)$vopros_variant[($i + 1)])>0){
        $vsego_otvecheno+=1;
    }
}
if($vsego_nyjno_otvetit!=$vsego_otvecheno){
    exit('Выберите варианты ответов для всех вопросов');
}
//-------------------------------------------------------------------------------------------------//
//-------------------------------------------------------------------------------------------------//
//-------------------------------------------------------------------------------------------------//
$sql="SELECT id FROM tusers WHERE udln is null and md5(concat(id,'".$sol_user_id."')) = '".$_SESSION['user_id']."'";
$res = mysqli_query($db,$sql);
$line=mysqli_fetch_array($res,MYSQLI_NUM);
if($line[0]==''){
    exit("Не обнаружен 'user_id'");
}else{
    $user_id=$line[0];
}
//-------------------------------------------------------------------------------------------------//
//-------------------------------------------------------------------------------------------------//
$sql = "UPDATE teksperttest SET
        u_upd='" . $_SESSION['user'] . "', 
        d_upd=now(),
        test_time_end=now(),
        fio='" . $fio . "',
        id_yroven_obrazov=$filtr_yroven_obrazov 
        WHERE udln is null and id_user=$user_id";
if(mysqli_query($db, $sql)!=true) exit('Неизвестная ошибка при сохранении данных (start)(обновление).');
//-------------------------------------------------------------------------------------------------//
//-------------------------------------------------------------------------------------------------//
$sql = "select id from teksperttest where udln is null and id_user=$user_id";
$res = mysqli_query($db, $sql);
if ($res->num_rows == 1) {
    $line = mysqli_fetch_array($res, MYSQLI_NUM);
    $id_eksperttest = $line[0];
    //-------------------------------------------------------------------------------------------------//
    for($i=0;$i<count((array)$vopros);$i++) {
        for($j=0;$j<count((array)$vopros_variant[($i+1)]);$j++) {
            if(
                $vopros[$i]!='' && $vopros[$i]!=0 &&
                $vopros_variant[($i+1)][$j]!='' && $vopros_variant[($i+1)][$j]!=0
            ) {
                $sql = "INSERT INTO teksperttest_vopros(
                u_cr, d_cr, u_upd, d_upd, 
                id_eksperttest,id_vopros,id_vopros_variant
                ) VALUES (
                '" . $_SESSION['user'] . "', now(), '" . $_SESSION['user'] . "', now(),
                $id_eksperttest," . $vopros[$i] . "," . $vopros_variant[($i+1)][$j] . "
                )";
                if (mysqli_query($db, $sql) != true) exit('Неизвестная ошибка при сохранении данных (ТЕСТ).');
            }
        }
    }
    //-------------------------------------------------------------------------------------------------//
}else{
    exit("Ошибка при сохрании данных (Найдено больше одного пользователя с данным ID).");
}
//-------------------------------------------------------------------------------------------------//
//-------------------------------------------------------------------------------------------------//
//-------------------------------------------------------------------------------------------------//

?>