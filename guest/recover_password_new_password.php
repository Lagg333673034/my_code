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

if(isset($_POST["btn_submit_recover_password_new_password"]) && !empty($_POST["btn_submit_recover_password_new_password"])){
    //----------------------------проверяем каптчу------------------------------//
    /*if(isset($_POST["captcha"])){
        $captcha = trim(htmlspecialchars($_POST["captcha"], ENT_QUOTES));
        if(!empty($captcha)){
            $captcha = md5($captcha.$sol_captcha);
            if(($_SESSION["rand"] != $captcha) && ($_SESSION["rand"] != "")){
                exit($errors_fields['captch_err']);
            }
        }else{
            exit($errors_fields['captch_null']);
        }*/
        //----------------------------проверяем каптчу------------------------------//
        //------------------------------проверяем пароль----------------------------//
        if(isset($_POST["user_pass"])){
            $password = trim($_POST["user_pass"]);
            if(!empty($password)){
                $password = htmlspecialchars($password, ENT_QUOTES);
                $password = md5($password.$sol_user_pass);
            }else{
                exit($errors_fields['pass_null']);
            }
        }else{
            exit($errors_fields['pass_null2']);
        }
        //------------------------------проверяем пароль----------------------------//
        //---------------------------------запрос к БД------------------------------//
        $md5_id = trim(htmlspecialchars($_SESSION['val1'], ENT_QUOTES));
        $md5_password = trim(htmlspecialchars($_SESSION['val2'], ENT_QUOTES));
        $md5_email = trim(htmlspecialchars($_SESSION['val3'], ENT_QUOTES));

        //exit($md5_id."<br>".$md5_password."<br>".$md5_email);

        unset($_SESSION['val1']);
        unset($_SESSION['val2']);
        unset($_SESSION['val3']);

        if (!(
            preg_match("/^[a-z0-9]+$/", $md5_id) &&
            preg_match("/^[a-z0-9]+$/", $md5_password) &&
            preg_match("/^[a-z0-9]+$/", $md5_email)
        )) {
            exit("Ошибка. Хэш-суммы не совпали. Попробуте получить новую ссылку, т.к. эта устарела или имеет неправильный формат.");
        }

        //-- проверяем есть ли такой человек
        $sql_chk = "SELECT id  
        FROM tusers 
        WHERE udln is null 
        and md5(concat(id,'$sol_user_id'))='".$md5_id."' 
        and password='".$md5_password."' 
        and md5(concat(email,'$sol_user_email'))='".$md5_email."'";
        $res_chk = mysqli_query($db, $sql_chk);
        if($res_chk->num_rows == 1) {
            //-- проверяем есть ли такой человек

            //-- UPDATE пароля
            $sql = "UPDATE tusers SET 
            u_upd = 'recover_password', 
            d_upd = now(), 
            password = '".$password."' 
            WHERE udln is null 
            and md5(concat(id,'$sol_user_id'))='".$md5_id."' 
            and password='".$md5_password."' 
            and md5(concat(email,'$sol_user_email'))='".$md5_email."'";
            if(mysqli_query($db, $sql)!=true){
                exit('Неизвестная ошибка при редактировании пароля.');
            }
            //-- UPDATE пароля

            //$_SESSION["rand"]='-RRWERWErwew5%W%E%5rwerw-';//change captcha
        }else{
            exit("<strong>Ошибка!</strong> Ссылка устарела. Получите новую ссылку на восстановление пароля, а затем с её помощью измените пароль.");
        }
        //---------------------------------запрос к БД------------------------------//
    /*}else{
        exit($errors_fields['capthc_null']);
    }*/
}else{
    exit($errors_fields['direct_err']);
}
?>