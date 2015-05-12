/**
 * Created by Kudo Shinichi on 5/11/2015.
 */
var manage = {
    searchLog:function(myself){
        var apiname = $('#apiname').val();
        var message_log = $('#message_log').val();
        var type_log = $('#type_log').val();
        $.ajax({
            url:'/manages/searchLogs',
            data:{apiname:apiname,message_log:message_log,type_log:type_log},
            type:'GET',
            beforeSend:function(){
                $(myself).button('reset');
            },
            success:function(result){
                $(myself).button('reset');
                $('#tableLog').html(result);
            },
            error:function(result){
                $('#tableLog').html(result);
            }
        })
    },
    searchPage:function(myself,number_page){
        $('span').css('background-color','#9D928C');
        $('.page_'+number_page).css('background-color','red');
        $.ajax({
            url:'/manages',
            data:{page:number_page},
            type:'GET',
            beforeSend:function(){
                $('#loading').show();
            },
            success:function(result){
                $('#loading').hide();
                $('#tableLog').html(result);
            },
            error:function(result){
                $('#loading').hide();
                $('#tableLog').html(result);
            }
        })
    }
}