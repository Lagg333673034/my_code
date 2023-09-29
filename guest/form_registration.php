<?php
session_start();
require_once("../_functions.php");
//------------------------------------------------------------------------//
if ($_SESSION['gryppa'] == md5('admin'.$sol_user_gryppa)) {
    header("Location: http://" . $_SERVER['SERVER_NAME'] . "/ekspert.php");exit();
}
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
<script>
    function registration(){
        $('.mssg1_auth_reg').hide();
        $('.mssg1_auth_reg').html('');
        var user_name = $('#user_name').val();
        var user_pass = $('#user_pass').val();
        var user_email = $('#user_email').val();
        var captcha = $('#captcha').val();
        var btn_submit_registr = $('#btn_submit_registr').val();

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
        if (user_email=='') {
            $('.mssg1_auth_reg').show();
            $('.mssg1_auth_reg').html('Заполните поле <b><?=$reg_fields['email']?></b>.');
            return false;
        }
        if (captcha=='') {
            $('.mssg1_auth_reg').show();
            $('.mssg1_auth_reg').html('Заполните поле <b><?=$reg_fields['captcha']?></b>.');
            return false;
        }
        if(user_name!='' && user_pass!='' && user_email!='' && captcha!='' && btn_submit_registr!='') {
            var regexp = /^[a-zA-Zа-яёА-ЯЁ0-9_]{5,20}$/;
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
                url: "registration.php",
                data: {
                    user_name: user_name,
                    user_pass: user_pass,
                    user_email: user_email,
                    captcha: captcha,
                    btn_submit_registr: btn_submit_registr
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
                $('.mssg1_auth_reg').show();
                $('.mssg1_auth_reg').html('Успешно. Теперь это имя пользователя и пароль вы можете использовать для авторизации.');
                $('#btn_submit_registr').addClass('disabled');
                $("#btn_submit_registr").prop("onclick", null).off("click");
            }
        }
    }
</script>
<div class="div1_auth_reg">
    <div class="div2_auth_reg">
        <table class="table1_auth_reg w200px" align="center">
            <tr>
                <td class="textc font_size17 bold1 line_height1_1" style="border-top: hidden; border-left: hidden; border-right: hidden;">
                    <?=$reg_fields['registr']?>
                </td>
            </tr>
            <tr>
                <td class="textl">
                    <span class="span1">
                        <?=$reg_fields['login']?>
                    </span>
                </td>
            </tr>
            <tr>
                <td>
                    <input type='text' class="w100" id='user_name' value="">
                </td>
            </tr>
            <tr>
                <td class="textl">
                    <span class="span1">
                        <?=$reg_fields['pass']?>
                    </span>
                </td>
            </tr>
            <tr>
                <td>
                    <input type='text' class="w100" id='user_pass' autocomplete="off" value="">
                </td>
            </tr>
            <tr>
                <td class="textl">
                    <span class="span1">
                        <?=$reg_fields['email']?>
                    </span>
                </td>
            </tr>
            <tr>
                <td>
                    <input type='text' class="w100" id='user_email' value="">
                </td>
            </tr>
            <tr>
                <td class="textl">
                    <span class="span1">
                        <?=$reg_fields['captcha']?>
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
                    <button type='button' class="btn btn-success w100" id="btn_submit_registr" value="1"
                            onclick="registration()"><?=$reg_fields['to_registr']?>
                    </button>
                </td>
            </tr>
            <tr>
                <td class="textl">
                    <a href='form_authorization.php'>Авторизация</a>
                </td>
            </tr>
        </table>
        <div hidden class="mssg1_auth_reg w450px"></div>
    </div>
</div>
<?php
site_foot();
?>