<?phprequire_once("../_functions.php");require_once("../_check_for_admin.php");require_once("../_mark_activity.php");// Если запрос идёт не из Ajaxif( $_SERVER['HTTP_X_REQUESTED_WITH'] != "XMLHttpRequest" ){    exit("Access denied!");}//-------------------------------------------------------------------------------------------------//$last_selected_id = check_string($_GET['last_selected_id']);$sortirovka = check_string($_GET['sortirovka']);$filtr_fio = check_string($_GET['filtr_fio']);$filtr_id_yroven_obrazov = check_string($_GET['filtr_id_yroven_obrazov']);//-------------------------------------------------------------------------------------------------//$page = check_string($_GET['page']);$max_values_in_table = check_string($_GET['max_values_in_table']);if($page=='') $page=1;if($max_values_in_table=='') $max_values_in_table=10;//-------------------------------------------------------------------------------------------------//if ($last_selected_id == '') $last_selected_id = '0';if($sortirovka!=0){    if($sortirovka==1){        $str_sortirovka = " order by teksperttest.fio ";    }}else{    $str_sortirovka = " order by teksperttest.d_cr desc ";}if ($filtr_fio != ''){    $str_filtr_fio = " (teksperttest.fio like'%$filtr_fio%') ";}else{    $str_filtr_fio = " 1 ";}if ($filtr_id_yroven_obrazov != ''){    $str_filtr_id_yroven_obrazov = " teksperttest.id_yroven_obrazov=$filtr_id_yroven_obrazov ";}else{    $str_filtr_id_yroven_obrazov = " 1 ";}//-------------------------------------------------------------------------------------------------//if(1) {    $sql = "SELECT DISTINCT teksperttest.id, teksperttest.fio,tvidi_yroven_obrazov.name,if(teksperttest.test_result_confirm=1,'Да',''), teksperttest.d_cr FROM teksperttest left join tvidi_yroven_obrazov on tvidi_yroven_obrazov.id=teksperttest.id_yroven_obrazov WHERE teksperttest.udln is null and $str_filtr_fio and $str_filtr_id_yroven_obrazov $str_sortirovka";    $res = mysqli_query($db, $sql);    $npp = 1;    //------------------------------------------------------------//    $max_row = $res->num_rows;    $max_page = intval($max_row / $max_values_in_table);    if ($max_row % $max_values_in_table != 0) $max_page += 1;    $current_value = 1;    //------------------------------------------------------------//    while ($line = mysqli_fetch_array($res, MYSQLI_NUM)) {        if ((($page * $max_values_in_table - ($max_values_in_table - 1)) <= $current_value) && (($page * $max_values_in_table) >= $current_value)) {            if ($line[0] != '') {                //------------------------------------------------------------//                if ($line[0] == $last_selected_id) {                    $checked = 'checked';                } else {                    $checked = '';                }                //------------------------------------------------------------//                print"<tr>";                print"<td class='w25px'>$npp</td>";                print"<td class='w20px'><input type='checkbox' id='ch" . $npp . "' value='" . $line[0] . "' $checked></td>";                print"<td class='w250px textl'>$line[1]</td>";                print"<td class='w200px textl'>$line[2]</td>";                print"<td class='w100px textc'>".chk_test_procent_prav_otvetov($line[0])."%</td>";                print"<td class='w100px textc'>$line[3]</td>";                print"<td class='w100px textc'><a onclick='individyalnii_list_doc($line[0])'>скачать</a></td>";                print"<td class=''></td>";                print"</tr>";            }        }        $npp++;        $current_value += 1;    }}?>