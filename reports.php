<?php
require_once("_functions.php");
require_once("_check_for_admin.php");
site_head();
?>
<style>
    .titl1{font-size:18px;margin:0;padding:0;text-align: center;}
    .btn1{width:200px;cursor:pointer;height:20px;padding:0;margin:0;border-radius:0 0 0 0;text-align:center;}
    #report_div {text-align: left;}
    #vid_otcheta{height: 24px;border-radius: 3px;}
    /* ---------------------------------------------------- */
    #tbl_filtrs1{width: auto;}
    #tbl_filtrs1 td{padding:0; margin:0; font-size: 14px; border: 1px solid rgb(195, 195, 195);}
    #tbl_filtrs1 td:nth-child(1){width: 90px;border-left: none;border-right: none;}
    #tbl_filtrs1 td:nth-child(2){width: 150px;}
    #tbl_filtrs1 td:nth-child(3){width: 90px;border-left: none;border-right: none;}
    #tbl_filtrs1 td:nth-child(4){width: 150px;}
    #tbl_filtrs1 td label{font-weight: 400;padding:0;margin:0;}
    #tbl_filtrs1 td:nth-child(1):hover{background-color: rgba(0, 255, 0, 0.1);}
    #tbl_filtrs1 td:nth-child(3):hover{background-color: rgba(0, 255, 0, 0.1);}
    .select2-container .select2-selection--multiple {min-height: 20px;}
    /* ---------------------------------------------------- */
    #tabl_report1{width:100%;font-size: 14px;line-height: 1.1;}
    #tabl_report1 th{padding:1px 3px;margin:0;text-align:center;border:1px solid rgb(195, 195, 195);background-color:#e6e6e6;}
    #tabl_report1 tr:hover {background-color: rgba(0, 255, 0, 0.16);}
    #tabl_report1 td{padding:2px 5px;margin:0;text-align:center;border:1px solid rgb(195, 195, 195);}
    /* ---------------------------------------------------- */
    /* ---------------------------------------------------- */
    #tabl_report2{width:100%;font-size: 14px;line-height: 1.1;}
    #tabl_report2 th{padding:1px 3px;margin:0;text-align:center;border:1px solid rgb(195, 195, 195);background-color:#e6e6e6;}
    #tabl_report2 tr:hover {background-color: rgba(0, 255, 0, 0.16);}
    #tabl_report2 td{padding:1px 5px;margin:0;text-align:center;border:1px solid rgb(195, 195, 195);}
    /* ---------------------------------------------------- */
    /* ---------------------------------------------------- */
    #tabl_report3{width:100%;font-size: 14px;line-height: 1.1;}
    #tabl_report3 th{padding:1px 3px;margin:0;text-align:center;border:1px solid rgb(195, 195, 195);background-color:#e6e6e6;}
    #tabl_report3 tr:hover {background-color: rgba(0, 255, 0, 0.16);}
    #tabl_report3 td{padding:1px 5px;margin:0;text-align:center;border:1px solid rgb(195, 195, 195);}
    /* ---------------------------------------------------- */
    /* ---------------------------------------------------- */
    .select2-container{  height:26px;  }
    .select2-container .select2-selection--multiple {  min-height: 0;  height:26px;  }
    .select2-container .select2-search--inline .select2-search__field {  margin-top: 3px;  }
    .select2-container--default .select2-selection--multiple .select2-selection__rendered {  padding: 0 2px;  }
    .select2-container--default .select2-selection--multiple .select2-selection__choice {  margin-top: 2px;  }
    .select2-container--default .select2-selection--multiple .select2-selection__clear {  margin-top: 2px;  }
    /* ---------------------------------------------------- */
    .table_spisok_details {padding:0;margin:0;border:none;}
    .table_spisok_details summary::-webkit-details-marker{display: none;}

    .table_spisok{width:100%;font-size: 14px;line-height: 1;}
    .table_spisok tr:hover {background-color: rgba(0, 255, 0, 0.16);}
    .table_spisok td{padding:1px 5px;margin:0;text-align:center;border:1px solid rgb(223, 223, 223);}
    /* ---------------------------------------------------- */
</style>
<script>
    function show_report() {
        var year_c = $("#year_c").val();
        var year_po = $("#year_po").val();
        var month_c = $("#month_c").val();
        var month_po = $("#month_po").val();
        var vid_otcheta = $("#vid_otcheta").val();
        $("#report_div").html('Загрузка ...');
        $.get("reports/admin_report_"+vid_otcheta+".php", {
            year_c:year_c,
            year_po:year_po,
            month_c:month_c,
            month_po:month_po,
            vid_otcheta:vid_otcheta
        }, function (data) {
            $("#report_div").html(data);
        });
    }
