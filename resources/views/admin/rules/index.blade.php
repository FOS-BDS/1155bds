@extends('app')
@section('scripts')
    <?php echo Html::script('/admin/js/RuleModule.js') ?>
    <?php echo Html::script('/admin/js/plugins/typeahead/bootstrap-typeahead.js') ?>
@endsection
@section('styles')
@endsection
@section('content')
    <div id="role_edit"></div>
    <div id="role_list" class="box box-solid box-success"></div>
@endsection