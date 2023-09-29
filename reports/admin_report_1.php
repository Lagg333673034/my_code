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
if(1) {
    $year_c = check_mass($_GET['year_c']);
    $year_po = check_mass($_GET['year_po']);
    $month_c = check_mass($_GET['month_c']);
    $month_po = check_mass($_GET['month_po']);
    $vid_otcheta = check_number($_GET['vid_otcheta']);
    //-------------------------------------------------------------//
    for ($i = 0, $tmp_str = ''; $i < count($year_c); $i++)
        if ($year_c[$i] != '')
            $tmp_str .= $year_c[$i] . ',';
    if ($tmp_str != '')
        $str_year_c = substr($tmp_str, 0, -1);

    for ($i = 0, $tmp_str = ''; $i < count($year_po); $i++)
        if ($year_po[$i] != '')
            $tmp_str .= $year_po[$i] . ',';
    if ($tmp_str != '')
        $str_year_po = substr($tmp_str, 0, -1);
    //-------------------------------------------------------------//
    for ($i = 0, $tmp_str = ''; $i < count($month_c); $i++)
        if ($month_c[$i] != '')
            $tmp_str .= $month_c[$i] . ',';
    if ($tmp_str != '')
        $str_month_c = substr($tmp_str, 0, -1);

    for ($i = 0, $tmp_str = ''; $i < count($month_po); $i++)
        if ($month_po[$i] != '')
            $tmp_str .= $month_po[$i] . ',';
    if ($tmp_str != '')
        $str_month_po = substr($tmp_str, 0, -1);
    //-------------------------------------------------------------//
    if ($str_year_c != '' && $str_year_po != '') {
        $str_year = "
        ($str_year_c<=DATE_FORMAT(tekspert.polnomoch_prikaz_data, '%Y') and DATE_FORMAT(tekspert.polnomoch_prikaz_data, '%Y')<=$str_year_po)
        ";
    }
    if ($str_year_c != '' && $str_year_po == '') {
        $str_year = "
        ($str_year_c<=DATE_FORMAT(tekspert.polnomoch_prikaz_data, '%Y'))
        ";
    }
    if ($str_year_c == '' && $str_year_po != '') {
        $str_year = "
        (DATE_FORMAT(tekspert.polnomoch_prikaz_data, '%Y')<=$str_year_po)
        ";
    }
    if ($str_year_c == '' && $str_year_po == '') {
        $str_year = " 1 ";
    }
    //-------------------------------------------------------------//
    if ($str_month_c != '' && $str_month_po != '') {
        $str_month = "
        ($str_month_c<=DATE_FORMAT(tekspert.polnomoch_prikaz_data, '%m') and DATE_FORMAT(tekspert.polnomoch_prikaz_data, '%m')<=$str_month_po)
        ";
    }
    if ($str_month_c != '' && $str_month_po == '') {
        $str_month = "
        ($str_month_c<=DATE_FORMAT(tekspert.polnomoch_prikaz_data, '%m'))
        ";
    }
    if ($str_month_c == '' && $str_month_po != '') {
        $str_month = "
        (DATE_FORMAT(tekspert.polnomoch_prikaz_data, '%m')<=$str_month_po)
        ";
    }
    if ($str_month_c == '' && $str_month_po == '') {
        $str_month = " 1 ";
    }
}
//-------------------------------------------------------------------------------------------------//
if($vid_otcheta == 1) {
    if (count($year_c) == 0) exit('Выберите текущий год в фильтре (Год с)');
    print"<table id='tabl_report1'>";
    print"<thead>";
    print"<tr>";
    print"<th class=''></th>";
    print"<th class=''>".($year_c[0]-4)."</th>";
    print"<th class=''>".($year_c[0]-3)."</th>";
    print"<th class=''>".($year_c[0]-2)."</th>";
    print"<th class=''>".($year_c[0]-1)."</th>";
    print"<th class=''>".($year_c[0])."</th>";
    print"<th class=''>Итого</th>";
    print"<th></th>";
    print"</tr>";
    print"</thead>";
    print"<tbody>";
    //------------------------------------------------------------//
    print"<tr>";
    print"<td class='w300px textl'>Количество аттестованных</td>";
    $itogo_row1 = 0;
    for($i=4;$i>=0;$i--) {
        $sql = "SELECT count(tekspert.id) 
        FROM tekspert 
        WHERE tekspert.udln is null 
        and id_ekspert_status=2 
        and year(polnomoch_prikaz_data)=" . ($year_c[0] - $i);
        $res = mysqli_query($db, $sql);
        $line = mysqli_fetch_array($res, MYSQLI_NUM);
        $itogo_row1 += $line[0];
        print"<td class='w100px textc'>$line[0]</td>";
    }
    print"<td class='w100px textc'>$itogo_row1</td>";
    print"<td class=''></td>";
    print"</tr>";
    //------------------------------------------------------------//
    //------------------------------------------------------------//
    print"<tr>";
    print"<td class='textl'>Количество экспертов, подлежащих аттестации</td>";
    $itogo_row2 = 0;
    for($i=4;$i>=0;$i--) {
        $sql = "SELECT count(tekspert.id) 
        FROM tekspert 
        WHERE tekspert.udln is null 
        and id_ekspert_status=2 
        and year(polnomoch_prikaz_data)=" . ($year_c[0] - $i);
        $res = mysqli_query($db, $sql);
        $line = mysqli_fetch_array($res, MYSQLI_NUM);
        if($i!=0) {
            $itogo_row2 += $line[0];
            print"<td class='w100px textc'></td>";
        }else{
            print"<td class='w100px textc'>$itogo_row2</td>";
        }
    }
    print"<td class='w100px textc'>$itogo_row2</td>";
    print"<td class=''></td>";
    print"</tr>";
    //------------------------------------------------------------//
    //------------------------------------------------------------//
    print"<tr>";
    print"<td class='textl'>Количество претендентов</td>";
    $itogo_row3 = 0;
    $sql = "SELECT count(tekspert.id) 
    FROM tekspert 
    WHERE tekspert.udln is null 
    and id_ekspert_status=1";
    $res = mysqli_query($db, $sql);
    $line = mysqli_fetch_array($res, MYSQLI_NUM);
    $itogo_row3 = $line[0];
    print"<td class='w100px textc'></td>";
    print"<td class='w100px textc'></td>";
    print"<td class='w100px textc'></td>";
    print"<td class='w100px textc'></td>";
    print"<td class='w100px textc'>$line[0]</td>";
    print"<td class='w100px textc'>$itogo_row3</td>";
    print"<td class=''></td>";
    print"</tr>";
    //------------------------------------------------------------//
    //------------------------------------------------------------//
    print"<tr>";
    print"<td class='textl bg_color_gray9 bold1'>ВСЕГО</td>";
    print"<td class='w100px textc bg_color_gray9 bold1'></td>";
    print"<td class='w100px textc bg_color_gray9 bold1'></td>";
    print"<td class='w100px textc bg_color_gray9 bold1'></td>";
    print"<td class='w100px textc bg_color_gray9 bold1'></td>";
    print"<td class='w100px textc bg_color_gray9 bold1'></td>";
    print"<td class='w100px textc bg_color_gray9 bold1'>".($itogo_row1+$itogo_row2+$itogo_row3)."</td>";
    print"<td class=''></td>";
    print"</tr>";
    //------------------------------------------------------------//
    print"</tbody>";
    print"</table>";
}
//-------------------------------------------------------------------------------------------------//
/*print"<br><br>";
print"<button class='btn btn-primary btn_download' onclick='xls()'>Скачать XLS</button>";
print"<br><br>";*/

?>