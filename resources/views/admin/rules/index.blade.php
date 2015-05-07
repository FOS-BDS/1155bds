@extends('app')
@section('scripts')
    <?php echo Html::script('/admin/js/RuleModule.js') ?>
    <?php echo Html::script('/admin/js/plugins/typeahead/bootstrap-typeahead.js') ?>
    <?php //echo Html::script('/admin/js/plugins/bootstrap-switch/bootstrap-switch.min.js') ?>
@endsection
@section('styles')
    <?php //echo Html::style('/admin/js/plugins/bootstrap-switch/bootstrap-switch.css') ?>
@endsection
@section('content')
    <div id="role_edit"></div>
    <div id="role_list" class="box box-solid box-success"></div>
@endsection