<?php
session_start();

require_once('_session_check_downtime.php');
require_once('_dbconnect.php');
require_once('_fields_name.php');

if(
    (isset($_SESSION['gryppa']) && !empty($_SESSION['gryppa'])) ||
    (isset($_SESSION['ip']) && !empty($_SESSION['ip'])) ||
    (isset($_SESSION['web']) && !empty($_SESSION['web']))
){
    if(
        (
            $_SESSION['gryppa'] != md5('admin'.$sol_user_gryppa) &&
            $_SESSION['gryppa'] != md5('ekspert'.$sol_user_gryppa)
        ) ||
        ($_SESSION['ip'] != md5($_SERVER['REMOTE_ADDR'].$sol_user_ip)) ||
        ($_SESSION['web'] != md5($_SERVER['HTTP_USER_AGENT'].$sol_user_web_agent))
    ){
        header("Location: http://" . $_SERVER['SERVER_NAME'] . "/guest/logout.php");exit();
    }
}

    function site_head()
    {
        global $fields,$reg_fields,$sol_user_gryppa;

        //otklychenie oshibok
        /*error_reporting(0);
        @ini_set('display_errors', 0);*/

        if(
            isset($_SESSION['gryppa']) && !empty($_SESSION['gryppa']) &&
            $_SESSION['gryppa'] == md5('admin' . $sol_user_gryppa)
        ) {
            print"<!DOCTYPE html>";
            print"<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
            print"<meta http-equiv='X-UA-Compatible' content='IE=edge'>";
            print"<meta name='viewport' content='width=device-width, initial-scale=1.0'>";

            print"<head>";
            print"<title>" . $fields['site_title'] . "</title>";
            print"<link rel='stylesheet' type='text/css' href='css/bootstrap.min.css'>";
            print"<link rel='stylesheet' type='text/css' href='css/users_css.css'>";
            print"<link rel='stylesheet' type='text/css' href='css/jquery.auto-complete.css'>";
            print"<link rel='stylesheet' type='text/css' href='css/jquery-ui/jquery-ui.css'>";
            print"<link rel='stylesheet' type='text/css' href='css/select2.css'>";
            print"<script type='text/javascript' src='js/jquery-3.5.1.js'></script>";
            print"<script type='text/javascript' src='js/bootstrap.min.js'></script>";
            print"<script type='text/javascript' src='js/users_js.js'></script>";
            print"<script type='text/javascript' src='js/jquery.auto-complete.js'></script>";
            print"<script type='text/javascript' src='js/jquery.maskedinput.js'></script>";
            print"<script type='text/javascript' src='js/jquery-ui.js'></script>";
            print"<script type='text/javascript' src='js/select2.js'></script>";
            print"</head>";
            print"<body>";

            print"<nav class='navbar navbar-default'>";
            print"<div class='container-fluid'>";

            print"<ul class='nav navbar-nav'>";
            print"<li><a id='page_ekspert' href='ekspert.php'>Эксперты</a></li>";
            print"<li><a id='page_reports' href='reports.php'>Отчёты</a></li>";

            print"<li class='dropdown'>";
            print"<a id='page_admin_settings' href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'>Настройки <span class='caret'></span></a>";
            print"<ul class='dropdown-menu'>";
            print"<li><a id='page_admin_spravochniki' href='admin_spravochniki.php'>Справочники</a></li>";
            print"<li><a id='page_admin_manage_users' href='admin_manage_users.php'>Управление пользователями</a></li>";
            print"</ul>";
            print"</li>";

            print"</ul>";

            print"<ul class='nav navbar-nav navbar-right'>";
            print"<li><a id='user_icon_msg' onclick='document.location.reload()'></a></li>";

            print"<li class='dropdown'>";
            print"<a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'>";
            print"<i id='user_icon' class='glyphicon glyphicon-user user_name padding_right5'></i>";
            print"<span class='user_name'>" . $_SESSION['user'] . "</span>";
            print"<span class='caret'></span></a>";
            print"<ul class='dropdown-menu'>";
            print"<li><a href='/guest/logout.php'>" . $reg_fields['vihod'] . "</a></li>";
            print"</ul>";
            print"</li>";

            print"</ul>";

            print"</div>";
            print"</nav>";
        }
        if(
            (!isset($_SESSION['gryppa']) || empty($_SESSION['gryppa'])) ||
            ($_SESSION['gryppa'] == md5('ekspert' . $sol_user_gryppa))
        ) {
            print"<!DOCTYPE html>";
            print"<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
            print"<meta http-equiv='X-UA-Compatible' content='IE=edge'>";
            print"<meta name='viewport' content='width=device-width, initial-scale=1.0'>";

            print"<head>";
            print"<title>".$fields['site_title']."</title>";
            print"<link rel='stylesheet' type='text/css' href='../css/bootstrap.min.css'>";
            print"<link rel='stylesheet' type='text/css' href='../css/users_css.css'>";
            print"<link rel='stylesheet' type='text/css' href='../css/jquery.auto-complete.css'>";
            print"<link rel='stylesheet' type='text/css' href='../css/jquery-ui/jquery-ui.css'>";
            print"<link rel='stylesheet' type='text/css' href='../css/select2.css'>";
            print"<script type='text/javascript' src='../js/jquery-3.5.1.js'></script>";
            print"<script type='text/javascript' src='../js/bootstrap.min.js'></script>";
            print"<script type='text/javascript' src='../js/users_js.js'></script>";
            print"<script type='text/javascript' src='../js/jquery.auto-complete.js'></script>";
            print"<script type='text/javascript' src='../js/jquery.maskedinput.js'></script>";
            print"<script type='text/javascript' src='../js/jquery-ui.js'></script>";
            print"<script type='text/javascript' src='../js/select2.js'></script>";
            print"</head>";
            print"<body>";

            print"<nav class='navbar navbar-default navbar_user'>";
            print"<div class='container-fluid'>";

            print"<ul class='nav navbar-nav navbar-left navbar_user'>";
            print"<li><a id='page_domain' class='navbar-brand' href='http://resobrnadzor.ru'>Ресобрнадзор</a></li>";
            print"</ul>";

            print"<ul class='nav navbar-nav navbar-right navbar_user'>";
            print"<li><a id='page_eksperttest' href='http://".$_SERVER['SERVER_NAME']."/guest/form_eksperttest.php'>Тестирование эксперта</a></li>";
            if(!isset($_SESSION['gryppa']) || empty($_SESSION['gryppa'])) {
                print"<li><a id='page_registration' href='https://" . $_SERVER['SERVER_NAME'] . "/guest/form_registration.php'>Регистрация</a></li>";
                print"<li><a id='page_authorization' href='https://" . $_SERVER['SERVER_NAME'] . "/guest/form_authorization.php'>Авторизация</a></li>";
            }
            if($_SESSION['gryppa'] == md5('ekspert' . $sol_user_gryppa)) {
                print"<li><a id='page_logout' href='/guest/logout.php'>" . $reg_fields['vihod'] . "</a></li>";
            }
            print"</ul>";

            print"</div>";
            print"</nav>";

        }
    }
    function site_foot(){
        print"</body>";
        print"</html>";
    }

    function check_number($tmp_value){
        return htmlspecialchars(str_replace(array("\r", "\n", "\\"), "", preg_replace("/\s+/","",trim($tmp_value))),ENT_QUOTES);
    }
    function check_string($tmp_value){
        return htmlspecialchars(str_replace(array("\r", "\n", "\\"), "", preg_replace("/\s+/"," ",trim($tmp_value))),ENT_QUOTES);
    }
    function check_primechanie($tmp_value){
        return htmlspecialchars($tmp_value, ENT_QUOTES);
    }
    function check_mass($mass){
        for($i=0;$i<count((array)$mass);$i++){
            if($mass[$i]!='' && $mass[$i]!=null)
                $mass[$i] = check_string($mass[$i]);
        }
        return $mass;
    }
    function check_mass_primechanie($mass){
        for ($i = 0; $i < count((array)$mass); $i++) {
            if ($mass[$i] != '' && $mass[$i] != null)
                $mass[$i] = check_primechanie($mass[$i]);
        }
        return $mass;
    }
    function check_matr($matr){
        for ($i = 0; $i < count((array)$matr); $i++) {
            for ($j = 0; $j < count((array)$matr[$i]); $j++) {
                if ($matr[$j] != '' && $matr[$j] != null)
                    $matr[$j] = check_mass($matr[$j]);
            }
        }
        return $matr;
    }
    function my_substr1($str,$num){
        if(strlen($str)>$num) {
            return mb_substr($str, 0, $num,'UTF-8') . '...';
        }else{
            return $str;
        }
    }
    function my_substr0($str,$num){
        if(strlen($str)>$num) {
            return mb_substr($str, 0, $num,'UTF-8');
        }else{
            return $str;
        }
    }

    function check_abr($str)
    {
        $mass1[] = 'Высшее профессиональное образование';
        $mass2[] = 'ВПО';
        $mass1[] = 'Среднее профессиональное образование';
        $mass2[] = 'СПО';
        $mass1[] = 'Общее образование';
        $mass2[] = 'ОО';
        for ($i = 0; $i < count($mass1); $i++) {
            $str = str_ireplace($mass1[$i], $mass2[$i], $str);
        }
        return $str;
    }

    function chk_test_procent_prav_otvetov($id_ekspert){
        global $db;
        $vsego_pravilnih_otvetov = 0;
        $vsego_voprosov = 0;
        //-------------------------------------------------------------------------------------------------//
        if($id_ekspert=='') {
            exit("ID эксперта не обнаружен");
        }
        //-------------------------------------------------------------------------------------------------//
        $sql_ekspert_info = "SELECT id, id_yroven_obrazov FROM teksperttest WHERE udln is null and id=$id_ekspert";
        $res_ekspert_info = mysqli_query($db, $sql_ekspert_info);
        $line_ekspert_info = mysqli_fetch_array($res_ekspert_info, MYSQLI_NUM);
        $id_yroven_obrazov = $line_ekspert_info[1];
        //-------------------------------------------------------------------------------------------------//
        $sql_vopros = "SELECT id FROM tvidi_vopros WHERE udln is null and id_yroven_obrazov=$id_yroven_obrazov order by sort";
        $res_vopros = mysqli_query($db, $sql_vopros);
        while ($line_vopros = mysqli_fetch_array($res_vopros, MYSQLI_NUM)) {
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
                        SELECT id, prav_otvet 
                        FROM tvidi_vopros_variant 
                        WHERE udln is null 
                        and id_vopros=$line_vopros[0]";
            $res_vopros_variant = mysqli_query($db, $sql_vopros_variant);

            unset($nyjniy_variant);
            $nyjniy_variant[] = '';

            unset($galochka_stoit);
            $galochka_stoit[] = '';

            $kolvo_variantov = 0;
            while ($line_vopros_variant = mysqli_fetch_array($res_vopros_variant, MYSQLI_NUM)) {
                //-------------------------------------------------------------------------------------------------//
                if ($line_vopros_variant[1] == 1) {
                    $nyjniy_variant[$kolvo_variantov] = 1;
                } else {
                    $nyjniy_variant[$kolvo_variantov] = 0;
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
                if ($res_vopros_variant_users->num_rows > 0) {
                    $galochka_stoit[$kolvo_variantov] = 1;
                } else {
                    $galochka_stoit[$kolvo_variantov] = 0;
                }
                //-------------------------------------------------------------------------------------------------//
                $kolvo_variantov += 1;
            }
            //-------------------------------------------------------------------------------------------------//
            //-------------------------------------------------------------------------------------------------//
            //-------------------------------------------------------------------------------------------------//
            $pravilno = 1;
            for ($i = 0; $i < $kolvo_variantov; $i++) {
                if($nyjniy_variant[$i] == 1) {
                    if (
                        $vse_varianti_v_voprose_nyjno_vibrat != "" && $vse_varianti_v_voprose_vibrano != "" &&
                        $vse_varianti_v_voprose_nyjno_vibrat == $vse_varianti_v_voprose_vibrano &&
                        $nyjniy_variant[$i] == 1 && $galochka_stoit[$i] == 1
                    ) {
                        //pravilno
                    } else {
                        $pravilno = 0;
                    }
                }
            }
            if ($pravilno == 1) {
                $vsego_pravilnih_otvetov += 1;
            } else {
                $vsego_pravilnih_otvetov += 0;
            }
            //-------------------------------------------------------------------------------------------------//
            //-------------------------------------------------------------------------------------------------//
            //-------------------------------------------------------------------------------------------------//
            $vsego_voprosov += 1;
        }
        if($vsego_pravilnih_otvetov>0){
            return round(($vsego_pravilnih_otvetov*100)/$vsego_voprosov);
            //return "vsego_pravilnih_otvetov($vsego_pravilnih_otvetov)*100/vsego_voprosov($vsego_voprosov)=".round(($vsego_pravilnih_otvetov*100)/$vsego_voprosov);
        }else{
            return 0;
        }
    }

    function delete_all_between($begin, $end, $string) {
        $beginPos = strpos($string, $begin);
        $endPos = strpos($string, $end);
        if ($beginPos === false || $endPos === false) {
            return $string;
        }
        $textToDelete = substr($string, $beginPos, ($endPos + strlen($end)) - $beginPos);
        return delete_all_between($begin, $end, str_replace($textToDelete, '', $string));
    }

    function check_testirovanie_time() {
        global $db, $sol_user_id, $min_procent_prav_otvetov;
        //------------------------------------------------------------------------------------------------//
        $current_date = date('Y-m-d H:i:s');
        $end[] = ["",""];
        //------------------------------------------------------------------------------------------------//
        $sql_raspisanie = "select id, 
        testirovanie_data_begin, 
        testirovanie_data_end,
        testirovanie_time_vsego_minyt, 
        sobesedovanie_time_vsego_minyt 
        from tvidi_raspisanie 
        WHERE udln is null 
        and testirovanie_data_begin <= '$current_date' 
        and testirovanie_data_end >= '$current_date'";
        $res_raspisanie = mysqli_query($db, $sql_raspisanie);
        if($res_raspisanie->num_rows == 1) {
            $line_raspisanie = mysqli_fetch_array($res_raspisanie, MYSQLI_NUM);
            //------------------------------------------------------------------------------------------------//
            $testirovanie_data_begin = $line_raspisanie[1];
            $testirovanie_data_end = $line_raspisanie[2];
            $testirovanie_time_vsego_minyt = $line_raspisanie[3];
            $sobesedovanie_time_vsego_minyt = $line_raspisanie[4];
            //------------------------------------------------------------------------------------------------//
            //10-testirovanie zaversheno
            //11-testirovanie idet
            //12-seichas testirovanie ne provoditsa
            //13-testirovanie zaversheno, t.k. vrema isteklo

            //20-sobesedovanie zaversheno
            //21-sobesedovanie idet
            //23-sobesedovanie zaversheno, t.k. vrema isteklo

            $end[0] = 11;
            //------------------------------------------------------------------------------------------------//
            $sql = "select id from tusers WHERE udln is null and md5(concat(id,'$sol_user_id')) = '".$_SESSION['user_id']."'";
            $res = mysqli_query($db, $sql);
            $line = mysqli_fetch_array($res, MYSQLI_NUM);
            $user_id = $line[0];

            $sql_eksperttest = "select id, test_time_start, test_time_end, sobesedovanie_time_start, sobesedovanie_time_end from teksperttest WHERE udln is null and id_user=$user_id";
            $res_eksperttest = mysqli_query($db, $sql_eksperttest);
            $line_eksperttest = mysqli_fetch_array($res_eksperttest, MYSQLI_NUM);

            $eksperttest_id = $line_eksperttest[0];
            $test_time_start = $line_eksperttest[1];
            $test_time_end = $line_eksperttest[2];
            $sobesedovanie_time_start = $line_eksperttest[3];
            $sobesedovanie_time_end = $line_eksperttest[4];
            //------------------------------------------------------------------------------------------------//
            //------------------------------------------------------------------------------------------------//
            //------------------------------------------------------------------------------------------------//
            if ($test_time_start == '' && $test_time_end == '') {
                if ($current_date < $testirovanie_data_begin || $current_date > $testirovanie_data_end) {
                    $end[0] = 2;//nelza nachinat testirovanie
                }
            }
            if ($test_time_start != '' && $test_time_end == '') {
                if ($current_date > $testirovanie_data_end) {
                    //------------------------------------------------------------------------------------------------//
                    $sql = "UPDATE teksperttest SET u_upd='" . $_SESSION['user'] . "', d_upd=now(), test_time_end=now() WHERE udln is null and id_user=$user_id";
                    mysqli_query($db, $sql);
                    //------------------------------------------------------------------------------------------------//
                    $end[0] = 10;//vrema isteklo
                }
                if ($testirovanie_time_vsego_minyt != '') {
                    $maks_data_okonchaniya_testirovaniya = date("Y-m-d H:i:s", strtotime("+{$testirovanie_time_vsego_minyt} minutes", strtotime($test_time_start)));
                    if ($current_date > $maks_data_okonchaniya_testirovaniya) {
                        //------------------------------------------------------------------------------------------------//
                        $sql = "UPDATE teksperttest SET u_upd='" . $_SESSION['user'] . "', d_upd=now(), test_time_end=now() WHERE udln is null and id_user=$user_id";
                        mysqli_query($db, $sql);
                        //------------------------------------------------------------------------------------------------//
                        $end[0] = 10;//testirovanie zaversheno
                    }
                }
            }
            if ($test_time_start != '' && $test_time_end != '') {
                $procent_prav_otvetov=chk_test_procent_prav_otvetov($eksperttest_id);
                if($procent_prav_otvetov >= $min_procent_prav_otvetov){
                    //------------------------------------------------------------------------------------------------//
                    //------------------------------------------------------------------------------------------------//
                    //------------------------------------------------------------------------------------------------//
                    if ($sobesedovanie_time_start == '' && $sobesedovanie_time_end == '') {
                        if ($current_date < $testirovanie_data_begin || $current_date > $testirovanie_data_end) {
                            $end[0] = 22;//nelza nachinat sobesedovanie
                        }
                    }
                    if ($sobesedovanie_time_start != '' && $sobesedovanie_time_end == '') {
                        if ($current_date > $testirovanie_data_end) {
                            //------------------------------------------------------------------------------------------------//
                            $sql = "UPDATE teksperttest SET u_upd='" . $_SESSION['user'] . "', d_upd=now(), sobesedovanie_time_end=now() WHERE udln is null and id_user=$user_id";
                            mysqli_query($db, $sql);
                            //------------------------------------------------------------------------------------------------//
                            $end[0] = 20;//vrema sobesedovaniya isteklo
                        }
                        if ($sobesedovanie_time_vsego_minyt != '') {
                            $maks_data_okonchaniya_sobesedovaniya = date("Y-m-d H:i:s", strtotime("+{$sobesedovanie_time_vsego_minyt} minutes", strtotime($sobesedovanie_time_start)));
                            if ($current_date > $maks_data_okonchaniya_sobesedovaniya) {
                                //------------------------------------------------------------------------------------------------//
                                $sql = "UPDATE teksperttest SET u_upd='" . $_SESSION['user'] . "', d_upd=now(), sobesedovanie_time_end=now() WHERE udln is null and id_user=$user_id";
                                mysqli_query($db, $sql);
                                //------------------------------------------------------------------------------------------------//
                                $end[0] = 20;//sobesedovanie zaversheno
                            }
                        }
                    }
                    if ($sobesedovanie_time_start != '' && $sobesedovanie_time_end != '') {
                        $end[0] = 23;//zaversheno i testirovanie i sobesedovanie
                    }
                    //------------------------------------------------------------------------------------------------//
                    //------------------------------------------------------------------------------------------------//
                    //------------------------------------------------------------------------------------------------//
                }else{
                    $end[0] = 13;//testirovanie zaversheno, t.k. vrema isteklo i test ne proiden
                }
            }
            //------------------------------------------------------------------------------------------------//
            //------------------------------------------------------------------------------------------------//
            //------------------------------------------------------------------------------------------------//
        }else{
            $end[0] = 12;//seichas testirovanie ne provoditsa
        }
        return $end;
    }

    $min_procent_prav_otvetov = 70;//nyjno 70

    $tables = array(
        /*00*/"",
        /*01*/"tvidi_vopros",
        /*02*/"tvidi_vopros_variant",
        /*03*/"tvidi_yroven_obrazov",
        /*04*/"tvidi_sobesedovanie",
        /*05*/"tvidi_raspisanie"
    );
    $rf=" (--> код РФ <--)";



?>