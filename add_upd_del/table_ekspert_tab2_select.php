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
$details_open=check_mass($_GET['details_open']);
if(count((array)$details_open)==0){
    $details_open_default=' open';
}else{
    $details_open_default='';
}
//-------------------------------------------------------------------------------------------------//
function func_print($details_open, $case, $db, $rf, $id_ekspert, $details_open_default)
{
    switch ($case) {
        case 0: {
            print"<details class='details1 details_tab2 details_window00' $details_open $details_open_default>";
            print"<summary>Краткая информация</summary>";
            if (1) {
                $sql_ekspert_info = "SELECT teksperttest.id, 
                teksperttest.fio, 
                tvidi_yroven_obrazov.name
                FROM teksperttest 
                left join tvidi_yroven_obrazov on tvidi_yroven_obrazov.id=teksperttest.id_yroven_obrazov 
                WHERE teksperttest.udln is null and teksperttest.id=$id_ekspert";
                $res_ekspert_info = mysqli_query($db, $sql_ekspert_info);
                $line_ekspert_info = mysqli_fetch_array($res_ekspert_info, MYSQLI_NUM);
                if(1) {
                    print"<table class='table_ekspert_tbl'>";
                    print"<tr>";
                    print"<td class='w150px'><label class='label1'>ФИО эксперта</label></td>";
                    print"<td class='padding_2'>$line_ekspert_info[1]</td>";
                    print"</tr>";
                    print"<tr>";
                    print"<td class=''><label class='label1'>Уровень образования</label></td>";
                    print"<td class='padding_2'>$line_ekspert_info[2]</td>";
                    print"</tr>";
                    print"</table>";
                }
            }
            print"</details>";
        }break;

        case 1: {
            print"<details class='details1 details_tab2 details_window01' $details_open $details_open_default>";
            print"<summary>Собеседование</summary>";
            if (1) {
                print"<table class='table_ekspert_tbl'>";
                $sql_sobesedovanie_otvet = "SELECT 
        teksperttest_sobesedovanie.id, 
        tvidi_sobesedovanie.name, 
        teksperttest_sobesedovanie.sobesedovanie_otvet, 
        tvidi_sobesedovanie.always_show 
        FROM teksperttest_sobesedovanie 
        left join tvidi_sobesedovanie on tvidi_sobesedovanie.id=teksperttest_sobesedovanie.id_sobesedovanie 
        WHERE teksperttest_sobesedovanie.udln is null 
        and teksperttest_sobesedovanie.id_eksperttest=$id_ekspert 
        order by tvidi_sobesedovanie.always_show, tvidi_sobesedovanie.sort";
                $res_sobesedovanie_otvet = mysqli_query($db, $sql_sobesedovanie_otvet);
                $npp_sobesedovanie_otvet = 1;
                while ($line_sobesedovanie_otvet = mysqli_fetch_array($res_sobesedovanie_otvet, MYSQLI_NUM)) {
                    //-------------------------------------------------------------------------------------------------//
                    if($line_sobesedovanie_otvet[3]==1){
                        $vopros = "$line_sobesedovanie_otvet[1]";
                    }else{
                        $vopros = "$npp_sobesedovanie_otvet) $line_sobesedovanie_otvet[1]";
                    }
                    print"<tr>";
                    print"<td hidden><input type='text' name='sobesedovanie[]' value='$line_sobesedovanie_otvet[0]'></td>";
                    print"<td class='textl bold1 font_size20 padding_top5 padding_bottom5'>".htmlspecialchars_decode($vopros,ENT_QUOTES)."</td>";
                    print"</tr>";
                    print"<tr>";
                    print"<td colspan='2' class='textj bold1 font_size16 padding_2 margin_2'>";
                    print"<textarea disabled class='w100 height100' name='sobesedovanie_otvet[]'>$line_sobesedovanie_otvet[2]</textarea>";
                    print"</td>";
                    print"</tr>";
                    $npp_sobesedovanie_otvet++;
                    //-------------------------------------------------------------------------------------------------//
                }
                print"</table>";
            }
            print"</details>";
        }break;
    }
}
for ($case = 0; $case <= 1; $case++) {
    func_print($details_open[$case], $case, $db, $rf, $id_ekspert, $details_open_default);
}
//-------------------------------------------------------------------------------------------------//
?>