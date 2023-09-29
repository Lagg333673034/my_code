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
$filtr_sortirovka=check_string($_GET['filtr_sortirovka']);
$filtr_yroven_obrazov=check_string($_GET['filtr_yroven_obrazov']);
$poisk=check_string($_GET['poisk']);
//-------------------------------------------------------------------------------------------------//
$npp=1;
//-------------------------------------------------------------------------------------------------//
if($filtr_sortirovka!=0){
    if($filtr_sortirovka==1){
     
    }
}else{
    $str_filtr_sortirovka = " order by d_cr desc ";
}

if($filtr_yroven_obrazov!=''){
    $str_filtr_yroven_obrazov = " tvidi_yroven_obrazov.id=$filtr_yroven_obrazov ";
}else{
    $str_filtr_yroven_obrazov = " 1 ";
}

if($poisk!=''){
    $poisk_nazvanie = " $tables[$tbl_num].name like'%$poisk%' ";
}else{
    $poisk_nazvanie = " 1 ";
}
//------------------------------------------------------------//
if($tbl_num==3) {
    print"<table class='table_spravochnik'>";
    print"<thead>";
    print"<tr>";
    print"<th>№ п.п.</th>";
    print"<th></th>";
    print"<th>Название</th>";
    print"<th>Сортировка</th>";
    print"</tr>";
    print"</thead>";
    $sql = "SELECT id, name, sort FROM $tables[$tbl_num] WHERE udln is null and $poisk_nazvanie $str_filtr_sortirovka";
    $res = mysqli_query($db, $sql);
    while ($line = mysqli_fetch_array($res, MYSQLI_NUM)) {
        print"<tr>";
        print"<td>$npp</td>";
        print"<td><input type='checkbox' id='ch" . $npp . "' value='" . $line[0] . "'></td>";
        print"<td class='textl'>$line[1]</td>";
        print"<td class='textc'>$line[2]</td>";
        print"</tr>";
        $npp++;
    }
    print"</table>";
}

if($tbl_num==1) {
    print"<table class='table_spravochnik'>";
    print"<thead>";
    print"<tr>";
    print"<th>№ п.п.</th>";
    print"<th></th>";
    print"<th>Уровень образования<br>";
    print"<select id='filtr_yroven_obrazov' class='w100'><option value=''>все</option>";
    $sql_yroven_obrazov = "SELECT id, name FROM tvidi_yroven_obrazov where udln is null order by sort";
    $res_yroven_obrazov = mysqli_query($db, $sql_yroven_obrazov);
    while ($line_yroven_obrazov = mysqli_fetch_array($res_yroven_obrazov, MYSQLI_NUM)) {
        $selected = '';
        if ($filtr_yroven_obrazov == $line_yroven_obrazov[0]) $selected = "selected";
        print"<option value='$line_yroven_obrazov[0]' $selected>$line_yroven_obrazov[1]</option>";
    }
    print"</select>";
    print"</th>";
    print"<th>Вопрос</th>";
    print"<th>Сортировка</th>";
    print"</tr>";
    print"</thead>";
    $sql = "SELECT $tables[$tbl_num].id, tvidi_yroven_obrazov.name, $tables[$tbl_num].name, $tables[$tbl_num].sort 
    FROM $tables[$tbl_num] 
    left join tvidi_yroven_obrazov on tvidi_yroven_obrazov.id=$tables[$tbl_num].id_yroven_obrazov 
    WHERE $tables[$tbl_num].udln is null 
    and $str_filtr_yroven_obrazov 
    and $poisk_nazvanie 
    order by tvidi_yroven_obrazov.sort, $tables[$tbl_num].sort";
    $res = mysqli_query($db, $sql);
    while ($line = mysqli_fetch_array($res, MYSQLI_NUM)) {
        print"<tr>";
        print"<td class='font_size10'>$npp</td>";
        print"<td><input type='checkbox' class='height10 w10px' id='ch" . $npp . "' value='" . $line[0] . "'></td>";
        print"<td class='font_size12 textl verticalt w200px'>".check_abr($line[1])."</td>";
        print"<td class='font_size12 textl verticalt'>".my_substr1($line[2],100)."</td>";
        print"<td class='font_size10 textc verticalt w100px'>$line[3]</td>";
        print"</tr>";
        $npp++;
    }
    print"</table>";
}

