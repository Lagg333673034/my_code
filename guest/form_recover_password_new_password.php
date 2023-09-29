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
//-------------------------------------------------------------------------------//
$md5_id=trim(htmlspecialchars($_GET['val1'], ENT_QUOTES));
$md5_password=trim(htmlspecialchars($_GET['val2'], ENT_QUOTES));
$md5_email=trim(htmlspecialchars($_GET['val3'], ENT_QUOTES));
if (
    preg_match("/^[a-z0-9]+$/", $md5_id) &&
    preg_match("/^[a-z0-9]+$/", $md5_password) &&
    preg_match("/^[a-z0-9]+$/", $md5_email)
) {
    $_SESSION['val1']=trim(htmlspecialchars($_GET['val1'], ENT_QUOTES));
    $_SESSION['val2']=trim(htmlspecialchars($_GET['val2'], ENT_QUOTES));
    $_SESSION['val3']=trim(htmlspecialchars($_GET['val3'], ENT_QUOTES));
}
//-------------------------------------------------------------------------------//
site_head();
?>
<script>
    function recover_password_new_password(){
        $('.mssg1_auth_reg').hide();
        $('.mssg1_auth_reg').html('');
        var user_pass = $('#user_pass').val();
        //var captcha = $('#captcha').val();
        var btn_submit_recover_password_new_password = $('#btn_submit_recover_password_new_password').val();

        if (user_pass=='') {
            $('.mssg1_auth_reg').show();
            $('.mssg1_auth_reg').html('Заполните поле <b><?=$reg_fields['pass']?></b>.');
            return false;
        }
        /*if (captcha=='') {
            $('.mssg1_auth_reg').show();
            $('.mssg1_auth_reg').html('Заполните поле <b></b>.');
            return false;
        }*/

        if(user_pass!='' && /*captcha!='' &&*/ btn_submit_recover_password_new_password!='') {
            var data = $.ajax({
                type: 'POST',
                url: "recover_password_new_password.php",
                data: {
                    user_pass: user_pass,
                    //captcha: captcha,
                    btn_submit_recover_password_new_password: btn_submit_recover_password_new_password
                },
                dataType: 'html', context: document.body, global: false, async: false,
                success: function (data) {
                    return data;
                }
            }).responseText;

            $('.mssg1_auth_reg').show();
            $('#btn_submit_recover_password_new_password').addClass('disabled');
            $("#btn_submit_recover_password_new_password").prop("onclick", null).off("click");
            if(data!=''){
                $('.mssg1_auth_reg').html(data);
            }else{
                $('.mssg1_auth_reg').html('Пароль успешно изменён.');
            }
        }
    }
</script>
<div class="div1">
    <div class="div2">
        <table class="recover_password_table w450px" align="center">
            <tr>
                <td class="textc font_size17 bold1 line_height1_1" style="border-top: hidden; border-left: hidden; border-right: hidden;">
                    <?=$reg_fields['recover_pass']?>
                </td>
            </tr>
            <tr>
                <td>
                    <span class="span1">
                        Введите новый пароль
                    </span>
                </td>
            </tr>
            <tr>
                <td>
                    <input type='text' class="w100" id='user_pass' value="">
                </td>
            </tr>
            <!--<tr>
                <td>
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
            </tr>-->
            <tr>
                <td>
                    <button type='submit' class="btn btn-success w100" value="1" id="btn_submit_recover_password_new_password"
                            onclick="recover_password_new_password()"><?=$reg_fields['to_change_pass']?>
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