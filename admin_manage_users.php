<?php
require_once("_functions.php");
require_once("_check_for_admin.php");
site_head();
?>
<style>
    /*------------------------------------      modal       ---------------------------------*/
    #modal_save_user .modal{width: 500px;}
    #modal_save_user .modal-dialog{width: 500px;}

    #modal_window .modal{width: 1250px;}
    #modal_window .modal-dialog{width: 1250px;}
    #modal_window .modal-body{height: 500px;overflow-y: scroll;}

    #modal_window.modal,
    #modal_window.modal-dialog,
    #modal_window.modal-content,
    #modal_window.modal-header,
    #modal_window.modal-body {padding:0;}
    /*------------------------------------      modal       ---------------------------------*/

    label{margin:10px 0 0 0;text-align: left;}
    select{font-size: 14px;height: 21px;}
    input[type=text]{text-align: left; padding: 0 0 0 3px;font-size: 14px;height: 21px;}

    #save_body{text-align: left;}
    #user_name, #user_pass, #user_group {
        border-top:solid 2px #9B9B9B;
        border-left:solid 2px #9B9B9B;
        border-right:solid 1px #cdcdcd;
        border-bottom:solid 1px #cdcdcd;
    }

    #btn1,#btn2,#btn3,#btn4{
        display: inline-block;
        width: 149px;
    }
    #btn_add_user, #btn_upd_user, #btn_del_user{
        display: inline-block;
        width: 200px;
    }
    #btn1,#btn2{background-color: rgba(0, 38, 255, 0.3);}
    #btn3,#btn4{background-color: rgba(0, 0, 0, 0.3);}
    #btn_add_user{background-color: rgba(0, 255, 0, 0.3);}
    #btn_upd_user{background-color: rgba(255, 255, 0, 0.3);}
    #btn_del_user{background-color: rgba(255, 0, 0, 0.3);}

    #btn1:hover, #btn2:hover, #btn3:hover, #btn4:hover,
    #btn_add_user:hover, #btn_upd_user:hover, #btn_del_user:hover,
    #btn_log:hover{
        border: 1px solid blue;
    }
    /*--------------------------------------------------------*/
    /*---------- tablica s filtrom ----------*/
    .table_users tbody {
        display:block;
        height:650px;
        overflow-y:scroll;
        border: 1px solid rgba(0, 0, 0, 0.04);
    }
    .table_users thead,
    .table_users tbody tr {
        display:table;
        width:750px;
        table-layout:fixed;
    }
    .table_users thead { width:calc(750px - 19px); margin-left: 1px; }
    .table_users table { width:750px; }
    /*---------- tablica s filtrom ----------*/
    .table_users {width: 750px;}
    .table_users tr:hover {background-color: rgba(0, 255, 0, 0.16);}
    .table_users th{padding:2px 1px 2px 1px;margin:0;font-size:12px;line-height:1;border:1px solid rgba(105, 105, 105, 0.6);text-align:center;background-color:#e6e6e6;}
    .table_users td{padding:2px;margin:0;font-size:12px;line-height:1;border:1px solid rgba(156, 156, 156, 0.6);cursor:pointer;}
    /*--------------------------------------------------------*/
    .red1{color: rgb(223, 0, 0);font-weight: 600;}
    .blue1{color: rgba(0, 0, 255, 0.75);font-weight: 600;}

    .btn_login_log{width:80px;height:42px;background-color: rgba(0, 0, 0, 0.15);margin: 0 0 0 5px;}
    .btn_activity_today_log{width:60px;height:42px;background-color: rgba(0, 0, 0, 0.15);margin: 0 0 0 5px;}

    .btn_activity_log {  height:20px;background-color: rgba(0, 0, 0, 0.15);margin:1px;padding:0 3px 0 3px;line-height: 1;  }
    .tbl_tmp{font-size:12px;word-break: break-all;}
    .tbl_tmp tr:hover {background-color: rgba(0, 255, 0, 0.16);}
    .tbl_tmp th{background-color:#e6e6e6;text-align:center;line-height:1;padding:2px 5px 2px 5px;}
    .tbl_tmp td{border:1px solid rgba(195, 195, 195, 0.33);padding:1px 5px 1px 5px;margin:2px;}
</style>
<script>
    /*function test1(){$.get("add_upd_del/admin/del_udln.php", {}, function (data) {alert(data);});}*/
    function get_row_id_in_table_users(){
        var id = 0;
        $('.table_users input:checkbox:checked').each(function () {id = $(this).val();});
        return id;
    }
    function checkbox_select_click_for_table_users() {
        var touchtime = 0, tmp;
        $(".table_users tr").click(function() {
            if (touchtime == 0) {
                touchtime = new Date().getTime();
                tmp = $(this).find('td:eq(0)').html();
                if ($('.table_users #ch' + tmp).is(':checked')) {
                    $('.table_users #ch' + tmp).prop('checked', false);
                } else {
                    $('.table_users :checkbox').prop('checked', false);
                    $('.table_users #ch' + tmp).prop('checked', true);
                }
            } else {
                if (((new Date().getTime()) - touchtime) < 300) {
                    tmp = $(this).find('td:eq(0)').html();
                    if (!$('.table_users #ch' + tmp).is(':checked')) {
                        $('.table_users :checkbox').prop('checked', false);
                        $('.table_users #ch' + tmp).prop('checked', true);
                    }
                    //----- upd
                    if(get_row_id_in_table_users()>0) table_users_select();
                    //----- upd
                } else {
                    touchtime = new Date().getTime();
                    tmp = $(this).find('td:eq(0)').html();
                    if ($('.table_users #ch' + tmp).is(':checked')) {
                        $('.table_users #ch' + tmp).prop('checked', false);
                    } else {
                        $('.table_users :checkbox').prop('checked', false);
                        $('.table_users #ch' + tmp).prop('checked', true);
                    }
                }
            }
        });
        $(".table_users :checkbox").click(function () {
            if ($(this).is(':checked')) {
                $(this).prop('checked', false);
            } else {
                $('.table_users :checkbox').prop('checked', false);
                $(this).prop('checked', true);
            }
        });
    }

    function lock_all(){
        var data = $.ajax({
            type: 'GET',
            url: "add_upd_del/admin/admin_manage_users_lock_all.php",
            data: {
            },
            dataType: 'html', context: document.body, global: false, async: false,
            success: function (data) {
                return data;
            }
        }).responseText;
        //----------------------------------------------------------------------------//
        table_users_show();
        if (data != '') alert(data);
        //----------------------------------------------------------------------------//
    }
    function lock_selected(){
        var id_user = get_row_id_in_table_users();
        if(id_user!=0) {
            var data = $.ajax({
                type: 'GET',
                url: "add_upd_del/admin/admin_manage_users_lock_selected.php",
                data: {
                    id_user: id_user
                },
                dataType: 'html', context: document.body, global: false, async: false,
                success: function (data) {
                    return data;
                }
            }).responseText;
            //----------------------------------------------------------------------------//
            table_users_show();
            if (data != '') alert(data);
            //----------------------------------------------------------------------------//
        }else{
            alert('Выберите пользователей, которых нужно \nзаблокировать / разблокировать / удалить.');
        }
    }
    function unlock_all(){
        var data = $.ajax({
            type: 'GET',
            url: "add_upd_del/admin/admin_manage_users_unlock_all.php",
            data: {
            },
            dataType: 'html', context: document.body, global: false, async: false,
            success: function (data) {
                return data;
            }
        }).responseText;
        //----------------------------------------------------------------------------//
        table_users_show();
        if (data != '') alert(data);
        //----------------------------------------------------------------------------//
    }
    function unlock_selected(){
        var id_user = get_row_id_in_table_users();
        if(id_user!=0) {
            var data = $.ajax({
                type: 'GET',
                url: "add_upd_del/admin/admin_manage_users_unlock_selected.php",
                data: {
                    id_user: id_user
                },
                dataType: 'html', context: document.body, global: false, async: false,
                success: function (data) {
                    return data;
                }
            }).responseText;
            //----------------------------------------------------------------------------//
            table_users_show();
            if (data != '') alert(data);
            //----------------------------------------------------------------------------//
        }else{
            alert('Выберите пользователей, которых нужно \nзаблокировать / разблокировать / удалить.');
        }
    }

    function table_users_show(){
        var data = $.ajax({
            type: 'GET',
            url: "add_upd_del/admin/admin_manage_users_table_users_show.php",
            data: {
            },
            dataType: 'html', context: document.body, global: false, async: false,
            success: function (data) {
                return data;
            }
        }).responseText;
        //----------------------------------------------------------------------------//
        $("#table_users_body").html(data);
        checkbox_select_click_for_table_users();
        //----------------------------------------------------------------------------//
    }
    function table_users_select() {
        //------------------------------------------------//
        $("#user_name").val('');
        $("#user_pass").val('');
        $("#user_group option").prop("selected", false);
        //------------------------------------------------//
        var id_user = get_row_id_in_table_users();
        var data = $.ajax({
            type: 'GET',
            url: "add_upd_del/admin/admin_manage_users_table_users_select.php",
            data: {
                id_user: id_user
            },
            dataType: 'html', context: document.body, global: false, async: false,
            success: function (data) {
                return data;
            }
        }).responseText;
        //----------------------------------------------------------------------------//
        var tmp_upd = data.split('@%#$!%$@');
        $("#user_name").val(tmp_upd[0]);
        $("#user_pass").val(tmp_upd[1]);
        $("#user_group [value='" + tmp_upd[2] + "']").prop("selected", "selected");
        $('#modal_save_user').modal('show');
        //----------------------------------------------------------------------------//
    }
    function table_users_save() {
        //--------------------------------------------------------//
        var user_name = $('#user_name').val();
        var user_pass = $('#user_pass').val();
        var user_group = $('#user_group').val();
        //--------------------------------------------------------//
        var id_user = get_row_id_in_table_users();
        var data = $.ajax({
            type: 'GET',
            url: "add_upd_del/admin/admin_manage_users_table_users_save.php",
            data: {
                user_name: user_name,
                user_pass: user_pass,
                user_group: user_group,
                id_user: id_user
            },
            dataType: 'html', context: document.body, global: false, async: false,
            success: function (data) {
                return data;
            }
        }).responseText;
        //----------------------------------------------------------------------------//
        if (data != ''){
            $('.error_mssg1').html(data);
        }else{
            table_users_show();
            $('#modal_save_user').modal('hide');
        }
        //----------------------------------------------------------------------------//
    }
    function table_users_del(){
        var id_user = get_row_id_in_table_users();
        if(id_user!=0) {
            if (confirm('Удалить пользователя ?')) {
                //--------------------------------------------------------//
                var data = $.ajax({
                    type: 'GET',
                    url: "add_upd_del/admin/admin_manage_users_table_users_del.php",
                    data: {
                        id_user: id_user
                    },
                    dataType: 'html', context: document.body, global: false, async: false,
                    success: function (data) {
                        return data;
                    }
                }).responseText;
                //----------------------------------------------------------------------------//
                if (data != ''){
                    $('.error_mssg1').html(data);
                }else{
                    table_users_show();
                }
                //----------------------------------------------------------------------------//
            }
        }
    }
</script>
<div style="width:100%;text-align: center;margin-left: 10px;margin-right: 10px;">
    <p style="font-size: 25px;">Управление пользователями</p>
    <!--<button type="button" onclick="test1()">del_ydln</button>-->
    <table align="center">
        <tr>
            <td>
                <button class="btn btn-xs btn-default" id="btn_add_user">Добавить пользователя</button>
                <button class="btn btn-xs btn-default" id="btn_upd_user">Редактировать пользователя</button>
                <button class="btn btn-xs btn-default" id="btn_del_user">Удалить пользователя</button>
            </td>
            <td rowspan="2">
                <button class="btn btn-xs btn-default btn_login_log">Log<br>authorization</button>
                <button class="btn btn-xs btn-default btn_activity_today_log">Activity<br>today</button>
            </td>
        </tr>
        <tr>
            <td>
                <button class="btn btn-xs btn-default" onclick="lock_selected()" id="btn1">Заблокировать</button>
                <button class="btn btn-xs btn-default" onclick="unlock_selected()" id="btn2">Разблокировать</button>
                <button class="btn btn-xs btn-default" onclick="lock_all()" id="btn3">Заблокировать всех</button>
                <button class="btn btn-xs btn-default" onclick="unlock_all()" id="btn4">Разблокировать всех</button>
            </td>
        </tr>
    </table>
    <table class='table_users' align='center'>
        <thead>
        <tr>
            <th class='w30px'>№<br>п.п.</th>
            <th class='w20px'></th>
            <th class='w150px'>Пользователь<br>(login)</th>
            <th class='w90px'>Группа</th>
            <th class='w60px'>Доступ</th>
            <th class='w150px'>Последняя<br>авторизация</th>
            <th class='w150px'>Последняя<br>активность</th>
            <th class='w150px'>Последний<br>раз в сети</th>
            <th class='w100px'>Активность<br>пользователя</th>
            </tr>
        </thead>
        <tbody id="table_users_body"></tbody>
    </table>
    <?php
    $sql_eksperttest = "select DISTINCT teksperttest.id from teksperttest left join teksperttest_vopros on teksperttest_vopros.id_eksperttest=teksperttest.id where teksperttest.udln is null";
    $res_eksperttest = mysqli_query($db, $sql_eksperttest);
    $res_eksperttest->num_rows;
    $sql_user = "select id from tusers where udln is null and gryppa='ekspert'";
    $res_user = mysqli_query($db, $sql_user);
    $res_user->num_rows;
    ?>
    <table align="center">
        <tr>
            <td>
                Всего учётных записей проходивших тестирование: <?=$res_eksperttest->num_rows?>
            </td>
        </tr>
        <tr>
            <td>
                Всего учётных записей НЕ проходивших тестирование: <?=($res_user->num_rows-$res_eksperttest->num_rows)?>
            </td>
        </tr>
    </table>
</div>
<div class="modal fade" id="modal_save_user" tabindex="-1" role="dialog" aria-labelledby="save_user_label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="save_user_label">Пользователь</h3>
            </div>
            <div class="modal-body" id="save_body">
                <label for='user_name'>Имя пользователя</label>
                <input type='text' class='w100' id='user_name' autocomplete="off">
                <label for='user_pass'>Пароль пользователя</label>
                <input type='text' class='w100' id='user_pass' autocomplete="off">
                <label for='user_group'>Группа к которой принадлежит пользователь</label>
                <select class='w100' id='user_group'>
                    <option></option>
                    <option value='admin'>admin</option>
                    <option value='user'>user</option>
                    <option value='ekspert'>ekspert</option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                <button type="button" class="btn btn-primary" onclick="table_users_save()">Сохранить</button>
                <div class="error_mssg1"></div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" align="center" id="modal_window" tabindex="-1" role="dialog" aria-labelledby="modal_label">
    <div class="modal-dialog" role="document" id="modal_dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title" id="modal_label">&#160;</span>
            </div>
            <div class="modal-body" id="modal_body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>
<script>
    table_users_show();
    //-------------------------------------------------------------------------------------------------------//
    $('#btn_add_user').on('click', function () {$('#table_users :checkbox').prop('checked', false);table_users_select();});
    $('#btn_upd_user').on('click', function () {if(get_row_id_in_table_users()!=0) table_users_select();});
    $('#btn_del_user').on('click', function () {table_users_del();});
    //-------------------------------------------------------------------------------------------------------//
    $("#modal_save_user, #modal_window").draggable();
    //-------------------------------------------------------------------------------------------------------//
    $('#modal_save_user').on('hidden.bs.modal', function (e) {
        $("#user_name").val('');
        $("#user_pass").val('');
        $("#user_group option").prop("selected", false);
    });
    //-----------------------------------------------------------------------------------------------//
    $('#modal_window').on('hidden.bs.modal', function (e) {$('#modal_body').html('');});
    //-----------------------------------------------------------------------------------------------//
    $(".btn_login_log").on('click', function () {
        $('#modal_body').html('Загрузка...');
        $.get("add_upd_del/admin/admin_manage_users_authorization_log.php", {
        }, function (data) {
            $('#modal_window').modal('show');
            $("#modal_body").html(data);
        });
    });
    $(".btn_activity_today_log").on('click', function () {
        $('#modal_body').html('Загрузка...');
        $.get("add_upd_del/admin/admin_manage_users_activity_today_log.php", {
        }, function (data) {
            $('#modal_window').modal('show');
            $("#modal_body").html(data);
        });
    });
    //-----------------------------------------------------------------------------------------------//
    $('#page_admin_settings, #page_admin_manage_users').addClass('selected_page').css("color","black");
</script>
<?php
    site_foot();
?>