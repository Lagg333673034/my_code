<?php
require_once("../../_functions.php");
require_once("../../_check_for_admin.php");
// Если запрос идёт не из Ajax
if( $_SERVER['HTTP_X_REQUESTED_WITH'] != "XMLHttpRequest" )
{
    exit("Access denied!");
}
//-------------------------------------------------------------------------------------------------//
$tbl_num=check_number($_GET['tbl_num']);
$id=check_number($_GET['id']);

$nazvanie=check_string($_GET['nazvanie']);
$id_yroven_obrazov=check_string($_GET['id_yroven_obrazov']);
$id_vopros=check_string($_GET['id_vopros']);
$prav_otvet=check_string($_GET['prav_otvet']);
$always_show=check_string($_GET['always_show']);
$sortirovka=check_string($_GET['sortirovka']);

$testirovanie_data_begin=check_string($_GET['testirovanie_data_begin']);
$testirovanie_data_end=check_string($_GET['testirovanie_data_end']);
$testirovanie_time_vsego_minyt=check_string($_GET['testirovanie_time_vsego_minyt']);
$sobesedovanie_time_vsego_minyt=check_string($_GET['sobesedovanie_time_vsego_minyt']);
//------------------------------------------------------------//
if($prav_otvet=='') $prav_otvet=0;
if($always_show==''){
    $always_show='null';
}else{
    $always_show="'$always_show'";
}
if($sortirovka=='') $sortirovka=0;

if($testirovanie_data_begin==''){
    $testirovanie_data_begin='null';
}else{
    $testirovanie_data_begin="'$testirovanie_data_begin'";
}
if($testirovanie_data_end==''){
    $testirovanie_data_end='null';
}else{
    $testirovanie_data_end="'$testirovanie_data_end'";
}
if($testirovanie_time_vsego_minyt==''){
    $testirovanie_time_vsego_minyt='null';
}else{
    $testirovanie_time_vsego_minyt="'$testirovanie_time_vsego_minyt'";
}
if($sobesedovanie_time_vsego_minyt==''){
    $sobesedovanie_time_vsego_minyt='null';
}else{
    $sobesedovanie_time_vsego_minyt="'$sobesedovanie_time_vsego_minyt'";
}
//------------------------------------------------------------//
$error0 = "Неизвестная ошибка.";
$error1 = "В этой таблице уже есть такая запись.";
//------------------------------------------------------------//
if($tbl_num==3) {
    if($id==0){
        $sql = "SELECT id from $tables[$tbl_num] where udln is null and name='$nazvanie'";
        $res = mysqli_query($db, $sql);
        if($res->num_rows == 0) {
            $sql = "INSERT INTO $tables[$tbl_num] (u_cr, d_cr, u_upd, d_upd, name, sort)values('" . $_SESSION['user'] . "', now(), '" . $_SESSION['user'] . "', now(), 
            '$nazvanie', $sortirovka)";
            if (mysqli_query($db, $sql) != true) exit($error0);
        }else{
            exit($error1);
        }
    }
    if($id>0){
        $sql = "SELECT id from $tables[$tbl_num] where udln is null and name='$nazvanie' and id!=$id";
        $res = mysqli_query($db, $sql);
        if($res->num_rows == 0) {
            $sql = "update $tables[$tbl_num] set 
            name='$nazvanie', 
            sort=$sortirovka
            where udln is null and id=$id";
            if (mysqli_query($db, $sql) != true) exit($error0);
        }else{
            exit($error1);
        }
    }
}

if($tbl_num==1) {
    if($id==0){
        $sql = "SELECT id from $tables[$tbl_num] where udln is null and name='$nazvanie' and id_yroven_obrazov=$id_yroven_obrazov";
        $res = mysqli_query($db, $sql);
        if($res->num_rows == 0) {
            $sql = "INSERT INTO $tables[$tbl_num] (
            u_cr, d_cr, u_upd, d_upd, 
            name, id_yroven_obrazov, sort
            )values(
            '" . $_SESSION['user'] . "', now(), '" . $_SESSION['user'] . "', now(), 
            '$nazvanie', $id_yroven_obrazov, $sortirovka)";
            if (mysqli_query($db, $sql) != true) exit($error0);
        }else{
            exit($error1);
        }
    }
    if($id>0){
        $sql = "SELECT id from $tables[$tbl_num] where udln is null and name='$nazvanie' and id_yroven_obrazov=$id_yroven_obrazov and id!=$id";
        $res = mysqli_query($db, $sql);
        if($res->num_rows == 0) {
            $sql = "update $tables[$tbl_num] set 
            name='$nazvanie', 
            id_yroven_obrazov=$id_yroven_obrazov, 
            sort=$sortirovka 
            where udln is null and id=$id";
            if (mysqli_query($db, $sql) != true) exit($error0);
        }else{
            exit($error1);
        }
    }
}

