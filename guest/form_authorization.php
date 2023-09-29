<?php
session_start();
require_once("../_functions.php");
//------------------------------------------------------------------------//
if(
    isset($_SESSION['user']) || !empty($_SESSION['user']) ||
    isset($_SESSION['user_id']) || !empty($_SESSION['user_id']) ||
    isset($_SESSION['gryppa']) || !empty($_SESSION['gryppa']) ||
    isset($_SESSION['ip']) || !empty($_SESSION['ip']) ||
    isset($_SESSION['web']) || !empty($_SESSION['web'])
){
    header("Location: http://".$_SERVER['SERVER_NAME']."/index.php");exit();
}
//------------------------------------------------------------------------//
site_head();
?>
<style>
</style>
<script>
    function authorization(){
        $('.mssg1_auth_reg').hide();
        $('.mssg1_auth_reg').html('');
        var user_name = $('#user_name').val();
        var user_pass = $('#user_pass').val();
        var captcha = $('#captcha').val();
        var btn_submit_authoriz = $('#btn_submit_authoriz').val();

        if (user_name=='') {
            $('.mssg1_auth_reg').show();
            $('.mssg1_auth_reg').html('Заполните поле <b><?=$reg_fields['login']?></b>.');
            return false;
        }
        if (user_pass=='') {
            $('.mssg1_auth_reg').show();
            $('.mssg1_auth_reg').html('Заполните поле <b><?=$reg_fields['pass']?></b>.');
            return false;
        }
        if (captcha=='') {
            $('.mssg1_auth_reg').show();
            $('.mssg1_auth_reg').html('Заполните поле <b><?=$reg_fields['captcha']?></b>.');
            return false;
        }
        if(user_name!='' && user_pass!='' && captcha!='' && btn_submit_authoriz!='') {
            var regexp = /^[a-zA-Zа-яёА-ЯЁ0-9_#]{5,20}$/;
            if (!regexp.test(user_name)) {
                $('.mssg1_auth_reg').show();
                $('.mssg1_auth_reg').html(
                    'Некорректное имя пользователя. ' +
                    'Длинна имени пользователя от 5 до 20 символов. '+
                    'Разрешены символы латинского и кириллического алфавита, цифры и символ подчёркивания.'
                );
                return false;
            }
            if (!regexp.test(user_pass)) {
                $('.mssg1_auth_reg').show();
                $('.mssg1_auth_reg').html(
                    'Некорректный пароль.' +
                    'Длинна пароля от 5 до 20 символов. '+
                    'Разрешены символы латинского и кириллического алфавита, цифры и символ подчёркивания.'
                );
                return false;
            }
            var data = $.ajax({
                type: 'POST',
                url: "authorization.php",
                data: {
                    user_name: user_name,
                    user_pass: user_pass,
                    captcha: captcha,
                    btn_submit_authoriz: btn_submit_authoriz
                },
                dataType: 'html', context: document.body, global: false, async: false,
                success: function (data) {
                    return data;
                }
            }).responseText;

            if(data!=''){
                $('.mssg1_auth_reg').show();
                $('.mssg1_auth_reg').html(data);
            }else{
                $('#btn_submit_authoriz').addClass('disabled');
                $("#btn_submit_authoriz").prop("onclick", null).off("click");
                location.reload();
            }
        }
    }
</script>
<div class="div1_auth_reg">
    <div class="div2_auth_reg">
        <table class="table1_auth_reg w200px" align="center">
            <tr>
                <td class="textc font_size17 bold1 line_height1_1" style="border-top: hidden; border-left: hidden; border-right: hidden;">
                    Авторизация пользователя в системе
                </td>
            </tr>
            <tr>
                <td class="textl">
                    <span class="span1">Имя пользователя</span>
                </td>
            </tr>
            <tr>
                <td>
                    <?php
                    if(isset($_SESSION['login']) && !empty($_SESSION['login'])){
                        $user=$_SESSION['login'];
                    }else{
                        $user="";
                    }
                    ?>
                    <input type='text' class="w100" id='user_name' value="<?=$user?>">
                </td>
            </tr>
            <tr>
                <td class="textl">
                    <span class="span1">Пароль</span>
                </td>
            </tr>
            <tr>
                <td>
                    <input type='text' class="w100" id='user_pass' autocomplete="off" value="">
                </td>
            </tr>
            <tr>
                <td class="textl">
                <span class="span1">Проверочный код
                    <span class="glyphicon glyphicon-refresh cursor1"
                          onclick="document.getElementById('captcha1').src = 'captcha.php?' + Math.random()">
                    </span>
                </span>
                </td>
            </tr>
            <tr>
                <td>
                    <img id="captcha1" src="captcha.php" class="floatl" >
                </td>
            </tr>
            <tr>
                <td>
                    <input type='text' id='captcha' class="captcha1 floatr" required autocomplete="off">
                </td>
            </tr>
            <tr>
                <td>
                    <button type='submit' class="btn btn-success w100" id="btn_submit_authoriz" value="1" onclick="authorization()">Вход</button>
                </td>
            </tr>
            <!--<tr>
                <td>
                    <a href='form_registration.php'>Регистрация</a>
                </td>
            </tr>-->
            <tr>
                <td class="textl">
                    <a href='form_recover_password.php'>Восстановление пароля</a>
                </td>
            </tr>
            <tr>
                <td class="textl">
                    <a href='form_registration.php'>Регистрация</a>
                </td>
            </tr>
        </table>
        <div hidden class='mssg1_auth_reg w450px'></div>
    </div>
</div>
<?php
site_foot();
?>