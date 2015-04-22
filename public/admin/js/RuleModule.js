/**
 * Created by Hieutrieu on 4/22/2015.
 */
var RuleModule = {
    urlApi: '/admin/',
    supplier_id: 0,

    setUp: function() {
        //RuleModule.getRules();
    },
    getRules: function(myself, supplier_id, className, elementId) {
        var that = this;
        //$(that.show_error).empty();
        $.ajax({
            url: that.urlApi + 'rules/getRules',
            data: {supplier_id:that.supplier_id,class_name:className},
            dataType: 'html',
            type: "GET",
            beforeSend: function() {
            },
            success:function(result) {
                $('#'+elementId).html(result);
            },
            error: function(jqXHR){
                $('#'+elementId).html(jqXHR);
            }
        });
    },
    save: function(myself) {
        var that = this;
        var form = $(myself).parent().parent().parent()[0]; // You need to use standart javascript object here
        var formData = new FormData(form);
        console.log(form);
        $.ajax({
            url: that.urlApi + 'rules/save',
            data: formData,
            type: "POST",
            contentType: false,
            processData: false,
            beforeSend: function() {
                $(myself).button('loading');
            },
            success:function(result) {
                $(myself).button('reset');
            },
            error: function(jqXHR){
                $(myself).button('reset');
            }
        });
    }
};
$(function() {
    new RuleModule.setUp();
});
