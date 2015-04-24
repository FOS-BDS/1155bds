<style>
    .colorpicker-element .input-group-addon i {
        display: block;
        width: 16px;
        height: 16px;
        cursor: pointer;
    }
</style>
<script>
    $(function() {
        $(".rule_color").ColorPickerSliders({
            color: '{{isset($params['rule_color'])?$params['rule_color']:'#ffffff'}}',
            hsvpanel: false,
            previewontriggerelement: true,
            placement: "auto",
            title: 'Select Color',
            sliders: false,
            previewformat: 'hex',
            size: 'sm',
            onchange: function(container, color) {
                //$('.rule_color_display').css("background-color", color.tiny.toRgbString());
            }
        });
    });
</script>

<div class="box box-primary">
    <div class="box-header">
        <h4 class="box-title panel-title">Tạo mới luật: Handicap Odd</h4>
        <div class="box-tools pull-right">
            <button class="btn btn-primary btn-xs" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-primary btn-xs" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove"><i class="fa fa-times"></i></button>
        </div>
    </div>
    {!! Form::open(array('method' => 'POST', 'role' => 'form', 'name'=>$className, 'enctype'=>'multipart/form-data')) !!}
    <div class="box-body">
        <div class="row form-group" >
            <div class="col-lg-12">
                <h4 class="form_alert alert-danger"></h4>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-lg-4">
                {!! Form::label('name', 'Đầu trận: ', array('class' => 'control-label')) !!}
                {!! Form::select('start_odd', array(1,2,3,4,5,6,7,8,9,10),isset($params['start_odd'])?$params['start_odd']:1,array('class' => 'form-control')) !!}
            </div>
            <div class="col-lg-4">
                {!! Form::label('name', '45 + HT: ', array('class' => 'control-label')) !!}
                {!! Form::select('after_odd', array(1,2,3,4,5,6,7,8,9,10),isset($params['after_odd'])?$params['after_odd']:1,array('class' => 'form-control')) !!}
            </div>
            <div class="col-lg-4">
                {!! Form::label('name', 'Báo màu:', array('class' => 'control-label')) !!}
                <div class="input-group  colorpicker-element">
                    {!! Form::text('rule_color','',array('class' => 'form-control rule_color')) !!}
                    <div class="input-group-addon">
                        <i class="fa rule_color_display" style="background-color:{{isset($params['rule_color'])?$params['rule_color']:'#ffffff'}};"></i>
                    </div>
                </div><!-- /.input group -->
            </div>
        </div>
        {!! Form::hidden('class_name',$className,array('class' => 'form-control')) !!}
        {!! Form::hidden('supplier_id',isset($params['supplier_id'])?$params['supplier_id']:1,array('class' => 'form-control')) !!}
        {!! Form::text('_id',isset($params['_id'])?$params['_id']:0,array('class' => 'form-control')) !!}
    </div>
    <div class="box-footer clearfix">
        <div class="pull-right">
            {!! Form::submit('Save', array('onclick'=>'RuleModule.save(this);return false;', 'class' => 'btn btn-sm btn-small btn-primary', 'data-loading-text' => 'Saving...')) !!}
        </div>
    </div>
    {!! Form::close() !!}
</div>