if($tbl_num==2) {
    print"<table class='table_spravochnik'>";
    print"<thead>";
    print"<tr>";
    print"<th>№ п.п.</th>";
    print"<th></th>";
    print"<th>Уровень образования";
    print"<select id='filtr_yroven_obrazov' class='w100'><option value=''>все</option>";
    $sql_yroven_obrazov = "SELECT id, name FROM tvidi_yroven_obrazov where udln is null order by sort";
    $res_yroven_obrazov = mysqli_query($db, $sql_yroven_obrazov);
    while ($line_yroven_obrazov = mysqli_fetch_array($res_yroven_obrazov, MYSQLI_NUM)) {
        $selected = '';
        if ($filtr_yroven_obrazov == $line_yroven_obrazov[0]) $selected = "selected";
        print"<option value='$line_yroven_obrazov[0]' $selected>$line_yroven_obrazov[1]</option>";
    }
    print"</select>";
    print"</th>";
    print"<th>Вопрос</th>";
    print"<th>Вариант ответа</th>";
    print"<th class='font_size10'>Прав.<br>отв.</th>";
    print"<th class='font_size10'>Сорт.</th>";
    print"</tr>";
    print"</thead>";
    $sql = "SELECT tvidi_vopros_variant.id, 
tvidi_yroven_obrazov.name, 
tvidi_vopros.name,
tvidi_vopros_variant.name,
if(tvidi_vopros_variant.prav_otvet=1,tvidi_vopros_variant.prav_otvet,''),
 tvidi_vopros_variant.sort 
    FROM tvidi_vopros_variant 
    left join (tvidi_vopros
      left join tvidi_yroven_obrazov on tvidi_yroven_obrazov.id=tvidi_vopros.id_yroven_obrazov
    ) on tvidi_vopros.id=tvidi_vopros_variant.id_vopros
    WHERE tvidi_vopros_variant.udln is null 
    and $poisk_nazvanie 
    and $str_filtr_yroven_obrazov 
    order by tvidi_yroven_obrazov.sort, tvidi_vopros.sort, tvidi_vopros_variant.sort";
    $res = mysqli_query($db, $sql);
    while ($line = mysqli_fetch_array($res, MYSQLI_NUM)) {
        print"<tr>";
        print"<td class='font_size10'>$npp</td>";
        print"<td><input type='checkbox' class='height10 w10px' id='ch" . $npp . "' value='" . $line[0] . "'></td>";
        print"<td class='font_size10 textl verticalt w100px'>".check_abr($line[1])."</td>";
        print"<td class='font_size12 textl verticalt'>".my_substr1($line[2],50)."</td>";
        print"<td class='font_size12 textl verticalt w500px'>".my_substr1($line[3],80)."</td>";
        print"<td class='font_size10 textc verticalt w30px'>$line[4]</td>";
        print"<td class='font_size10 textc verticalt w30px'>$line[5]</td>";
        print"</tr>";
        $npp++;
    }
    print"</table>";
}

if($tbl_num==4) {
    print"<table class='table_spravochnik'>";
    print"<thead>";
    print"<tr>";
    print"<th>№ п.п.</th>";
    print"<th></th>";
    print"<th>Название</th>";
    print"<th>Всегда показывать</th>";
    print"<th>Сортировка</th>";
    print"</tr>";
    print"</thead>";
    $sql = "SELECT id, name, always_show, sort FROM $tables[$tbl_num] WHERE udln is null and $poisk_nazvanie $str_filtr_sortirovka";
    $res = mysqli_query($db, $sql);
    while ($line = mysqli_fetch_array($res, MYSQLI_NUM)) {
        print"<tr>";
        print"<td>$npp</td>";
        print"<td><input type='checkbox' id='ch" . $npp . "' value='" . $line[0] . "'></td>";
        print"<td class='textl'>".htmlspecialchars_decode($line[1],ENT_QUOTES)."</td>";
        print"<td class='textc'>$line[2]</td>";
        print"<td class='textc'>$line[3]</td>";
        print"</tr>";
        $npp++;
    }
    print"</table>";
}

if($tbl_num==5) {
    print"<table class='table_spravochnik'>";
    print"<thead>";
    print"<tr>";
    print"<th>№ п.п.</th>";
    print"<th></th>";
    print"<th>Тестирование начало<br>(дд.мм.гггг чч:мм)</th>";
    print"<th>Тестирование конец<br>(дд.мм.гггг чч:мм)</th>";
    print"<th>Всего минут на тестирование</th>";
    print"<th>Всего минут на собеседование</th>";
    print"</tr>";
    print"</thead>";
    $sql = "SELECT id, 
DATE_FORMAT(testirovanie_data_begin,'%d.%m.%Y %H:%i'), DATE_FORMAT(testirovanie_data_end,'%d.%m.%Y %H:%i'),
testirovanie_time_vsego_minyt, sobesedovanie_time_vsego_minyt 
FROM $tables[$tbl_num] WHERE udln is null order by testirovanie_data_begin";
    $res = mysqli_query($db, $sql);
    while ($line = mysqli_fetch_array($res, MYSQLI_NUM)) {
        print"<tr>";
        print"<td>$npp</td>";
        print"<td><input type='checkbox' id='ch" . $npp . "' value='" . $line[0] . "'></td>";
        print"<td class='textc'>$line[1]</td>";
        print"<td class='textc'>$line[2]</td>";
        print"<td class='textc'>$line[3]</td>";
        print"<td class='textc'>$line[4]</td>";
        print"</tr>";
        $npp++;
    }
    print"</table>";
}


?>