@extends('admin.layouts.app')
@section('scripts')
    <?php echo Html::script('/admin/js/plugins/magicsuggest/magicsuggest-min.js') ?>
    <?php echo Html::script('/admin/js/plugins/validate/formValidation.min.js') ?>
    <?php echo Html::script('/admin/js/plugins/validate/bootstrapvalidate.min.js') ?>
    <?php echo Html::script('/admin/js/plugins/tinycolor/tinycolor.min.js') ?>
    <?php echo Html::script('/admin/js/plugins/colorpicker-slider/bootstrap.colorpickersliders.js') ?>
@endsection
@section('styles')
    <?php echo Html::style('/admin/css/match.css') ?>
    <?php echo Html::style('/admin/js/plugins/validate/formValidation.min.css') ?>
    <?php echo Html::style('/admin/js/plugins/magicsuggest/magicsuggest-min.css') ?>
    <?php echo Html::style('/admin/js/plugins/colorpicker-slider/bootstrap.colorpickersliders.css') ?>
@endsection
@section('content')
    <div id="match_list" class="table-responsive">
        <table cellpadding="0" cellspacing="0" class="table table-striped table-bordered" sid="s1">
            <thead class="o-time">
            <tr>
                <th rowspan="2" class="n-inplay-title clear-l-bdr" colspan="2"><h3>{{Lang::get('match.today')}}</h3></th>
                <th colspan="5" style="text-align: center;">{{Lang::get('match.full_time')}}</th>
                <th colspan="5" style="text-align: center;">{{Lang::get('match.haft_time')}}</th>
                <th rowspan="2"></th>
            </tr>
            <tr class="top-bdr">
                <th>1x2</th>
                <th colspan="2">{{Lang::get('match.handicap')}}</th>
                <th colspan="2">{{Lang::get('match.over_under')}}</th>
                <th>1x2</th>
                <th colspan="2">{{Lang::get('match.handicap')}}</th>
                <th colspan="2">{{Lang::get('match.over_under')}}</th>
            </tr>
            </thead>
            <tbody>
            @if(count($matchs)==0)
                <tr>
                    <td colspan="13">{{Lang::get('match.no_match')}}</td>
                </tr>
            @else

                @foreach($matchs as $match)
                    @foreach($match as $league_id =>$league_matchs)
                        <tr>
                            <td colspan="13" class="comp-title"><span
                                        class="fl tle-txt"
                                        >{{$leagues[$league_id]->name}}</span>
                            </td>
                        </tr>
                        @foreach($league_matchs as $match_info)
                            <tr>
                                <td class="d-t">
                                    <div class="bold-text">{{$match_info->start_date}}</div>
                                    <div class="bold-text">{{$match_info->time}}</div>
                                    <!--Hide Date when it is Today-->
                                </td>
                                <td class="evt-col r-bdr">
                                    <div>
                                        <div><span class="h_team team-better"
                                                   title="Middlesbrough">{{$match_info->h_name}}</span>
                                        </div>
                                        <div><span class="g_team"
                                                   title="Brentford">{{$match_info->g_name}}</span>
                                        </div>
                                        <div><span class="draw" title="{{Lang::get('match.draw')}}">{{Lang::get('match.draw')}}</span></div>
                                    </div>
                                </td>
                                @if(isset($match_info->lastest_odd))
                                    <?php
                                    $lastest_odd = (array)$match_info->lastest_odd;
                                    ?>
                                    <td>

                                        @if(isset($lastest_odd['1x2']))
                                            <div title="{{Lang::get('match.home')}}"
                                                 class="bold-text">{{$lastest_odd['1x2']['home']}}</div>
                                            <div title="{{Lang::get('match.away')}}"
                                                 class="bold-text">{{$lastest_odd['1x2']['away']}}</div>
                                            <div title="{{Lang::get('match.draw')}}"
                                                 class="bold-text">{{$lastest_odd['1x2']['draw']}}</div>
                                        @else
                                            <div>&nbsp;</div>
                                            <div>&nbsp;</div>
                                            <div>&nbsp;</div>
                                        @endif

                                    </td>
                                    <td>
                                        @if(isset($lastest_odd['ah']))
                                            <div class="<?php if ($lastest_odd['ah']['h_draw'] < 0) echo "hide";?>">
                                                {{$lastest_odd['ah']['draw']}}
                                            </div>
                                            <div class="<?php if ($lastest_odd['ah']['g_draw'] <= 0) echo "hide";?>">{{$lastest_odd['ah']['draw']}}</div>
                                            <div>&nbsp;</div>
                                        @else
                                            <div>&nbsp;</div>
                                            <div>&nbsp;</div>
                                            <div>&nbsp;</div>
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($lastest_odd['ah']))
                                            <div title="{{Lang::get('match.home')}}"
                                                 class="bold-text">{{$lastest_odd['ah']['home']}}</div>
                                            <div title="{{Lang::get('match.away')}}"
                                                 class="bold-text">{{$lastest_odd['ah']['away']}}</div>
                                            <div>&nbsp;</div>
                                        @else
                                            <div>&nbsp;</div>
                                            <div>&nbsp;</div>
                                            <div>&nbsp;</div>
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($lastest_odd['ou']))
                                            <div title="{{Lang::get('match.total_score')}}">{{$lastest_odd['ou']['draw']}}</div>
                                            <div title="{{Lang::get('match.total_score')}}"
                                                 class="hide">{{$lastest_odd['ou']['draw']}}</div>
                                            <div>&nbsp;</div>
                                        @else
                                            <div>&nbsp;</div>
                                            <div>&nbsp;</div>
                                            <div>&nbsp;</div>
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($lastest_odd['ou']))
                                            <div title="{{Lang::get('match.over')}}"
                                                 class="bold-text">{{$lastest_odd['ou']['home']}}</div>
                                            <div title="{{Lang::get('match.under')}}"
                                                 class="bold-text">{{$lastest_odd['ou']['away']}}</div>
                                            <div>&nbsp;</div>
                                        @else
                                            <div>&nbsp;</div>
                                            <div>&nbsp;</div>
                                            <div>&nbsp;</div>
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($lastest_odd['1x21st']))
                                            <div title="{{Lang::get('match.home')}}"
                                                 class="bold-text">{{$lastest_odd['1x21st']['home']}}</div>
                                            <div title="{{Lang::get('match.away')}}"
                                                 class="bold-text">{{$lastest_odd['1x21st']['away']}}</div>
                                            <div title="{{Lang::get('match.draw')}}"
                                                 class="bold-text">{{$lastest_odd['1x21st']['draw']}}</div>
                                        @else
                                            <div>&nbsp;</div>
                                            <div>&nbsp;</div>
                                            <div>&nbsp;</div>
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($lastest_odd['ah1st']))
                                            <div class="<?php if ($lastest_odd['ah1st']['h_draw'] < 0) echo "hide";?>">
                                                {{$lastest_odd['ah1st']['draw']}}
                                            </div>
                                            <div class="<?php if ($lastest_odd['ah1st']['g_draw'] <= 0) echo "hide";?>">{{$lastest_odd['ah1st']['draw']}}</div>
                                            <div>&nbsp;</div>
                                        @else
                                            <div>&nbsp;</div>
                                            <div>&nbsp;</div>
                                            <div>&nbsp;</div>
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($lastest_odd['ah1st']))
                                            <div title="{{Lang::get('match.home')}}"
                                                 class="bold-text">{{$lastest_odd['ah1st']['home']}}</div>
                                            <div title="{{Lang::get('match.away')}}"
                                                 class="bold-text">{{$lastest_odd['ah1st']['away']}}</div>
                                            <div>&nbsp;</div>
                                        @else
                                            <div>&nbsp;</div>
                                            <div>&nbsp;</div>
                                            <div>&nbsp;</div>
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($lastest_odd['ou1st']))
                                            <div title="{{Lang::get('match.total_score')}}">{{$lastest_odd['ou1st']['draw']}}</div>
                                            <div title="{{Lang::get('match.total_score')}}"
                                                 class="hide">{{$lastest_odd['ou1st']['draw']}}</div>
                                            <div>&nbsp;</div>
                                        @else
                                            <div>&nbsp;</div>
                                            <div>&nbsp;</div>
                                            <div>&nbsp;</div>
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($lastest_odd['ou1st']))
                                            <div title="{{Lang::get('match.over')}}"
                                                 class="bold-text">{{$lastest_odd['ou1st']['home']}}</div>
                                            <div title="{{Lang::get('match.under')}}"
                                                 class="bold-text">{{$lastest_odd['ou1st']['away']}}</div>
                                            <div>&nbsp;</div>
                                        @else
                                            <div>&nbsp;</div>
                                            <div>&nbsp;</div>
                                            <div>&nbsp;</div>
                                        @endif
                                    </td>
                                @endif
                                <td>
                                    Tools
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                @endforeach
                <tr>
                    <td colspan="13"></td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>

@endsection