</script>
<div style="text-align: center;margin-left: 20px;margin-right: 20px">
    <p class="titl1">Отчёты по проверкам организаций</p>
    <details open>
        <summary>Фильтры</summary>
        <table align="center" id="tbl_filtrs1">
            <tr>
                <td>
                    <label for="year_c">&#160;&#160;&#160;Год (с)</label>
                </td>
                <td>
                    <select class='w100' id="year_c" multiple='multiple'>
                        <option value='2021'>2021</option>
                    </select>
                </td>
                <td>
                    <label for="year_po">&#160;&#160;&#160;Год (по)</label>
                </td>
                <td>
                    <select class='w100' id="year_po" multiple='multiple'>
                        <option value='2021'>2021</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="month_c">&#160;&#160;&#160;Месяц (с)</label>
                </td>
                <td>
                    <select class='w100' id="month_c" multiple='multiple'>
                        <option value='1'>1 - Январь</option>
                        <option value='2'>2 - Февраль</option>
                        <option value='3'>3 - Март</option>
                        <option value='4'>4 - Апрель</option>
                        <option value='5'>5 - Май</option>
                        <option value='6'>6 - Июнь</option>
                        <option value='7'>7 - Июль</option>
                        <option value='8'>8 - Август</option>
                        <option value='9'>9 - Сентябрь</option>
                        <option value='10'>10 - Октябрь</option>
                        <option value='11'>11 - Ноябрь</option>
                        <option value='12'>12 - Декабрь</option>
                    </select>
                </td>
                <td>
                    <label for="month_po">&#160;&#160;&#160;Месяц (по)</label>
                </td>
                <td>
                    <select class='w100' id="month_po" multiple='multiple'>
                        <option value='1'>1 - Январь</option>
                        <option value='2'>2 - Февраль</option>
                        <option value='3'>3 - Март</option>
                        <option value='4'>4 - Апрель</option>
                        <option value='5'>5 - Май</option>
                        <option value='6'>6 - Июнь</option>
                        <option value='7'>7 - Июль</option>
                        <option value='8'>8 - Август</option>
                        <option value='9'>9 - Сентябрь</option>
                        <option value='10'>10 - Октябрь</option>
                        <option value='11'>11 - Ноябрь</option>
                        <option value='12'>12 - Декабрь</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <br>
                    <label for="vid_otcheta"><b>Вид отчёта</b></label>
                    <select class='w100' id="vid_otcheta">
                        <option value='1' selected>1) Эксперты (сводная)</option>
                        <option value='2'>2) Производительность экспертов</option>
                        <option value='3'>3) Карта эксперта</option>
                    </select>
                </td>
            </tr>
        </table>
    </details>
    <button type="button" class="btn btn-primary btn1" onclick="show_report()">Сформировать</button>
    <div id="report_div">
        ...
    </div>
    <br>
</div>
<form hidden method="get" id="form_xls">
    <input id='year_c_xls' name='year_c_xls'>
    <input id='year_po_xls' name='year_po_xls'>
    <input id='month_c_xls' name='month_c_xls'>
    <input id='month_po_xls' name='month_po_xls'>
    <input id='vid_otcheta_xls' name='vid_otcheta_xls'>
</form>
<script>
    $("#year_c, #year_po, #month_c, #month_po").select2({placeholder: "Все",allowClear:true,maximumSelectionLength: 1});
    //-----------------------------------------------------------------------------------------------//
    function xls(tmp='') {
        var vid_otcheta = $("#vid_otcheta").val();
        if(tmp!='') vid_otcheta=vid_otcheta+tmp;

        $("#year_c_xls").val($("#year_c").val());
        $("#year_po_xls").val($("#year_po").val());
        $("#month_c_xls").val($("#month_c").val());
        $("#month_po_xls").val($("#month_po").val());

        $("#form_xls").attr('action', 'reports/admin_report_' + vid_otcheta + '_xls.php');
        $("#vid_otcheta_xls").val($("#vid_otcheta").val());
        $("#vid_otcheta_xls").attr('type', 'submit');
        $("#vid_otcheta_xls").click();
    }
    //-----------------------------------------------------------------------------------------------//
    $('#page_reports').addClass('selected_page');
    $('#page_reports').css("color","black");
</script>
<?php
    site_foot();
?>