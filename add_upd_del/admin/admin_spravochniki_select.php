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
$filtr_yroven_obrazov=check_string($_GET['filtr_yroven_obrazov']);
//-------------------------------------------------------------------------------------------------//
if($filtr_yroven_obrazov!=''){
    $str_filtr_yroven_obrazov = " tvidi_yroven_obrazov.id=$filtr_yroven_obrazov ";
}else{
    $str_filtr_yroven_obrazov = " 1 ";
}
//-------------------------------------------------------------------------------------------------//
if($tbl_num==3) {
    $sql = "SELECT name, sort FROM $tables[$tbl_num] WHERE udln is null and id=$id";
    $res = mysqli_query($db, $sql);
    $line = mysqli_fetch_array($res, MYSQLI_NUM);

    print"<table class='table_spravochnik_select'>";
    print"<tr>";
    print"<td class='textl bold1'>Название</td>";
    print"</tr>";
    print"<tr>";
    print"<td><textarea class='w100' rows='5' id='nazvanie'>$line[0]</textarea></td>";
    print"</tr>";
    print"<tr>";
    print"<td><br></td>";
    print"</tr>";
    print"<tr>";
    print"<td class='textl bold1'>Сортировка</td>";
    print"</tr>";
    print"<tr>";
    print"<td><input type='text' class='w100' id='sortirovka' value='$line[1]'></td>";
    print"</tr>";
    print"</table>";
}

if($tbl_num==1) {
    $sql = "SELECT id_yroven_obrazov, name, sort FROM $tables[$tbl_num] WHERE udln is null and id=$id";
    $res = mysqli_query($db, $sql);
    $line = mysqli_fetch_array($res, MYSQLI_NUM);

    print"<table class='table_spravochnik_select'>";
    print"<tr>";
    print"<td class='textl bold1'>Уровень образования</td>";
    print"</tr>";
    print"<tr>";
    print"<td class='textl' colspan='4'><select id='id_yroven_obrazov' class='w100'><option></option>";
    $sql_yroven_obrazov = "SELECT id, name FROM tvidi_yroven_obrazov where udln is null order by sort";
    $res_yroven_obrazov = mysqli_query($db, $sql_yroven_obrazov);
    while ($line_yroven_obrazov = mysqli_fetch_array($res_yroven_obrazov, MYSQLI_NUM)) {
        $selected = '';
        if ($line[0] == $line_yroven_obrazov[0]) $selected = "selected";
        print"<option value='$line_yroven_obrazov[0]' $selected>$line_yroven_obrazov[1]</option>";
    }
    print"</select></td>";
    print"</tr>";

    print"<tr>";
    print"<td class='textl bold1'>Вопрос</td>";
    print"</tr>";
    print"<tr>";
    print"<td><textarea class='w100' rows='5' id='nazvanie'>$line[1]</textarea></td>";
    print"</tr>";
    print"<tr>";
    print"<td><br></td>";
    print"</tr>";

    print"<tr>";
    print"<td class='textl bold1'>Сортировка</td>";
    print"</tr>";
    print"<tr>";
    print"<td><input type='text' class='w100' id='sortirovka' value='$line[2]' autocomplete='off'></td>";
    print"</tr>";
    print"<tr>";
    print"<td><br></td>";
    print"</tr>";

    print"</table>";
}

if($tbl_num==2) {
    $sql = "SELECT id_vopros, name, prav_otvet, sort FROM $tables[$tbl_num] WHERE udln is null and id=$id";
    $res = mysqli_query($db, $sql);
    $line = mysqli_fetch_array($res, MYSQLI_NUM);

    print"<table class='table_spravochnik_select'>";
    print"<tr>";
    print"<td class='textl bold1'>Вопрос</td>";
    print"</tr>";
    print"<tr>";
    print"<td class='textl' colspan='4'><select id='id_vopros' class='w100'><option></option>";
    $sql_vopros = "
SELECT tvidi_vopros.id, concat(tvidi_yroven_obrazov.name, ' -- ', tvidi_vopros.name) 
FROM tvidi_vopros 
left join tvidi_yroven_obrazov on tvidi_yroven_obrazov.id=tvidi_vopros.id_yroven_obrazov 
where tvidi_vopros.udln is null 
and $str_filtr_yroven_obrazov 
order by tvidi_yroven_obrazov.sort, tvidi_vopros.sort";
    $res_vopros = mysqli_query($db, $sql_vopros);
    while ($line_vopros = mysqli_fetch_array($res_vopros, MYSQLI_NUM)) {
        $selected = '';
        if ($line[0] == $line_vopros[0]) $selected = "selected";
        print"<option value='$line_vopros[0]' $selected>$line_vopros[1]</option>";
    }
    print"</select></td>";
    print"</tr>";

    print"<tr>";
    print"<td class='textl bold1'>Вариант ответа</td>";
    print"</tr>";
    print"<tr>";
    print"<td><textarea class='w100' rows='5' id='nazvanie'>$line[1]</textarea></td>";
    print"</tr>";
    print"<tr>";
    print"<td><br></td>";
    print"</tr>";

    print"<tr>";
    print"<td class='textl bold1'>Правильный ответ</td>";
    print"</tr>";
    print"<tr>";
    print"<td><input type='text' class='w100' id='prav_otvet' value='$line[2]' autocomplete='off'></td>";
    print"</tr>";
    print"<tr>";
    print"<td><br></td>";
    print"</tr>";


    print"<tr>";
    print"<td class='textl bold1'>Сортировка</td>";
    print"</tr>";
    print"<tr>";
    print"<td><input type='text' class='w100' id='sortirovka' value='$line[3]' autocomplete='off'></td>";
    print"</tr>";
    print"<tr>";
    print"<td><br></td>";
    print"</tr>";

    print"</table>";
}

