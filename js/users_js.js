//------------------izmenenie URL saita-------------------//
function setUrl(){
    var regexp = /.(\?)./;
    if(!regexp.test(window.location.href)){
        var url = window.location.href.replace('?','');
        history.pushState('', '', url);
    }
}
setUrl();
//------------------izmenenie URL saita-------------------//
//------------------   errors    -------------------//
$(function(){
    $("body").on('DOMSubtreeModified', ".error_mssg1", function() {
        if($(".error_mssg1").html()=='') $(".error_mssg1").hide(); else $(".error_mssg1").show();
    });
    $("body").on('DOMSubtreeModified', ".success_mssg1", function() {
        if($(".success_mssg1").html()=='') $(".success_mssg1").hide(); else $(".success_mssg1").show();
    });
    $("body").on('DOMSubtreeModified', "#data_time_remember", function() {
        if($("#data_time_remember").html()=='') $("#data_time_remember").hide(); else $("#data_time_remember").show();
    });
});
//------------------   errors    -------------------//
//------------------   disconnect    -------------------//
function check_connect(){
    var data;
    data = $.ajax({
        type: 'GET',
        url: "../_check_for_connect.php",
        data: {value: 0},
        dataType: 'html', context: document.body, global: false, async: false,
        success: function (data) {
            return data;
        }
    }).responseText;
    if(typeof data !== "undefined") {
        if (data == 1) {
            $('#user_icon').removeClass('disconnect');
            $('#user_icon_msg').html('');
        }
        if (data == 2) {
            location.reload();
        }
    }else{
        $('#user_icon').removeClass('disconnect');
        $('#user_icon').addClass('disconnect');
        $('#user_icon_msg').html('(нет подключения) ');
    }
}
setInterval(function(){check_connect()},15000);
//------------------   disconnect    -------------------//
//----------------   autocomplate  ---------------------//
function check_autocomplate(id1,name1,tabl,column,hide) {
    var choices, suggestions, i;
    var data = $.ajax({
        type: 'GET',
        url: "add_upd_del/autocomplate.php",
        data: {tabl:tabl,column:column,hide:hide},
        dataType: 'html', context: document.body, global: false, async: false,
        success: function (data) {
            return data;
        }
    }).responseText;
    var names = data.split('@%#$!^*!');
    if (id1 != null) {
        $('#' + id1).autoComplete({
            source: function (term, suggest) {
                term = term.toLowerCase();
                choices = names;
                suggestions = [];
                for (i = 0; i < choices.length; i++)
                    if (~choices[i].toLowerCase().indexOf(term)) suggestions.push(choices[i]);
                suggest(suggestions);
            }
        });
    }
    if (name1 != null) {
        $("input[name='" + name1 + "']").autoComplete({
            source: function (term, suggest) {
                term = term.toLowerCase();
                choices = names;
                suggestions = [];
                for (i = 0; i < choices.length; i++)
                    if (~choices[i].toLowerCase().indexOf(term)) suggestions.push(choices[i]);
                suggest(suggestions);
            }
        });
    }
}
//----------------   autocomplate  ---------------------//
