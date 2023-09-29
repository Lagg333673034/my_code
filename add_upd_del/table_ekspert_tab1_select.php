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
            print"<details class='details1 details_tab1 details_window00' $details_open $details_open_default>";
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
            print"<details class='details1 details_tab1 details_window01' $details_open $details_open_default>";
            print"<summary>Тестовые вопросы</summary>";
            if (1) {
                //-------------------------------------------------------------------------------------------------//
                $sql_ekspert_info = "SELECT id, id_yroven_obrazov FROM teksperttest WHERE udln is null and id=$id_ekspert";
                $res_ekspert_info = mysqli_query($db, $sql_ekspert_info);
                $line_ekspert_info = mysqli_fetch_array($res_ekspert_info, MYSQLI_NUM);
                $id_yroven_obrazov = $line_ekspert_info[1];
                //-------------------------------------------------------------------------------------------------//
                print"<table class='table_ekspert_tbl'>";
                $sql_vopros = "
                SELECT id, name, neskolko_variantov
                FROM tvidi_vopros 
                WHERE udln is null 
                and id_yroven_obrazov=$id_yroven_obrazov 
                order by sort";
                $res_vopros = mysqli_query($db, $sql_vopros);
                while ($line_vopros = mysqli_fetch_array($res_vopros, MYSQLI_NUM)) {
                    print"<tr>";
                    print"<td colspan='2' class='textl bold1 padding_left15 padding_top3 padding_bottom3'>$line_vopros[1]</td>";
                    print"</tr>";
                    //-------------------------------------------------------------------------------------------------//
                    //-------------------------------------------------------------------------------------------------//
                    $sql_vopros_variant_nyjno_vibrat = "
                        SELECT group_concat(id)
                        FROM tvidi_vopros_variant 
                        WHERE udln is null 
                        and id_vopros=$line_vopros[0] 
                        and prav_otvet=1 
                        order by id";
                    $res_vopros_variant_nyjno_vibrat = mysqli_query($db, $sql_vopros_variant_nyjno_vibrat);
                    $line_vopros_variant_nyjno_vibrat = mysqli_fetch_array($res_vopros_variant_nyjno_vibrat, MYSQLI_NUM);
                    $vse_varianti_v_voprose_nyjno_vibrat = $line_vopros_variant_nyjno_vibrat[0];

                    $sql_vopros_variant_vibrano = "
                        SELECT group_concat(id_vopros_variant)
                        FROM teksperttest_vopros 
                        WHERE udln is null 
                        and id_eksperttest=$id_ekspert 
                        and id_vopros=$line_vopros[0] 
                        order by id_vopros_variant";
                    $res_vopros_variant_vibrano = mysqli_query($db, $sql_vopros_variant_vibrano);
                    $line_vopros_variant_vibrano = mysqli_fetch_array($res_vopros_variant_vibrano, MYSQLI_NUM);
                    $vse_varianti_v_voprose_vibrano = $line_vopros_variant_vibrano[0];
                    //-------------------------------------------------------------------------------------------------//
                    //-------------------------------------------------------------------------------------------------//
                    $sql_vopros_variant = "
                    SELECT id, name, prav_otvet 
                    FROM tvidi_vopros_variant 
                    WHERE udln is null 
                    and id_vopros=$line_vopros[0] 
                    order by sort";
                    $res_vopros_variant = mysqli_query($db, $sql_vopros_variant);
                    while ($line_vopros_variant = mysqli_fetch_array($res_vopros_variant, MYSQLI_NUM)) {
                        //-------------------------------------------------------------------------------------------------//
                        if($line_vopros_variant[2]==1){
                            $prav_otvet = " bold1 ";
                            $nyjniy_variant = 1;
                        }else{
                            $prav_otvet = "";
                            $nyjniy_variant = 0;
                        }
                        //-------------------------------------------------------------------------------------------------//
                        $sql_vopros_variant_users = "
                        SELECT id 
                        FROM teksperttest_vopros 
                        WHERE udln is null 
                        and id_eksperttest=$id_ekspert 
                        and id_vopros=$line_vopros[0] 
                        and id_vopros_variant=$line_vopros_variant[0]";
                        $res_vopros_variant_users = mysqli_query($db, $sql_vopros_variant_users);
                        if($res_vopros_variant_users->num_rows>0){
                            $checked = " checked ";
                            $galochka_stoit = 1;
                        }else{
                            $checked = "";
                            $galochka_stoit = 0;
                        }
                        //-------------------------------------------------------------------------------------------------//
                        $rezyltat = "";
                        if($nyjniy_variant==1) {
                            if (
                                $vse_varianti_v_voprose_nyjno_vibrat != "" &&
                                $vse_varianti_v_voprose_vibrano != "" &&
                                $vse_varianti_v_voprose_nyjno_vibrat == $vse_varianti_v_voprose_vibrano &&
                                $nyjniy_variant==1 &&
                                $galochka_stoit==1
                            ) {
                                $rezyltat = " otvet_prav ";
                            } else {
                                $rezyltat = " otvet_ne_prav ";
                            }
                        }
                        //-------------------------------------------------------------------------------------------------//
                        print"<tr>";
                        print"<td class='textl'><input readonly type='checkbox' value='$line_vopros_variant[0]' $checked></td>";
                        //print"<td class='textl $prav_otvet $rezyltat'>$line_vopros_variant[1]($vse_varianti_v_voprose_nyjno_vibrat==$vse_varianti_v_voprose_vibrano)</td>";
                        print"<td class='textl $prav_otvet $rezyltat'>$line_vopros_variant[1]</td>";
                        print"</tr>";
                    }
                    print"<tr>";
                    print"<td colspan='2' class=''><br></td>";
                    print"</tr>";
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