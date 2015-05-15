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
                $(myself).button('loading');
                $('#log_table').prepend('<div class="loading"><i class="fa fa-2x fa-gear fa-spin"></i></div>');
            },
            success:function(result){
                $(myself).button('reset');
                $('#log_table').html(result);
            },
            error:function(result){
                $('#log_table').html(result);
            }
        })
    },
    deleteLogs: function(myself) {
        var that = this;
        alertify.confirm('Bạn có chắc chắn muốn xóa toàn bộ dữ liệu không?',function(confirm){
            if(confirm) {
                $.ajax({
                    url:'/admin/manages/deleteLogs',
                    data:{},
                    type:'POST',
                    beforeSend:function(){
                        $('#log_table').prepend('<div class="loading"><i class="fa fa-2x fa-gear fa-spin"></i></div>');
                    },
                    success:function(result){
                        $('#log_table').html(result);
                    },
                    error:function(result){
                        $('#log_table').find('.loading').remove();
                        alertify.error("Xóa dữ liệu bị lỗi");
                    }
                });
            } else {
                alertify.error("Đã hủy bỏ lệnh xóa dữ liệu.");
            }
        });
    }
}