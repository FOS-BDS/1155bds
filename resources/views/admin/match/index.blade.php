@extends('admin.layouts.app')
@section('scripts')
    <script>
        var urlApi = '<?php echo URL::to('/') ?>/';

        $(document).ready(function () {
            $('#match_list').html('Loading...');
            refresh();
        });
        function refresh() {
            $.ajax({
                url: urlApi + 'users/matchs/data',
                type: "GET",
                success:function(result) {
                    $('#match_list').html(result);
                },
                error: function(jqXHR){
                    $('#match_list').html(jqXHR.responseText);
                }
            });

            setTimeout("refresh()",1000*30);
        }
    </script>
@endsection
@section('styles')
    <?php echo Html::style('/admin/css/match.css') ?>
@endsection
@section('content')
    <div class="box box-primary box-solid widget-table">
        <div class="box-header"><h3 class="box-title">{{Lang::get('match.match_list')}}</h3></div>
        <div class="box-body widget-content">
            <div id="match_list" class="table-responsive">

            </div>
        </div>
    </div>

@endsection