if($tbl_num==2) {
    if($id==0){
        $sql = "SELECT id from $tables[$tbl_num] where udln is null and id_vopros=$id_vopros and name='$nazvanie'";
        $res = mysqli_query($db, $sql);
        if($res->num_rows == 0) {
            $sql = "INSERT INTO $tables[$tbl_num] (
            u_cr, d_cr, u_upd, d_upd, 
            id_vopros, name, prav_otvet, sort
            )values(
            '" . $_SESSION['user'] . "', now(), '" . $_SESSION['user'] . "', now(), 
            $id_vopros, '$nazvanie', $prav_otvet, $sortirovka)";
            if (mysqli_query($db, $sql) != true) exit($error0);
        }else{
            exit($error1);
        }
    }
    if($id>0){
        $sql = "SELECT id from $tables[$tbl_num] where udln is null and id_vopros=$id_vopros and name='$nazvanie' and id!=$id";
        $res = mysqli_query($db, $sql);
        if($res->num_rows == 0) {
            $sql = "update $tables[$tbl_num] set 
            id_vopros=$id_vopros,
            name='$nazvanie', 
            prav_otvet=$prav_otvet, 
            sort=$sortirovka 
            where udln is null and id=$id";
            if (mysqli_query($db, $sql) != true) exit($error0);
        }else{
            exit($error1);
        }
    }
}

if($tbl_num==4) {
    if($id==0){
        $sql = "SELECT id from $tables[$tbl_num] where udln is null and name='$nazvanie'";
        $res = mysqli_query($db, $sql);
        if($res->num_rows == 0) {
            $sql = "INSERT INTO $tables[$tbl_num] (u_cr, d_cr, u_upd, d_upd, name, always_show, sort)values('" . $_SESSION['user'] . "', now(), '" . $_SESSION['user'] . "', now(), 
            '$nazvanie', $always_show, $sortirovka)";
            if (mysqli_query($db, $sql) != true) exit($error0);
        }else{
            exit($error1);
        }
    }
    if($id>0){
        $sql = "SELECT id from $tables[$tbl_num] where udln is null and name='$nazvanie' and id!=$id";
        $res = mysqli_query($db, $sql);
        if($res->num_rows == 0) {
            $sql = "update $tables[$tbl_num] set 
            name='$nazvanie', 
            always_show=$always_show,
            sort=$sortirovka
            where udln is null and id=$id";
            if (mysqli_query($db, $sql) != true) exit($error0);
        }else{
            exit($error1);
        }
    }
}

if($tbl_num==5) {
    if($id==0){
        $sql = "SELECT id from $tables[$tbl_num] where udln is null and testirovanie_data_begin=$testirovanie_data_begin";
        $res = mysqli_query($db, $sql);
        if($res->num_rows == 0) {
            $sql = "INSERT INTO $tables[$tbl_num] (u_cr, d_cr, u_upd, d_upd, 
            testirovanie_data_begin, testirovanie_data_end, 
            testirovanie_time_vsego_minyt, sobesedovanie_time_vsego_minyt
            )values('" . $_SESSION['user'] . "', now(), '" . $_SESSION['user'] . "', now(), 
            STR_TO_DATE($testirovanie_data_begin,'%d.%m.%Y %H:%i'), STR_TO_DATE($testirovanie_data_end,'%d.%m.%Y %H:%i'), 
            $testirovanie_time_vsego_minyt, $sobesedovanie_time_vsego_minyt)";
            if (mysqli_query($db, $sql) != true) exit($error0);
        }else{
            exit($error1);
        }
    }
    if($id>0){
        $sql = "SELECT id from $tables[$tbl_num] where udln is null and testirovanie_data_begin=$testirovanie_data_begin and id!=$id";
        $res = mysqli_query($db, $sql);
        if($res->num_rows == 0) {
            $sql = "update $tables[$tbl_num] set 
            testirovanie_data_begin=STR_TO_DATE($testirovanie_data_begin,'%d.%m.%Y %H:%i'),
            testirovanie_data_end=STR_TO_DATE($testirovanie_data_end,'%d.%m.%Y %H:%i'), 
            testirovanie_time_vsego_minyt=$testirovanie_time_vsego_minyt, 
            sobesedovanie_time_vsego_minyt=$sobesedovanie_time_vsego_minyt 
            where udln is null and id=$id";
            if (mysqli_query($db, $sql) != true) exit($error0);
        }else{
            exit($error1);
        }
    }
}

?>