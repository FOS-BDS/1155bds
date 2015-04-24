/**
 * Created by Hieutrieu on 4/22/2015.
 */
var RuleModule = {
    urlApi: '/admin/',
    supplier_id: 0,
    class_name: '',
    class_form: '#role_edit_',
    class_list: '#role_list_',

    setUp: function() {
        //RuleModule.getRules();
    },
    getRules: function(myself, supplier_id, class_name, reload_only) {
        var that = this;
        that.supplier_id = supplier_id;
        that.class_name = class_name;
        $(myself).parent().find('a').removeClass('active');
        $.ajax({
            url: that.urlApi + 'rules/getRules',
            data: {supplier_id:that.supplier_id,class_name:that.class_name},
            dataType: 'html',
            type: "GET",
            beforeSend: function() {
                $(myself).addClass('active');
                $(that.class_list+that.supplier_id).prepend('<div class="loading"><i class="fa fa-2x fa-gear fa-spin"></i></div>');
                if(reload_only === undefined || !reload_only) $(that.class_form+that.supplier_id).slideUp();
            },
            success:function(result) {
                $(that.class_list+that.supplier_id).html(result);
            },
            error: function(jqXHR){
                $(that.class_list+that.supplier_id).html(jqXHR);
            }
        });
    },
    addRule: function(myself) {
        var that = this;
        $.ajax({
            url: that.urlApi + 'rules/editRule',
            data: {supplier_id:that.supplier_id,class_name:that.class_name},
            dataType: 'html',
            type: "GET",
            beforeSend: function() {
                $(myself).addClass('active');
                $(that.class_form+that.supplier_id).fadeIn();
            },
            success:function(result) {
                $(that.class_form+that.supplier_id).html(result);
            },
            error: function(jqXHR){
                $(that.class_form+that.supplier_id).html(jqXHR);
            }
        });
    },
    editRule: function(myself, _id) {
        var that = this;
        //$('#'+elementId).boxRefresh();
        $.ajax({
            url: that.urlApi + 'rules/editRule',
            data: {_id:_id,class_name:that.class_name},
            dataType: 'html',
            type: "GET",
            beforeSend: function() {
                $(myself).addClass('active');
                $(that.class_form+that.supplier_id).fadeIn();
            },
            success:function(result) {
                $(that.class_form+that.supplier_id).html(result);
            },
            error: function(jqXHR){
                $(that.class_form+that.supplier_id).html(jqXHR);
            }
        });
    },
    deleteRule: function(myself, _id) {
        var that = this;
        alert(_id);
        return false;
        $.ajax({
            url: that.urlApi + 'rules/editRule',
            data: {_id:_id,class_name:that.class_name},
            dataType: 'html',
            type: "GET",
            beforeSend: function() {
                $(myself).addClass('active');
                $(that.class_form+that.supplier_id).fadeIn();
            },
            success:function(result) {
                $(that.class_form+that.supplier_id).html(result);
            },
            error: function(jqXHR){
                $(that.class_form+that.supplier_id).html(jqXHR);
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
                that.getRules(myself,that.supplier_id,that.class_name, true)
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
