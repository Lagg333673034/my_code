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
$filtr_yroven_obrazov=check_number($_GET['filtr_yroven_obrazov']);
//-------------------------------------------------------------------------------------------------//
if($filtr_yroven_obrazov=='') $filtr_yroven_obrazov=0;
//-------------------------------------------------------------------------------------------------//
if($filtr_yroven_obrazov!=0){
    $sql_vopros = "
SELECT id, name, neskolko_variantov
FROM tvidi_vopros 
WHERE udln is null 
and id_yroven_obrazov=$filtr_yroven_obrazov 
order by sort";
    $res_vopros = mysqli_query($db, $sql_vopros);
    $npp_vopros=1;
    while ($line_vopros = mysqli_fetch_array($res_vopros, MYSQLI_NUM)) {
        //-------------------------------------------------------------------------------------------------//
        if($line_vopros[2] == 1){
            $neskolko = 'neskolko';
        }else{
            $neskolko = '';
        }
        //-------------------------------------------------------------------------------------------------//
        print"<tr>";
        print"<td hidden>$npp_vopros</td>";
        print"<td hidden><input type='text' name='vopros[]' id='vopros".$npp_vopros."' value='$line_vopros[0]'></td>";
        print"<td colspan='2' class='textl bold1 font_size20 padding_top5 padding_bottom5'>$line_vopros[1]</td>";
        print"</tr>";
        //-------------------------------------------------------------------------------------------------//
        $sql_vopros_variant = "
        SELECT id, name
        FROM tvidi_vopros_variant 
        WHERE udln is null 
        and id_vopros=$line_vopros[0] 
        order by sort";
        $res_vopros_variant = mysqli_query($db, $sql_vopros_variant);
        $npp_variant=1;
        while ($line_vopros_variant = mysqli_fetch_array($res_vopros_variant, MYSQLI_NUM)) {
            print"<tr>";
            print"<td hidden>$npp_vopros</td>";
            print"<td hidden>$npp_variant</td>";
            print"<td class='textl'><input type='checkbox' class='height20 w20px  vopros".$npp_vopros." $neskolko' name='variant".$npp_vopros."[]' id='variant".$npp_variant."' value='$line_vopros_variant[0]'></td>";
            print"<td class='textl'>$line_vopros_variant[1]</td>";
            print"</tr>";
            $npp_variant++;
        }
        //-------------------------------------------------------------------------------------------------//
        $npp_vopros++;
    }
    print"<tr>";
    print"<td colspan='2' class='textl'>";
    print"<button type='button' id='otpravit_rezyltat' onclick='table_eksperttest_end();'>Отправить результат</button>";
    print"&#160;&#160;<span id='mssg'></span>";
    print"</td>";
    print"</tr>";
}

?>