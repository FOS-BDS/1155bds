@extends('app')
@section('scripts')
    <?php echo Html::script('/admin/js/RuleModule.js') ?>
    <?php echo Html::script('/admin/js/plugins/magicsuggest/magicsuggest-min.js') ?>
    <?php echo Html::script('/admin/js/plugins/validate/formValidation.min.js') ?>
    <?php echo Html::script('/admin/js/plugins/validate/bootstrapvalidate.min.js') ?>
@endsection
@section('styles')
    <?php echo Html::style('/admin/js/plugins/validate/formValidation.min.css') ?>
    <?php echo Html::style('/admin/js/plugins/magicsuggest/magicsuggest-min.css') ?>
@endsection
@section('content')
    <div id="role_edit"></div>
    <div id="role_list"></div>
@endsection