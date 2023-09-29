<?php
require_once("_functions.php");
require_once("_check_for_admin.php");
site_head();
?>
<style>
    .titl1{font-size:25px;margin:0;padding:0;}
    .modal{padding:0;}
    .modal-dialog,.modal-content{width:900px;}
    /*--------------------------------------------------------*/
    .table_spravochnik {width: 100%;}
    .table_spravochnik tr:hover {background-color: rgba(0, 255, 0, 0.16);}
    .table_spravochnik th{padding:5px 1px 5px 1px;margin:0;font-size:14px;line-height:1;border:1px solid rgba(105, 105, 105, 0.6);text-align:center;background-color:#e6e6e6;}
    .table_spravochnik td{padding:2px 5px;margin:0;font-size:14px;line-height:1;border:1px solid rgba(156, 156, 156, 0.6);cursor:pointer;}
    .table_spravochnik td:nth-child(1){padding:1px;width: 35px;}
    .table_spravochnik td:nth-child(2){padding:1px;width: 20px;}
    /*--------------------------------------------------------*/
    .table_spravochnik_select {width: 100%;}
    .table_spravochnik_select td{padding:1px;margin:0;font-size:14px;line-height:1;border:none;}
    .table_spravochnik_select input{padding:5px;}
    /*--------------------------------------------------------*/
    .menu_left{display: inline-block; width: 160px; vertical-align: top;}

    .btn_menu_left{  width: 100%; font-size: 14px;  background-color: rgba(255, 255, 0, 0.5);  border:2px solid rgba(0, 0, 0, 0.11);  padding:1px; line-height: 1.3;  }
    .btn_menu_left:hover{  border: 2px solid blue;  }
    /*--------------------------------------------------------*/
    .menu_top{display: inline-block; width: calc(100% - 180px); margin-left: 10px; vertical-align: top;}

    .btn_menu_top{
        width:130px; font-size: 14px; border:1px solid rgba(0, 0, 0, 0.16);
        border-radius: 4px; padding:2px; margin:5px 1px 5px 1px;
    }
    .btn_menu_top:hover{ border: 1px solid blue;}
    /*--------------------------------------------------------*/
    #menu_top_container{width:100%;}
    #menu_top_left{float:left;width:250px;}
    #menu_top_right{float:right;width:250px;}
    #menu_top_center{margin:0 auto;width:600px;}
    /*--------------------------------------------------------*/
    .sortirovka{width:70px;height:25px;padding:0 5px 0 5px;margin:5px 0 5px 0;float:left;border:2px solid transparent;font-size:12px;}
    .sortirovka{background: rgba(0, 0, 0, 0.06);}

    .sortirovka_select{width:150px;height:25px;padding:0 5px 0 5px;margin:5px 0 5px 0;float:left;border:2px solid transparent;font-size:12px;}
    .sortirovka_select{background: rgba(0, 0, 0, 0.06);}

    #btn_add{background-color: rgba(0, 255, 0, 0.3); }
    #btn_upd{background-color: rgba(255, 255, 0, 0.3); }
    #btn_del{background-color: rgba(255, 0, 0, 0.3); }

    #poisk{width: 200px;padding:0 5px 0 5px;margin:5px 0 5px 0;border:1px solid rgba(0, 0, 0, 0.5); border-radius: 4px;height: 24px;}
    /*--------------------------------------------------------*/
    #main_body{height: 700px;overflow-y: scroll;}
    /*--------------------------------------------------------*/
    .glyphicon-info-sign{color: #007fff; font-size: 14px; padding:0 1px 0 1px;}
    .glyphicon-info-sign:hover{color: #0040ff;}
    .glyphicon-minus{color: red; font-size: 14px; padding:0 1px 0 1px;}
    .glyphicon-ok{color: #00cf00; font-size: 14px; padding:0 1px 0 1px;}
</style>
<script>
    function get_row_id_in_table_spravochnik(){
        var id = 0;
        $('.table_spravochnik input:checkbox:checked').each(function () {id = $(this).val();});
        return id;
    }
    function checkbox_select_click_for_table_spravochnik(){
        var touchtime = 0, tmp;
        $(".table_spravochnik tr").click(function() {
            if (touchtime == 0) {
                touchtime = new Date().getTime();
                tmp = $(this).find('td:eq(0)').html();
                if ($('.table_spravochnik #ch' + tmp).is(':checked')) {
                    $('.table_spravochnik #ch' + tmp).prop('checked', false);
                } else {
                    $('.table_spravochnik :checkbox').prop('checked', false);
                    $('.table_spravochnik #ch' + tmp).prop('checked', true);
                }
            } else {
                if (((new Date().getTime()) - touchtime) < 300) {
                    tmp = $(this).find('td:eq(0)').html();
                    if (!$('.table_spravochnik #ch' + tmp).is(':checked')) {
                        $('.table_spravochnik :checkbox').prop('checked', false);
                        $('.table_spravochnik #ch' + tmp).prop('checked', true);
                    }
                    //----- upd
                    if(get_row_id_in_table_spravochnik()>0) table_spravochnik_select();
                    //----- upd
                } else {
                    touchtime = new Date().getTime();
                    tmp = $(this).find('td:eq(0)').html();
                    if ($('.table_spravochnik #ch' + tmp).is(':checked')) {
                        $('.table_spravochnik #ch' + tmp).prop('checked', false);
                    } else {
                        $('.table_spravochnik :checkbox').prop('checked', false);
                        $('.table_spravochnik #ch' + tmp).prop('checked', true);
                    }
                }
            }
        });
        $(".table_spravochnik :checkbox").click(function () {
            if ($(this).is(':checked')) {
                $(this).prop('checked', false);
            } else {
                $('.table_spravochnik :checkbox').prop('checked', false);
                $(this).prop('checked', true);
            }
        });
    }
    function table_spravochnik_show(table_selected=null){
        if((table_selected!=null && $('#tbl_num').val()=='') || (table_selected!=null && $('#tbl_num').val()!=table_selected)){
            $('#tbl_num').val(table_selected);
        }
        var poisk = $('#poisk').val();
        $.get("add_upd_del/admin/admin_spravochniki_show.php", {
            poisk:poisk,
            filtr_sortirovka: $('#filtr_sortirovka').val(),
            filtr_yroven_obrazov: $('#filtr_yroven_obrazov').val(),
            tbl_num: $('#tbl_num').val()
        }, function (data) {
            $('#main_body').html(data);
            checkbox_select_click_for_table_spravochnik();
            $('#filtr_yroven_obrazov').on('change',function(e){table_spravochnik_show();});
        });
    }
    function table_spravochnik_select(){
        var tbl_num = $('#tbl_num').val();
        var id = get_row_id_in_table_spravochnik();
        if(tbl_num!='') {
            $.get("add_upd_del/admin/admin_spravochniki_select.php", {
                filtr_yroven_obrazov: $('#filtr_yroven_obrazov').val(),
                tbl_num: tbl_num,
                id: id
            }, function (data) {
                $('#modal_body').html(data);
                $('#modal_window').modal('show');
                $("#testirovanie_data_begin,#testirovanie_data_end").mask("99.99.9999 99:99", {completed: function(){}});
            });
        }
    }
    function table_spravochnik_save() {
        var tbl_num = $('#tbl_num').val();
        var id = get_row_id_in_table_spravochnik();
        if(tbl_num!='') {
            var nazvanie = $('#nazvanie').val();
            var id_yroven_obrazov = $('#id_yroven_obrazov').val();
            var id_vopros = $('#id_vopros').val();
            var prav_otvet = $('#prav_otvet').val();
            var always_show = $('#always_show').val();
            var sortirovka = $('#sortirovka').val();
            var testirovanie_data_begin = $('#testirovanie_data_begin').val();
            var testirovanie_data_end = $('#testirovanie_data_end').val();
            var testirovanie_time_vsego_minyt = $('#testirovanie_time_vsego_minyt').val();
            var sobesedovanie_time_vsego_minyt = $('#sobesedovanie_time_vsego_minyt').val();
            $.get("add_upd_del/admin/admin_spravochniki_save.php", {
                tbl_num: tbl_num,
                id: id,
                nazvanie: nazvanie,
                id_yroven_obrazov: id_yroven_obrazov,
                id_vopros: id_vopros,
                prav_otvet: prav_otvet,
                always_show: always_show,
                sortirovka: sortirovka,
                testirovanie_data_begin: testirovanie_data_begin,
                testirovanie_data_end: testirovanie_data_end,
                testirovanie_time_vsego_minyt: testirovanie_time_vsego_minyt,
                sobesedovanie_time_vsego_minyt: sobesedovanie_time_vsego_minyt
            }, function (data) {
                if (data == '') {
                    $('#modal_window').modal('hide');
                } else {
                    $('.error_mssg1').html(data);
                }
            });
        }
    }
    function table_spravochnik_del(){
        var tbl_num = $('#tbl_num').val();
        var id = get_row_id_in_table_spravochnik();
        if(tbl_num!='' && id!=0) {
            if (confirm('Удалить ?')) {
                $.get("add_upd_del/admin/admin_spravochniki_del.php", {
                    tbl_num:tbl_num,
                    id:id
                }, function (data) {
                    if (data == '') {
                        table_spravochnik_show();
                    } else {
                        alert(data);
                    }
                });
            }
        }
    }
</script>
<div style="text-align: center;margin-left: 10px;margin-right: 10px;">
    <p class="titl1">Управление справочниками</p>
    <div style="width: 100%">
        <div class="menu_left">
            <button class="btn_menu_left" onclick="table_spravochnik_show(1)">Вопросы</button>
            <button class="btn_menu_left" onclick="table_spravochnik_show(2)">Варианты ответов</button>
            <button class="btn_menu_left" onclick="table_spravochnik_show(3)">Уровень образования</button>
            <button class="btn_menu_left" onclick="table_spravochnik_show(4)">Вопросы для собеседования</button>
            <button class="btn_menu_left" onclick="table_spravochnik_show(5)">Расписание</button>
        </div>
        <div class="menu_top">
            <div class="w100">
                <div id="menu_top_container">
                    <div id="menu_top_left">
                        <button type="button" class="sortirovka">Сортировка: </button>
                        <select id='filtr_sortirovka' class='sortirovka_select'>
                            <option value='0'>Дата создания</option>
                            <option value='1' selected>Название (А&#8594;Я)</option>
                        </select>
                    </div>
                    <div id="menu_top_right">
                        <input type="text" id="poisk" placeholder="поиск" autocomplete="off">
                    </div>
                    <div id="menu_top_center">
                        <button class='btn_menu_top' id='btn_add'>Добавить</button>
                        <button class='btn_menu_top' id='btn_upd'>Редактировать</button>
                        <button class='btn_menu_top' id='btn_del'>Удалить</button>
                    </div>
                </div>
            </div>
            <div class="w100" id="main_body">
                Выберите справочную таблицу слева ...
            </div>
        </div>
    </div>
    <input hidden id="tbl_num">
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
                    <button type="button" class="btn btn-primary" onclick="table_spravochnik_save()">Сохранить</button>
                    <div class="error_mssg1"></div>
                    <div class="success_mssg1"></div>
                </div>
            </div>
        </div>
    </div>
<script>
    //-------------------------------------------------------------------------------------------------------//
    $(".btn_menu_left").click(function () {
        $(".btn_menu_left").css({border: "2px solid rgba(0, 0, 0, 0.11)"});
        $(this).css({ border: "2px solid blue"});
    });
    //-------------------------------------------------------------------------------------------------------//
    $('#filtr_sortirovka').on('change',function(e){table_spravochnik_show();});
    $('#btn_add').on('click', function () {$('.table_spravochnik :checkbox').prop('checked', false);table_spravochnik_select();});
    $('#btn_upd').on('click', function () {if(get_row_id_in_table_spravochnik()!=0) table_spravochnik_select();});
    $('#btn_del').on('click', function () {table_spravochnik_del();});
    $('#poisk').on('keyup',function(e){table_spravochnik_show();});
    //-------------------------------------------------------------------------------------------------------//
    $("#modal_window").draggable();
    //-------------------------------------------------------------------------------------------------------//
    $('#modal_window').on('hidden.bs.modal', function (e) {
        $('#modal_body,.error_mssg1,.success_mssg1').html('');
        table_spravochnik_show();
    });
    //-------------------------------------------------------------------------------------------------------//
    $('#page_admin_settings, #page_admin_spravochniki').addClass('selected_page').css("color","black");
</script>
<?php
site_foot();
?>
