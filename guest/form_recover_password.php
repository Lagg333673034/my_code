<?php
session_start();
require_once("../_functions.php");
if(isset($_SESSION['user']) && !empty($_SESSION['user']) &&
    isset($_SESSION['user_id']) && !empty($_SESSION['user_id']) &&
    isset($_SESSION['gryppa']) && !empty($_SESSION['gryppa']) &&
    isset($_SESSION['ip']) && !empty($_SESSION['ip']) &&
    isset($_SESSION['web']) && !empty($_SESSION['web'])
){
    header("Location: http://".$_SERVER['SERVER_NAME']."/index.php");exit();
}
site_head();
?>
<script>
    function recover_password(){
        $('.mssg1_auth_reg').hide();
        $('.mssg1_auth_reg').html('');
        var email = $('#email').val();
        //var captcha = $('#captcha').val();
        var btn_submit_recover_password = $('#btn_submit_recover_password').val();

        if (email=='') {
            $('.mssg1_auth_reg').show();
            $('.mssg1_auth_reg').html('Заполните поле <b><?=$reg_fields['email']?></b>.');
            return false;
        }
        /*if (captcha=='') {
            $('.mssg1_auth_reg').show();
            $('.mssg1_auth_reg').html('Заполните поле <b></b>.');
            return false;
        }*/


        if(email!='' && /*captcha!='' && */btn_submit_recover_password!='') {
            $('.mssg1_auth_reg').show();
            $('.mssg1_auth_reg').html('Запрос обрабатывается ...');
            $('#btn_submit_recover_password').addClass('disabled');
            $("#btn_submit_recover_password").prop("onclick", null).off("click");
            var data = $.ajax({
                type: 'POST',
                url: "recover_password.php",
                data: {
                    email: email,
                    //captcha: captcha,
                    btn_submit_recover_password: btn_submit_recover_password
                },
                dataType: 'html', context: document.body, global: false, async: false,
                success: function (data) {
                    return data;
                }
            }).responseText;
            if(data!=''){
                $('.mssg1_auth_reg').html(data);
            }else{
                $('.mssg1_auth_reg').html('Успешно. На указанный при регистрации Email выслана ссылка для смены пароля.');
            }
        }
    }
</script>
<div class="div1">
    <div class="div2">
        <table class="recover_password_table w450px" align="center">
            <tr>
                <td class="textc font_size17 bold1 line_height1_1" style="border-top: hidden; border-left: hidden; border-right: hidden;">
                    Восстановление пароля
                </td>
            </tr>
            <tr>
                <td>
                    <span class="span1">
                        Для восстановления пароля введите адрес электронной почты вашей организации
                    </span>
                </td>
            </tr>
            <tr>
                <td>
                    <?php
                        if(isset($_SESSION['email']) && !empty($_SESSION['email'])){
                            $email=$_SESSION['email'];
                        }else{
                            $email="";
                        }
                    ?>
                    <input type='text' class="w100" id='email' required value="<?=$email?>">
                </td>
            </tr>
            <!--<tr>
                <td>
                    <span class="span1">
                        Проверочный код
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
                    <input type='text' name='captcha' class="captcha1 floatr" required autocomplete="off">
                </td>
            </tr>-->
            <tr>
                <td>
                    <button type='submit' class="btn btn-success w100" value="1" id="btn_submit_recover_password"
                            onclick="recover_password()">Получить ссылку
                    </button>
                </td>
            </tr>
            <tr>
                <td>
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