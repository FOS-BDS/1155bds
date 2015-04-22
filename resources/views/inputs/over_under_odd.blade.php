<div class="panel panel-info">
    <div class="panel-heading">Tạo mới luật: Handicap Odd</div>
    {!! Form::open(array('method' => 'POST', 'role' => 'form', 'name'=>$className, 'enctype'=>'multipart/form-data')) !!}
        <div class="panel-body">
            <div class="row form-group" >
                <div class="col-lg-12">
                    <h4 class="form_alert alert-danger"></h4>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-lg-3">
                    {!! Form::label('name', 'Đầu trận: ', array('class' => 'control-label')) !!}
                    {!! Form::select('start_odd', array(1,2,3,4,5,6,7,8,9,10),array('class' => 'form-control')) !!}
                </div>
                <div class="col-lg-3">
                    {!! Form::label('name', '45 + HT: ', array('class' => 'control-label')) !!}
                    {!! Form::select('after_odd', array(1,2,3,4,5,6,7,8,9,10),array('class' => 'form-control')) !!}
                </div>
                <div class="col-lg-3">
                    {!! Form::label('name', 'Báo màu:', array('class' => 'control-label')) !!}
                    {!! Form::select('rule_color', array(1,2,3,4,5,6,7,8,9,10),array('class' => 'form-control')) !!}
                </div>
            </div>
            {!! Form::hidden('class_name',$className,array('class' => 'form-control')) !!}
        </div>
    <div class="panel-footer clearfix">
        <div class="pull-right">
            {!! Form::submit('Save', array('onclick'=>'RuleModule.save(this);return false;', 'class' => 'btn btn-sm btn-small btn-primary', 'data-loading-text' => 'Saving...')) !!}
        </div>
    </div>
    {!! Form::close() !!}
</div>