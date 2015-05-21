@extends('admin.layouts.app')
@section('scripts')
    <script>
        var urlApi = '<?php echo URL::to('/') ?>/';

        $(document).ready(function () {
            $('#inplay').html('Loading...');
            $('#today').html('Loading...');
            $('#finished').html('Loading...');
            inplay();
            today();
            finished();
        });
        function inplay() {
            $.ajax({
                url: urlApi + 'matchs/data',
                data:{type:'inplay'},
                type: "GET",
                success:function(result) {
                    $('#inplay').html(result);
                },
                error: function(jqXHR){
                    $('#inplay').html(jqXHR.responseText);
                }
            });
            setTimeout("inplay()",1000*20);
        }
        function today() {
            $.ajax({
                url: urlApi + 'matchs/data',
                data:{type:'today'},
                type: "GET",
                success:function(result) {
                    $('#today').html(result);
                },
                error: function(jqXHR){
                    $('#today').html(jqXHR.responseText);
                }
            });
            setTimeout("today()",1000*120);
        }
        function finished() {
            $.ajax({
                url: urlApi + 'matchs/data',
                data:{type:'finished'},
                type: "GET",
                success:function(result) {
                    $('#finished').html(result);
                },
                error: function(jqXHR){
                    $('#finished').html(jqXHR.responseText);
                }
            });
            setTimeout("finished()",1000*300);
        }
    </script>
@endsection

@section('styles')
    <?php echo Html::style('/admin/css/match.css') ?>
@endsection
@section('content')
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li role="presentation" class="active"><a href="#inplay" data-toggle="tab">{{Lang::get('match.inplay')}}</a></li>
            <li role="presentation"><a href="#today" data-toggle="tab">{{Lang::get('match.today')}}</a></li>
            <li role="presentation"><a href="#finished" data-toggle="tab">{{Lang::get('match.finished')}}</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="inplay">

            </div>
            <div class="tab-pane" id="today">

            </div>
            <div class="tab-pane" id="finished">

            </div>
        </div>
    </div>
@endsection