@extends('admin.layouts.app')
@section('scripts')
@endsection
@section('styles')
    <?php echo Html::style('/admin/css/match.css') ?>
@endsection
@section('content')
    <div class="box box-primary box-solid widget-table">
        <div>
            <h3 style="width: 100%; text-align: center; color: blue">{{$match->h_name}} - {{$match->g_name}} ({{$type_title}})</h3>
            <h4 style="width: 100%; text-align: center; color: #000000">{{$league->name}}</h4>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <div class="panel panel-primary">
                    <div class="panel-heading">Crown 1X2 Odds</div>
                    <div class="panel-body">
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr class="active" style="background-color: #2a6496;">
                                <td style="text-align: center;">Time</td>
                                <td style="text-align: center;">Score</td>
                                <td style="text-align: center;">Home </td>
                                <td style="text-align: center;">Draw</td>
                                <td style="text-align: center;">Away</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($first_odd as $item)
                                <?php
                                        $item=(object)$item;
                                $time="-";
                                $score="-";
                                $home="<font color=green>Closed</font>";
                                $draw="<font color=green>Closed</font>";
                                $alway="<font color=green>Closed</font>";
                                if($item->time>=0) {
                                    $time=$item->time;
                                    $score=$item->h_goal." - ".$item->g_goal;
                                } elseif($item->time==-2) {
                                    $time="<font color=blue>HT</font>";
                                    $score=$item->h_goal." - ".$item->g_goal;
                                } elseif ($item->time==-3) {
                                    $time="<font color=blue>FT</font>";
                                    $score=$item->h_goal." - ".$item->g_goal;
                                }

                                if($item->home!=-999) {
                                    $home=$item->home;
                                }
                                if($item->draw!=-999) {
                                    $draw=$item->draw;
                                }
                                if($item->away!=-999) {
                                    $alway=$item->away;
                                }
                                ?>
                                <td style="text-align: center; color: blue">{{$time}}</td>
                                <td style="text-align: center; color: green" >{{$score}}</td>
                                <td style="text-align: center;">{{$home}}</td>
                                <td style="text-align: center; color: red">{{$draw}}</td>
                                <td style="text-align: center;">{{$alway}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <div class="panel panel-primary">
                    <div class="panel-heading">Crown Handicap Odds</div>
                    <div class="panel-body">
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr class="active" style="background-color: #2a6496;">
                                <td style="text-align: center;">Time</td>
                                <td style="text-align: center;">Score </td>
                                <td style="text-align: center;">Home</td>
                                <td style="text-align: center;">Handicap</td>
                                <td style="text-align: center;">Away</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($second_odd as $item)
                                <?php
                                $item=(object)$item;
                                $time="-";
                                $score="-";
                                $home="<font color=green>Closed</font>";
                                $draw="<font color=green>Closed</font>";
                                $alway="<font color=green>Closed</font>";
                                if($item->time>=0) {
                                    $time=$item->time;
                                    $score=$item->h_goal." - ".$item->g_goal;
                                } elseif($item->time==-2) {
                                    $time="<font color=blue>HT</font>";
                                    $score=$item->h_goal." - ".$item->g_goal;
                                } elseif ($item->time==-3) {
                                    $time="<font color=blue>FT</font>";
                                    $score=$item->h_goal." - ".$item->g_goal;
                                }

                                if($item->home!=-999) {
                                    $home=$item->home;
                                }
                                if($item->draw!=-999) {
                                    $draw=$item->draw;
                                }
                                if($item->away!=-999) {
                                    $alway=$item->away;
                                }
                                ?>
                                <td style="text-align: center; color: blue">{{$time}}</td>
                                <td style="text-align: center; color: green" >{{$score}}</td>
                                <td style="text-align: center;">{{$home}}</td>
                                <td style="text-align: center; color: red">{{$draw}}</td>
                                <td style="text-align: center;">{{$alway}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <div class="panel panel-primary">
                    <div class="panel-heading">Crown Over/Under Odds</div>
                    <div class="panel-body">
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr class="active" style="background-color: #2a6496;">
                                <td style="text-align: center;">Time</td>
                                <td style="text-align: center;">Score </td>
                                <td style="text-align: center;">Over </td>
                                <td style="text-align: center;">O/U</td>
                                <td style="text-align: center;">Under </td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($third_odd as $item)
                                <?php
                                $item=(object)$item;
                                $time="-";
                                $score="-";
                                $home="<font color=green>Closed</font>";
                                $draw="<font color=green>Closed</font>";
                                $alway="<font color=green>Closed</font>";
                                if($item->time>=0) {
                                    $time=$item->time;
                                    $score=$item->h_goal." - ".$item->g_goal;
                                } elseif($item->time==-2) {
                                    $time="<font color=blue>HT</font>";
                                    $score=$item->h_goal." - ".$item->g_goal;
                                } elseif ($item->time==-3) {
                                    $time="<font color=blue>FT</font>";
                                    $score=$item->h_goal." - ".$item->g_goal;
                                }

                                if($item->home!=-999) {
                                    $home=$item->home;
                                }
                                if($item->draw!=-999) {
                                    $draw=$item->draw;
                                }
                                if($item->away!=-999) {
                                    $alway=$item->away;
                                }
                                ?>
                                <td style="text-align: center; color: blue">{{$time}}</td>
                                <td style="text-align: center; color: green" >{{$score}}</td>
                                <td style="text-align: center;">{{$home}}</td>
                                <td style="text-align: center; color: red">{{$draw}}</td>
                                <td style="text-align: center;">{{$alway}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection