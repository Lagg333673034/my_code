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
$sql_user_id="SELECT id FROM tusers WHERE udln is null and md5(concat(id,'".$sol_user_id."')) = '".$_SESSION['user_id']."'";
$res_user_id = mysqli_query($db,$sql_user_id);
$line_user_id=mysqli_fetch_array($res_user_id,MYSQLI_NUM);
$user_id=$line_user_id[0];

$sql_eksperttest_id="SELECT id FROM teksperttest WHERE udln is null and id_user=$user_id";
$res_eksperttest_id = mysqli_query($db,$sql_eksperttest_id);
$line_eksperttest_id=mysqli_fetch_array($res_eksperttest_id,MYSQLI_NUM);
$eksperttest_id=$line_eksperttest_id[0];
//-------------------------------------------------------------------------------------------------//
if($user_id=='') $user_id=0;
if($eksperttest_id=='') $eksperttest_id=0;
//-------------------------------------------------------------------------------------------------//
if($eksperttest_id!=0) {
    //-------------------------------------------------------------------------------------------------//
    //sozdani li slychainie voprosi po sobesedovaniy
    $sql_check = "SELECT id FROM teksperttest_sobesedovanie WHERE udln is null and id_eksperttest=$eksperttest_id";
    $res_check = mysqli_query($db, $sql_check);
    if ($res_check->num_rows == 0) {
        //sozdaem voprosi
        $vsego_voprosov = 0;
        $vsego_voprosov_nyjno = 2;
        $varianti_voprosov = array();
        $varianti_voprosov_vibrano = array();

        $sql = "SELECT id FROM tvidi_sobesedovanie WHERE udln is null and always_show is null";
        $res = mysqli_query($db, $sql);
        if ($res->num_rows == 0) {
            exit('Не найден список вопросов.');
        }
        if ($res->num_rows < $vsego_voprosov_nyjno) {
            exit("Общее количество вопросов($res->num_rows) меньше чем нужно($vsego_voprosov_nyjno).");
        }
        while ($line = mysqli_fetch_array($res, MYSQLI_NUM)) {
            $varianti_voprosov[] = $line[0];
        }

        //vibiraem slychainie varianti
        for ($i = 0; $i < $vsego_voprosov_nyjno; $i++) {
            $flag = 0;
            while ($flag == 0) {
                $tmp_index = array_rand($varianti_voprosov);
                $tmp_value = $varianti_voprosov[$tmp_index];
                if (!in_array($tmp_value, $varianti_voprosov_vibrano)) {
                    $varianti_voprosov_vibrano[] = $tmp_value;
                    $flag = 1;
                }
            }
        }

        //dobavlaem obyazatelnie voprosi
        $sql = "SELECT id FROM tvidi_sobesedovanie WHERE udln is null and always_show=1";
        $res = mysqli_query($db, $sql);
        if($res->num_rows > 0){
            while($line = mysqli_fetch_array($res, MYSQLI_NUM)){
                $varianti_voprosov_vibrano[] = $line[0];
            }
        }

        for ($i = 0; $i < count((array)$varianti_voprosov_vibrano); $i++) {
            $sql = "INSERT INTO teksperttest_sobesedovanie(
            u_cr, d_cr, u_upd, d_upd,
            id_eksperttest, id_sobesedovanie
            ) VALUES (
            '" . $_SESSION['user'] . "', now(), '" . $_SESSION['user'] . "', now(),
            $eksperttest_id, $varianti_voprosov_vibrano[$i]
            )";
            if (mysqli_query($db, $sql) != true) exit('Неизвестная ошибка при сохранении данных (teksperttest_sobesedovanie)(добавление).');
        }
    }
    //-------------------------------------------------------------------------------------------------//
    //-------------------------------------------------------------------------------------------------//
    //esli rezyltat yje podtverdil, to blokiryem izmeneniya
    $sql_check = "SELECT id FROM teksperttest WHERE udln is null and id=$eksperttest_id and test_result_confirm is null";
    $res_check = mysqli_query($db, $sql_check);
    if($res_check->num_rows > 0) {
        $test_result_confirm_disabled = '';
    }else{
        $test_result_confirm_disabled = 'disabled';
    }
    //-------------------------------------------------------------------------------------------------//
    if (1) {
        $sql_sobesedovanie_otvet = "SELECT 
        teksperttest_sobesedovanie.id, 
        tvidi_sobesedovanie.name, 
        teksperttest_sobesedovanie.sobesedovanie_otvet, 
        tvidi_sobesedovanie.always_show 
        FROM teksperttest_sobesedovanie 
        left join tvidi_sobesedovanie on tvidi_sobesedovanie.id=teksperttest_sobesedovanie.id_sobesedovanie 
        WHERE teksperttest_sobesedovanie.udln is null 
        and teksperttest_sobesedovanie.id_eksperttest=$eksperttest_id 
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
            print"<td hidden><input $test_result_confirm_disabled type='text' name='sobesedovanie[]' value='$line_sobesedovanie_otvet[0]'></td>";
            print"<td class='textj bold1 font_size20 padding_top5 padding_bottom5'>".htmlspecialchars_decode($vopros,ENT_QUOTES)."</td>";
            print"</tr>";
            print"<tr>";
            print"<td colspan='2' class='textj bold1 font_size16 padding_2 margin_2'>";
            print"<textarea $test_result_confirm_disabled class='w100 height80' name='sobesedovanie_otvet[]'>$line_sobesedovanie_otvet[2]</textarea>";
            print"</td>";
            print"</tr>";
            $npp_sobesedovanie_otvet++;
            //-------------------------------------------------------------------------------------------------//
        }
        //-------------------------------------------------------------------------------------------------//
        if($test_result_confirm_disabled == '') {
            print"<tr>";
            print"<td colspan='2' class='textl'>";
            print"<button type='button' id='btn_sobesedovanie_otvet_save' class='w200px' onclick='table_sobesedovanie_save();'>Сохранить результат</button>";
            print"&#160;&#160;<span id='mssg'></span>";
            print"</td>";
            print"</tr>";
        }
        //-------------------------------------------------------------------------------------------------//
    }
}

?>