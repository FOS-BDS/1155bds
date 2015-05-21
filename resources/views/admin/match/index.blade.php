@extends('admin.layouts.app')
@section('scripts')
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
        <div class="tab-content" id="match_list">
            <div class="tab-pane active" id="inplay">
                {!! View("admin.match.inplay",array('in_play'=>$in_play,'leagues'=>$leagues))->render() !!}
            </div>
            <div class="tab-pane" id="today">
                {!! View("admin.match.today",array('today'=>$today,'leagues'=>$leagues))->render() !!}
            </div>
            <div class="tab-pane" id="finished">
                {!! View("admin.match.finished",array('finished'=>$finished,'leagues'=>$leagues))->render() !!}
            </div>
        </div>
    </div>
@endsection