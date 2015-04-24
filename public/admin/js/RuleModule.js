/**
 * Created by Hieutrieu on 4/22/2015.
 */
var RuleModule = {
    urlApi: '/admin/',
    supplier_id: 0,
    class_name: '',

    setUp: function() {
        //RuleModule.getRules();
    },
    getRules: function(myself, supplier_id, class_name, elementId) {
        var that = this;
        that.supplier_id = supplier_id;
        that.class_name = class_name;
        $(myself).parent().find('a').removeClass('active');
        $.ajax({
            url: that.urlApi + 'rules/getRules',
            data: {supplier_id:supplier_id,class_name:class_name},
            dataType: 'html',
            type: "GET",
            beforeSend: function() {
                $(myself).addClass('active');
                $('#'+elementId).prepend('<div class="loading"><i class="fa fa-2x fa-gear fa-spin"></i></div>');
            },
            success:function(result) {
                $('#'+elementId).html(result);
            },
            error: function(jqXHR){
                $('#'+elementId).html(jqXHR);
            }
        });
    },
    addRule: function(myself, supplier_id, elementId) {
        var that = this;
        $.ajax({
            url: that.urlApi + 'rules/editRule',
            data: {supplier_id:supplier_id,class_name:that.class_name},
            dataType: 'html',
            type: "GET",
            beforeSend: function() {
                $(myself).addClass('active');
            },
            success:function(result) {
                $('#'+elementId).html(result);
            },
            error: function(jqXHR){
                $('#'+elementId).html(jqXHR);
            }
        });
    },
    editRule: function(myself, _id, elementId) {
        var that = this;
        //$('#'+elementId).boxRefresh();
        $.ajax({
            url: that.urlApi + 'rules/editRule',
            data: {_id:_id,class_name:that.class_name},
            dataType: 'html',
            type: "GET",
            beforeSend: function() {
                $(myself).addClass('active');
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
                var elementId = 'role_list_'+that.supplier_id;
                that.getRules(myself,that.supplier_id,that.class_name,elementId)
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
