<?php
session_start();
require_once('../_dbconnect.php');
require_once('../_fields_name.php');
require_once('../_sol.php');

require_once('../PHPMailer/Exception.php');
require_once('../PHPMailer/PHPMailer.php');
require_once('../PHPMailer/SMTP.php');

// Если запрос идёт не из Ajax
if( $_SERVER['HTTP_X_REQUESTED_WITH'] != "XMLHttpRequest" )
{
    exit("Access denied!");
}

if(isset($_POST["btn_submit_recover_password"]) && !empty($_POST["btn_submit_recover_password"])){
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
        //----------------------------проверяем Email-------------------------------//
        if(isset($_POST["email"])){
            $email = trim(htmlspecialchars($_POST["email"], ENT_QUOTES));
            if(!empty($email)){
                $email = mb_strtolower($email);
            }else{
                exit($errors_fields['email_null']);
            }
        }else{
            exit($errors_fields['email_null2']);
        }
        //----------------------------проверяем Email-------------------------------//
        //---------------------------------запрос к БД------------------------------//
        //-- проверка существования Email
        $sql_chk = "SELECT id, password FROM tusers WHERE udln is null and email='" . $email . "' and (gryppa='admin' or gryppa='ekspert')";
        $res_chk = mysqli_query($db, $sql_chk);
        if($res_chk->num_rows == 1) {
            $line_chk=mysqli_fetch_array($res_chk, MYSQLI_NUM);
            //-- проверка существования Email
            $md5_id=md5($line_chk[0].$sol_user_id);
            $md5_password=$line_chk[1];
            $md5_email=md5($email.$sol_user_email);

            $mail = new \PHPMailer\PHPMailer\PHPMailer();

            $mail->isSMTP();
            $mail->Host = 'smtp.ugletele.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'gia@resobrnadzor.ugletele.com';
            $mail->Password = 'Donresobr123456#';
            $mail->Port = 25;
            //-----------------------------------------------------------------------------//
            //$mail->SMTPDebug  = 1;
            //$mail->Host = "ssl://smtp.gmail.com";
            $mail->SMTPKeepAlive = true;    //esli local, to nyjno zakomentit
            $mail->Mailer = “smtp”;         //esli local, to nyjno zakomentit
            //-----------------------------------------------------------------------------//
            $mail->setFrom('gia@resobrnadzor.ugletele.com', 'resobrnadzor.ugletele.com');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Восстановление пароля';
            $mail->Body    = "Для восстановления пароля пройдите по указанной сылке ниже.<br>
<a>http://".$_SERVER['SERVER_NAME']."/guest/form_recover_password_new_password.php?val1=".$md5_id."&val2=".$md5_password."&val3=".$md5_email."</a><br><br>
Если вы не знаете, что это за письмо и почему вы его получили, то это значит, что кто-то по ошибке указал ваш адрес электронной почты, чтобы восстановить доступ к своему аккаунту.<br>
Просто не обращайте внимания на это письмо и удалите его.";
            if(!$mail->send()) {
                echo 'Mailer Error: ' . $mail->ErrorInfo;
                //exit('Произошла ошибка. Письмо не отправлено.');
            }

            //$_SESSION["rand"]='-RRWERWErwew5%W%E%5rwerw-';//change captcha
        }else{
            exit("Электронный адрес не найден");
        }
        //---------------------------------запрос к БД------------------------------//
    /*}else{
        exit($errors_fields['capthc_null']);
    }*/
}else{
    exit($errors_fields['direct_err']);
}
?>