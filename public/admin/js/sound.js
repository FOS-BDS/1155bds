/**
 * Created by Kudo Shinichi on 5/20/2015.
 */
var Sound = {
    addSound:function(myself){
        that = this;
        var form = $('#formInsertSound')[0];
        formdata = new FormData(form);
        $.ajax({
            url:'/sounds/insert',
            data:formdata,
            type:'POST',
            contentType:false,
            processData:false,
            beforeSend:function(){
                $(myself).button('loading');
            },
            success:function(result){
                $(myself).button('reset');
                $('#modalInsertSound').modal('hide');
                that.loadSounds();
                console.log(result);
            },
            error:function(result){
                $(myself).button('reset');
                console.log(result);
            }
        })
    },
    loadSounds:function(){
        $.ajax({
            url:'/sounds/allSounds',
            data:'',
            type:'GET',
            success:function(result){
                $('#soundList').html(result);
            },
            error:function(result){
                $('#soundList').html(result);
            }
        })
    },
    cancelProcess:function(formId,modalId){
        $(formId)[0].reset();
        $(modalId).modal('hide');
    }
}