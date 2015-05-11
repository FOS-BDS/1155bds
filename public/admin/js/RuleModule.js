/**
 * Created by Hieutrieu on 4/22/2015.
 */
var RuleModule = {
    urlApi: '/admin/',
    class_form: '#role_edit',
    class_list: '#role_list',
    type: 'rule',

    setUp: function() {
        RuleModule.getRules();
    },
    getRules: function(myself, type) {
        var that = this;
        if(type != undefined) {
            that.type = type;
        }
        $(myself).parent().find('a').removeClass('active');
        $.ajax({
            url: that.urlApi + 'rules/getRules',
            data: {type:that.type},
            dataType: 'html',
            type: "GET",
            beforeSend: function() {
                $(myself).addClass('active');
                $(that.class_list).prepend('<div class="loading"><i class="fa fa-2x fa-gear fa-spin"></i></div>');
                $(that.class_form).slideUp();
            },
            success:function(result) {
                $(that.class_list).html(result);
            },
            error: function(jqXHR){
                $(that.class_list).html(jqXHR);
            }
        });
    },
    addRule: function(myself) {
        var that = this;
        $.ajax({
            url: that.urlApi + 'rules/editRule',
            data: {type:that.type},
            dataType: 'html',
            type: "GET",
            beforeSend: function() {
                $(myself).addClass('active');
                $(that.class_form).fadeIn();
            },
            success:function(result) {
                $(that.class_form).html(result);
            },
            error: function(jqXHR){
                $(that.class_form).html(jqXHR);
            }
        });
    },
    editRule: function(myself, _id) {
        var that = this;
        $.ajax({
            url: that.urlApi + 'rules/editRule',
            data: {_id:_id,type:that.type},
            dataType: 'html',
            type: "GET",
            beforeSend: function() {
                $(myself).addClass('active');
                $(that.class_form).fadeIn();
                //$(that.class_form).boxRefresh();
            },
            success:function(result) {
                $(that.class_form).html(result);
            },
            error: function(jqXHR){
                $(that.class_form).html(jqXHR);
            }
        });
    },
    deleteRule: function(myself, _id) {
        var that = this;
        $.ajax({
            url: that.urlApi + 'rules/deleteRule',
            data: {_id:_id},
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
        var form = $('#condition_form')[0]; // You need to use standart javascript object here
        var formData = new FormData(form);
        $.ajax({
            url: that.urlApi + 'rules/save?type='+that.type,
            data: formData,
            type: "POST",
            contentType: false,
            processData: false,
            beforeSend: function() {
                $(myself).button('loading');
            },
            success:function(result) {
                $(myself).button('reset');
                that.getRules(myself)
            },
            error: function(jqXHR){
                $(myself).button('reset');
            }
        });
        return false;
    }
};
$(function() {
    new RuleModule.setUp();
});
