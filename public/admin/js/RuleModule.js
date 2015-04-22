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
            data: {supplier_id:that.supplier_id,name:className},
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
    }
};
$(function() {
    new RuleModule.setUp();
});
