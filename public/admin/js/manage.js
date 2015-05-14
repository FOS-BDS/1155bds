/**
 * Created by Kudo Shinichi on 5/11/2015.
 */
var manage = {
    searchLog:function(myself, number_page){
        $(myself).addClass('active');
        if(number_page === undefined) {
            number_page = 1;
        }
        var apiname = $('#apiname').val();
        var message_log = $('#message_log').val();
        var type_log = $('#type_log').val();
        $.ajax({
            url:'/admin/manages/searchLogs',
            data:{apiname:apiname,message_log:message_log,type_log:type_log,page:number_page},
            type:'GET',
            beforeSend:function(){
                $(myself).button('reset');
            },
            success:function(result){
                $(myself).button('reset');
                $('#log_table').html(result);
            },
            error:function(result){
                $('#log_table').html(result);
            }
        })
    }
}