if($tbl_num==4) {
    $sql = "SELECT name, always_show, sort FROM $tables[$tbl_num] WHERE udln is null and id=$id";
    $res = mysqli_query($db, $sql);
    $line = mysqli_fetch_array($res, MYSQLI_NUM);

    print"<table class='table_spravochnik_select'>";
    print"<tr>";
    print"<td class='textl bold1'>Название</td>";
    print"</tr>";
    print"<tr>";
    print"<td><textarea class='w100' rows='5' id='nazvanie'>$line[0]</textarea></td>";
    print"</tr>";
    print"<tr>";
    print"<td><br></td>";
    print"</tr>";

    print"<tr>";
    print"<td class='textl bold1'>Показывать всегда</td>";
    print"</tr>";
    print"<tr>";
    print"<td><input type='text' class='w100' id='always_show' value='$line[1]'></td>";
    print"</tr>";

    print"<tr>";
    print"<td><br></td>";
    print"</tr>";

    print"<tr>";
    print"<td class='textl bold1'>Сортировка</td>";
    print"</tr>";
    print"<tr>";
    print"<td><input type='text' class='w100' id='sortirovka' value='$line[2]'></td>";
    print"</tr>";
    print"</table>";
}

if($tbl_num==5) {
    $sql = "SELECT 
DATE_FORMAT(testirovanie_data_begin,'%d.%m.%Y %H:%i'), DATE_FORMAT(testirovanie_data_end,'%d.%m.%Y %H:%i'), 
testirovanie_time_vsego_minyt, sobesedovanie_time_vsego_minyt 
FROM $tables[$tbl_num] WHERE udln is null and id=$id";
    $res = mysqli_query($db, $sql);
    $line = mysqli_fetch_array($res, MYSQLI_NUM);

    print"<table class='table_spravochnik_select'>";

    print"<tr>";
    print"<td class='textl bold1'>Тестирование начало (дд.мм.гггг чч:мм)</td>";
    print"</tr>";
    print"<tr>";
    print"<td><input type='text' class='w100' id='testirovanie_data_begin' value='$line[0]'></td>";
    print"</tr>";
    print"<tr>";
    print"<td><br></td>";
    print"</tr>";

    print"<tr>";
    print"<td class='textl bold1'>Тестирование конец (дд.мм.гггг чч:мм)</td>";
    print"</tr>";
    print"<tr>";
    print"<td><input type='text' class='w100' id='testirovanie_data_end' value='$line[1]'></td>";
    print"</tr>";
    print"<tr>";
    print"<td><br></td>";
    print"</tr>";

    print"<tr>";
    print"<td class='textl bold1'>Всего минут на тестирование</td>";
    print"</tr>";
    print"<tr>";
    print"<td><input type='text' class='w100' id='testirovanie_time_vsego_minyt' value='$line[2]'></td>";
    print"</tr>";
    print"<tr>";
    print"<td><br></td>";
    print"</tr>";

    print"<tr>";
    print"<td class='textl bold1'>Всего минут на собеседование</td>";
    print"</tr>";
    print"<tr>";
    print"<td><input type='text' class='w100' id='sobesedovanie_time_vsego_minyt' value='$line[3]'></td>";
    print"</tr>";
    print"<tr>";
    print"<td><br></td>";
    print"</tr>";

    print"</table>";
}

?>