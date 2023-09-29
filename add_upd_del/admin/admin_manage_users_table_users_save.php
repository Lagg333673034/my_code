<?php
require_once("../../_functions.php");
require_once("../../_check_for_admin.php");
// Если запрос идёт не из Ajax
if( $_SERVER['HTTP_X_REQUESTED_WITH'] != "XMLHttpRequest" )
{
    exit("Access denied!");
}
//-------------------------------------------------------------------------------------------------//
$user_name=check_string($_GET['user_name']);
$user_pass=check_string($_GET['user_pass']);
$user_group=check_string($_GET['user_group']);
$id_user=check_number($_GET['id_user']);
//-------------------------------------------------------------------------------------------------//
if($user_name==''){
    exit('Заполните имя пользователя');
}
if($user_pass==''){
    exit('Заполните пароль');
}
if($user_group==''){
    exit('Заполните группу');
}
//-------------------------------------------------------------------------------------------------//
if($id_user==0){
    $sql = "SELECT id from tusers where udln is null and name='$user_name' and id!=$id_user";
    $res = mysqli_query($db, $sql);
    if($res->num_rows == 0) {
        $sql = "INSERT INTO tusers(
        u_cr, d_cr, u_upd, d_upd, 
        user, password, gryppa, blocked
        )values(
        '" . $_SESSION['user'] . "', now(), '" . $_SESSION['user'] . "', now(), 
        '$user_name', '".md5($user_pass.$sol_user_pass)."', '$user_group', 1)";
        if (mysqli_query($db, $sql) != true) exit('Внутренняя ошибка.');
    }else{
        exit('Пользователь с таким имененм уже существует. Используйте другое имя.');
    }
}
if($id_user>0){
    if($user_pass=='********'){
        $str_pass='';
    }else{
        $str_pass=" password='".md5($user_pass.$sol_user_pass)."', ";
    }

    if (md5($id_user . $sol_user_id) == $_SESSION['user_id'] && $user_group != 'admin'){
        exit('Вы администратор и не можете сменить себе группу на обычного пользователя.');
    }else{
        $sql = "SELECT id from tusers where udln is null and name='$user_name' and id!=$id_user";
        $res = mysqli_query($db, $sql);
        if($res->num_rows == 0) {
            $sql = "update tusers set 
            user='$user_name', 
            $str_pass
            gryppa='$user_group', 
            u_upd='" . $_SESSION['user'] . "', 
            d_upd=now()
            where udln is null and id=$id_user";
            if (mysqli_query($db, $sql) != true) exit('Внутренняя ошибка.');
        }else{
            exit('Пользователь с таким имененм уже существует. Используйте другое имя.');
        }
    }
}



?>