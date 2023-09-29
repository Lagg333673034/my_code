<?php
session_start();
//--------------------------------------------------------------------------------------------//
// Если запрос идёт не из Ajax
if( $_SERVER['HTTP_X_REQUESTED_WITH'] != "XMLHttpRequest" )
{
    exit("Access denied!");
}
//--------------------------------------------------------------------------------------------//
$expiry = 60*60*10; // sessiya maksimym na 10 chasov
setcookie(session_name(), session_id(), time()+$expiry, "/", "",0);

$_SESSION["messages"] = '';
$_SESSION['downtime'] = time(); // vklycaem vrema prostoya
//--------------------------------------------------------------------------------------------//
require_once('../_dbconnect.php');
require_once('../_fields_name.php');
require_once('../_sol.php');

if(isset($_POST["btn_submit_authoriz"]) && !empty($_POST["btn_submit_authoriz"])){
    //----------------------------проверяем каптчу------------------------------//
    if(isset($_POST["captcha"])){
        $captcha = trim(htmlspecialchars($_POST["captcha"], ENT_QUOTES));
        if(!empty($captcha)){
            $captcha = md5($captcha.$sol_captcha);
            if(($_SESSION["rand"] != $captcha) && ($_SESSION["rand"] != "")){
                exit("<b>Ошибка!</b> Вы ввели неправильный проверочный код.");
            }
        }else{
            exit("<b>Ошибка!</b> Поле для воода проверочного кода не должно быть пустым.");
        }
        //----------------------------проверяем каптчу------------------------------//
        //------------------------проверяем имя пользователя------------------------//
        if(isset($_POST["user_name"])){
            $login = mb_strtolower(trim($_POST["user_name"]));
            if(!empty($login)){
                $login = htmlspecialchars($login, ENT_QUOTES);
            }else{
                exit("<b>Ошибка!</b> Поле логин не должно быть пустым.");
            }
        }else{
            exit("<b>Ошибка!</b> Нет поля логин.");
        }
        //------------------------проверяем имя пользователя------------------------//
        //------------------------------проверяем пароль----------------------------//
        if(isset($_POST["user_pass"])){
            $password = trim($_POST["user_pass"]);
            if(!empty($password)){
                $password = htmlspecialchars($password, ENT_QUOTES);
                $password = md5($password.$sol_user_pass);
            }else{
                exit("<b>Ошибка!</b> Поле пароль не должно быть пустым.");
            }
        }else{
            exit("<b>Ошибка!</b> Нет поля пароль.");
        }
        //------------------------------проверяем пароль----------------------------//
        //---------------------------------запрос к БД------------------------------//
        $sql="SELECT id, gryppa, blocked 
              FROM tusers 
              WHERE udln is null 
              and user = '".$login."' 
              and password = '".$password."'";
        $res = mysqli_query($db,$sql);
        $line=mysqli_fetch_array($res,MYSQLI_NUM);

        //-- запись в базу попытки авторизации
        if(1) {
            if ($res->num_rows == 1) $pass = '********'; else $pass = 'ошибка';
            $sql_zapis_avtoriz = "INSERT INTO tconnections(
                                  data, 
                                  s_kakogo_ip, 
                                  brayzer, 
                                  login, pass 
                                  )VALUES( 
                                  now(), 
                                  " . ip2long($_SERVER['REMOTE_ADDR']) . ", 
                                  '" . $_SERVER['HTTP_USER_AGENT'] . "',  
                                  '" . $login . "','$pass')";
            $sql_zapis_avtoriz = mysqli_query($db, $sql_zapis_avtoriz);
        }
        //-- запись в базу попытки авторизации

        if($res->num_rows == 0){
            exit("<b>Ошибка!</b> Неправильный логин и/или пароль.");
        }
        if($res->num_rows == 1 && $line[2]==1){
            exit("<b>Ошибка!</b> Учётная запись была временно отключена.");
        }

        //admin,user
        if($res->num_rows == 1 && $line[2]==0 && $line[3]==0){
            //------last_ip && last_authorization_data
            $sql_upd_last_ip = "UPDATE tusers SET 
                                last_ip=".ip2long($_SERVER['REMOTE_ADDR']).", 
                                last_authorization_data=now() 
                                where udln is null 
                                and user = '".$login."' 
                                and password = '".$password."' 
                                and blocked = 0";
            mysqli_query($db, $sql_upd_last_ip);
            //------last_ip && last_authorization_data
            $_SESSION['user'] = $login;
            $_SESSION['user_id'] = md5($line[0].$sol_user_id);
            $_SESSION['gryppa'] = md5($line[1].$sol_user_gryppa);
            $_SESSION['ip'] = md5($_SERVER['REMOTE_ADDR'].$sol_user_ip);
            $_SESSION['web'] = md5($_SERVER['HTTP_USER_AGENT'].$sol_user_web_agent);
        }

        //org
        if($res->num_rows == 1 && $line[2]==0 && $line[3]!=0){
            //------last_ip && last_authorization_data
            $sql_upd_last_ip = "UPDATE tusers SET 
                                last_ip=".ip2long($_SERVER['REMOTE_ADDR']).", 
                                last_authorization_data=now() 
                                where udln is null 
                                and user = '".$login."' 
                                and password = '".$password."' 
                                and blocked = 0";
            mysqli_query($db, $sql_upd_last_ip);
            //------last_ip && last_authorization_data
            $_SESSION['user'] = $login;
            $_SESSION['user_id'] = md5($line[0].$sol_user_id);
            $_SESSION['gryppa'] = md5($line[1].$sol_user_gryppa);
            $_SESSION['ip'] = md5($_SERVER['REMOTE_ADDR'].$sol_user_ip);
            $_SESSION['web'] = md5($_SERVER['HTTP_USER_AGENT'].$sol_user_web_agent);
        }
        //---------------------------------запрос к БД------------------------------//
    }else{
        exit("<b>Ошибка!</b> Нет поля для ввода проверочного кода.");
    }
}else{
    exit($errors_fields['direct_err']);
}
?>