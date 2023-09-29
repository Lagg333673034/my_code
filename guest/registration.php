<?php
session_start();
require_once('../_dbconnect.php');
require_once('../_fields_name.php');
require_once('../_sol.php');

// Если запрос идёт не из Ajax
if( $_SERVER['HTTP_X_REQUESTED_WITH'] != "XMLHttpRequest" )
{
    exit("Access denied!");
}

if(isset($_POST["btn_submit_registr"]) && !empty($_POST["btn_submit_registr"])){
    //----------------------------проверяем каптчу------------------------------//
    if(isset($_POST["captcha"])){
        $captcha = trim(htmlspecialchars($_POST["captcha"], ENT_QUOTES));
        if(!empty($captcha)){
            $captcha = md5($captcha.$sol_captcha);
            if(($_SESSION["rand"] != $captcha) && ($_SESSION["rand"] != "")){
                exit("Ошибка в проверочном коде");
            }
        }else{
            exit("Отсутствует проверочный код");
        }
        //----------------------------проверяем каптчу------------------------------//
        //------------------------проверяем имя пользователя------------------------//
        if(isset($_POST["user_name"])){
            $login = mb_strtolower(trim($_POST["user_name"]));
            //нужно использовать --  convert('" . $login . "' using 'utf8') в SQL коде
            if(!empty($login)){
                $login = htmlspecialchars($login, ENT_QUOTES);
            }else{
                exit("Ошибка в поле «Логин»");
            }
        }else{
            exit("Отсутствует «Логин»");
        }
        //------------------------проверяем имя пользователя------------------------//
        //------------------------------проверяем пароль----------------------------//
        if(isset($_POST["user_pass"])){
            $password = trim($_POST["user_pass"]);
            if(!empty($password)){
                $password = htmlspecialchars($password, ENT_QUOTES);
                $password = md5($password.$sol_user_pass);
            }else{
                exit("Ошибка в поле «Пароль»");
            }
        }else{
            exit("Отсутствует «Пароль»");
        }
        //------------------------------проверяем пароль----------------------------//
        //------------------------------проверяем email-----------------------------//
        if(isset($_POST["user_email"])){
            $email = trim(htmlspecialchars($_POST["user_email"], ENT_QUOTES));
            if(!empty($email)){
                $email = mb_strtolower($email);
            }else{
                exit("Ошибка в поле «Email»");
            }
        }else{
            exit("Отсутствует «Email»");
        }
        //------------------------------проверяем email-----------------------------//
        //---------------------------------запрос к БД------------------------------//
        //-- проверка на дубликат пользователя
        $sql_chk = "SELECT user FROM tusers WHERE udln is null and user='" . $login . "'";
        //$sql_chk = "SELECT user FROM tusers WHERE udln is null and user=convert('" . $login . "' using 'utf8')";
        $res_chk = mysqli_query($db, $sql_chk);
        if($res_chk->num_rows == 0) {
            //-- проверка на дубликат пользователя
            //-- проверка на дубликат Email
            $sql_chk = "SELECT user FROM tusers WHERE udln is null and email='" . $email . "'";
            //$sql_chk = "SELECT user FROM tusers WHERE udln is null and user=convert('" . $login . "' using 'utf8')";
            $res_chk = mysqli_query($db, $sql_chk);
            if($res_chk->num_rows == 0) {
                //-- проверка на дубликат Email
                $sql = "INSERT INTO tusers(
                u_cr, d_cr, u_upd, d_upd, 
                user, password, email, gryppa, 
                blocked, last_ip 
                ) VALUES (
                '" . $login . "', now(), '" . $login . "', now(), 
                '" . $login . "',  '" . $password . "', '" . $email . "', 'ekspert', 
                0, " . ip2long($_SERVER['REMOTE_ADDR']) . "   
                )";
                if (mysqli_query($db, $sql) != true) {
                    exit('Внутренняя ошибка при регистрации пользователя.');
                } else {
                    $_SESSION["rand"] = '-RRWERWErwew5%W%E%5rwerw-';//change captcha
                }
            }else{
                exit("Указанный вами Email уже занят. Введите другой Email.");
            }
        }else{
            exit($errors_fields['login_exists']);
        }
        //---------------------------------запрос к БД------------------------------//
    }else{
        exit("Отсутствует проверочный код");
    }
}else{
    exit($errors_fields['direct_err']);
}
?>