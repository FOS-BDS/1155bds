@extends('admin.layouts.app')
@section('scripts')
@endsection
@section('styles')
    <?php echo Html::style('/admin/css/match.css') ?>
@endsection
@section('content')
    <div class="box box-primary box-solid widget-table">
        <div class="box-header"><h3 class="box-title">Danh sach cac tran dau</h3></div>
        <div class="box-body widget-content">
            <div id="match_list" class="table-responsive">
                <table class="table table-striped table-bordered table-hover table-responsive" sid="s1">
                    <thead class="bg-orange">
                        <tr>
                            <th rowspan="2" colspan="2" style="width:20%;max-width:20%;">
                                <h3>{{Lang::get('match.inplay')}}</h3>
                            </th>
                            <th colspan="5" class="text-center">
                                {{Lang::get('match.full_time')}}
                            </th>
                            <th colspan="5" class="text-center">
                                {{Lang::get('match.haft_time')}}
                            </th>
                            <th rowspan="2"></th>
                        </tr>
                        <tr>
                            <th class="text-center">1x2</th>
                            <th class="text-center" colspan="2">{{Lang::get('match.handicap')}}</th>
                            <th class="text-center" colspan="2">{{Lang::get('match.over_under')}}</th>
                            <th class="text-center">1x2</th>
                            <th class="text-center" colspan="2">{{Lang::get('match.handicap')}}</th>
                            <th class="text-center" colspan="2">{{Lang::get('match.over_under')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if(count($today)==0)
                        <tr>
                            <td colspan="13">{{Lang::get('match.no_match')}}</td>
                        </tr>
                    @else
                        @foreach($today as $match)
                            @foreach($match as $league_id =>$league_matchs)
                                <tr>
                                    <td colspan="13" class="bg-yellow"><span class="fl tle-txt">{{$leagues[$league_id]->name}}</span></td>
                                </tr>
                                @foreach($league_matchs as $match_info)
                                    <tr>
                                        <td class="d-t">
                                            <div class="text-center bold-text">{{$match_info->start_date}}</div>
                                            <div class="text-center bold-text">{{$match_info->time}}</div>
                                            <!--Hide Date when it is Today-->
                                        </td>
                                        <td class="evt-col r-bdr">
                                            <div>
                                                <div><span class="h_team team-better" title="Middlesbrough">{{$match_info->h_name}}</span></div>
                                                <div><span class="g_team" title="Brentford">{{$match_info->g_name}}</span></div>
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
                                                         class="text-center bold-text">{{$lastest_odd['1x2']['home']}}</div>
                                                    <div title="{{Lang::get('match.away')}}"
                                                         class="text-center bold-text">{{$lastest_odd['1x2']['away']}}</div>
                                                    <div title="{{Lang::get('match.draw')}}"
                                                         class="text-center bold-text">{{$lastest_odd['1x2']['draw']}}</div>
                                                @else
                                                    <div>&nbsp;</div>
                                                    <div>&nbsp;</div>
                                                    <div>&nbsp;</div>
                                                @endif
                                            </td>
                                            <td>
                                                @if(isset($lastest_odd['ah']))
                                                    <div class="text-center <?php if ($lastest_odd['ah']['h_draw'] < 0) echo "hide";?>">
                                                        {{$lastest_odd['ah']['draw']}}
                                                    </div>
                                                    <div class="text-center <?php if ($lastest_odd['ah']['g_draw'] <= 0) echo "hide";?>">{{$lastest_odd['ah']['draw']}}</div>
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
                                                         class="text-center bold-text">{{$lastest_odd['ah']['home']}}</div>
                                                    <div title="{{Lang::get('match.away')}}"
                                                         class="text-center bold-text">{{$lastest_odd['ah']['away']}}</div>
                                                    <div>&nbsp;</div>
                                                @else
                                                    <div>&nbsp;</div>
                                                    <div>&nbsp;</div>
                                                    <div>&nbsp;</div>
                                                @endif
                                            </td>
                                            <td>
                                                @if(isset($lastest_odd['ou']))
                                                    <div title="{{Lang::get('match.total_score')}}" class="text-center">{{$lastest_odd['ou']['draw']}}</div>
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
                                                         class="text-center bold-text">{{$lastest_odd['ou']['home']}}</div>
                                                    <div title="{{Lang::get('match.under')}}"
                                                         class="text-center bold-text">{{$lastest_odd['ou']['away']}}</div>
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
                                                         class="text-center bold-text">{{$lastest_odd['1x21st']['home']}}</div>
                                                    <div title="{{Lang::get('match.away')}}"
                                                         class="text-center bold-text">{{$lastest_odd['1x21st']['away']}}</div>
                                                    <div title="{{Lang::get('match.draw')}}"
                                                         class="text-center bold-text">{{$lastest_odd['1x21st']['draw']}}</div>
                                                @else
                                                    <div>&nbsp;</div>
                                                    <div>&nbsp;</div>
                                                    <div>&nbsp;</div>
                                                @endif
                                            </td>
                                            <td>
                                                @if(isset($lastest_odd['ah1st']))
                                                    <div class="text-center <?php if ($lastest_odd['ah1st']['h_draw'] < 0) echo "hide";?>">
                                                        {{$lastest_odd['ah1st']['draw']}}
                                                    </div>
                                                    <div class="text-center <?php if ($lastest_odd['ah1st']['g_draw'] <= 0) echo "hide";?>">{{$lastest_odd['ah1st']['draw']}}</div>
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
                                                         class="text-center bold-text">{{$lastest_odd['ah1st']['home']}}</div>
                                                    <div title="{{Lang::get('match.away')}}"
                                                         class="text-center bold-text">{{$lastest_odd['ah1st']['away']}}</div>
                                                    <div>&nbsp;</div>
                                                @else
                                                    <div>&nbsp;</div>
                                                    <div>&nbsp;</div>
                                                    <div>&nbsp;</div>
                                                @endif
                                            </td>
                                            <td>
                                                @if(isset($lastest_odd['ou1st']))
                                                    <div title="{{Lang::get('match.total_score')}}" class="text-center">{{$lastest_odd['ou1st']['draw']}}</div>
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
                                                         class="text-center bold-text">{{$lastest_odd['ou1st']['home']}}</div>
                                                    <div title="{{Lang::get('match.under')}}"
                                                         class="text-center bold-text">{{$lastest_odd['ou1st']['away']}}</div>
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
                <table class="table table-striped table-bordered table-hover table-responsive" sid="s1">
                    <thead class="bg-green">
                    <tr>
                        <th rowspan="2" colspan="2" style="width:20%;max-width:20%;"><h3>{{Lang::get('match.today')}}</h3></th>
                        <th colspan="5" class="text-center">{{Lang::get('match.full_time')}}</th>
                        <th colspan="5" class="text-center">{{Lang::get('match.haft_time')}}</th>
                        <th rowspan="2"></th>
                    </tr>
                    <tr>
                        <th class="text-center">1x2</th>
                        <th class="text-center" colspan="2">{{Lang::get('match.handicap')}}</th>
                        <th class="text-center" colspan="2">{{Lang::get('match.over_under')}}</th>
                        <th class="text-center">1x2</th>
                        <th class="text-center" colspan="2">{{Lang::get('match.handicap')}}</th>
                        <th class="text-center" colspan="2">{{Lang::get('match.over_under')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($today)==0)
                        <tr>
                            <td colspan="13">{{Lang::get('match.no_match')}}</td>
                        </tr>
                    @else

                        @foreach($today as $match)
                            @foreach($match as $league_id =>$league_matchs)
                                <tr>
                                    <td colspan="13" class="bg-lime"><span
                                                class="fl tle-txt"
                                                >{{$leagues[$league_id]->name}}</span>
                                    </td>
                                </tr>
                                @foreach($league_matchs as $match_info)
                                    <tr>
                                        <td class="d-t">
                                            <div class="text-center bold-text">{{$match_info->start_date}}</div>
                                            <div class="text-center bold-text">{{$match_info->time}}</div>
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
                                                         class="text-center bold-text">{{$lastest_odd['1x2']['home']}}</div>
                                                    <div title="{{Lang::get('match.away')}}"
                                                         class="text-center bold-text">{{$lastest_odd['1x2']['away']}}</div>
                                                    <div title="{{Lang::get('match.draw')}}"
                                                         class="text-center bold-text">{{$lastest_odd['1x2']['draw']}}</div>
                                                @else
                                                    <div>&nbsp;</div>
                                                    <div>&nbsp;</div>
                                                    <div>&nbsp;</div>
                                                @endif

                                            </td>
                                            <td>
                                                @if(isset($lastest_odd['ah']))
                                                    <div class="text-center <?php if ($lastest_odd['ah']['h_draw'] < 0) echo "hide";?>">
                                                        {{$lastest_odd['ah']['draw']}}
                                                    </div>
                                                    <div class="text-center <?php if ($lastest_odd['ah']['g_draw'] <= 0) echo "hide";?>">{{$lastest_odd['ah']['draw']}}</div>
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
                                                         class="text-center bold-text">{{$lastest_odd['ah']['home']}}</div>
                                                    <div title="{{Lang::get('match.away')}}"
                                                         class="text-center bold-text">{{$lastest_odd['ah']['away']}}</div>
                                                    <div>&nbsp;</div>
                                                @else
                                                    <div>&nbsp;</div>
                                                    <div>&nbsp;</div>
                                                    <div>&nbsp;</div>
                                                @endif
                                            </td>
                                            <td>
                                                @if(isset($lastest_odd['ou']))
                                                    <div title="{{Lang::get('match.total_score')}}" class="text-center">{{$lastest_odd['ou']['draw']}}</div>
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
                                                         class="text-center bold-text">{{$lastest_odd['ou']['home']}}</div>
                                                    <div title="{{Lang::get('match.under')}}"
                                                         class="text-center bold-text">{{$lastest_odd['ou']['away']}}</div>
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
                                                         class="text-center bold-text">{{$lastest_odd['1x21st']['home']}}</div>
                                                    <div title="{{Lang::get('match.away')}}"
                                                         class="text-center bold-text">{{$lastest_odd['1x21st']['away']}}</div>
                                                    <div title="{{Lang::get('match.draw')}}"
                                                         class="text-center bold-text">{{$lastest_odd['1x21st']['draw']}}</div>
                                                @else
                                                    <div>&nbsp;</div>
                                                    <div>&nbsp;</div>
                                                    <div>&nbsp;</div>
                                                @endif
                                            </td>
                                            <td>
                                                @if(isset($lastest_odd['ah1st']))
                                                    <div class="text-center <?php if ($lastest_odd['ah1st']['h_draw'] < 0) echo "hide";?>">
                                                        {{$lastest_odd['ah1st']['draw']}}
                                                    </div>
                                                    <div class="text-center <?php if ($lastest_odd['ah1st']['g_draw'] <= 0) echo "hide";?>">{{$lastest_odd['ah1st']['draw']}}</div>
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
                                                         class="text-center bold-text">{{$lastest_odd['ah1st']['home']}}</div>
                                                    <div title="{{Lang::get('match.away')}}"
                                                         class="text-center bold-text">{{$lastest_odd['ah1st']['away']}}</div>
                                                    <div>&nbsp;</div>
                                                @else
                                                    <div>&nbsp;</div>
                                                    <div>&nbsp;</div>
                                                    <div>&nbsp;</div>
                                                @endif
                                            </td>
                                            <td>
                                                @if(isset($lastest_odd['ou1st']))
                                                    <div title="{{Lang::get('match.total_score')}}" class="text-center">{{$lastest_odd['ou1st']['draw']}}</div>
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
                                                         class="text-center bold-text">{{$lastest_odd['ou1st']['home']}}</div>
                                                    <div title="{{Lang::get('match.under')}}"
                                                         class="text-center bold-text">{{$lastest_odd['ou1st']['away']}}</div>
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
                <table cellpadding="0" cellspacing="0" class="table table-striped table-bordered" sid="s1">
                    <thead class="bg-light-blue">
                    <tr>
                        <th rowspan="2" colspan="2" style="width:20%;max-width:20%;"><h3>{{Lang::get('match.finished')}}</h3></th>
                        <th colspan="5" style="text-align: center;">{{Lang::get('match.full_time')}}</th>
                        <th colspan="5" style="text-align: center;">{{Lang::get('match.haft_time')}}</th>
                        <th rowspan="2"></th>
                    </tr>
                    <tr>
                        <th class="text-center">1x2</th>
                        <th class="text-center" colspan="2">{{Lang::get('match.handicap')}}</th>
                        <th class="text-center" colspan="2">{{Lang::get('match.over_under')}}</th>
                        <th class="text-center">1x2</th>
                        <th class="text-center" colspan="2">{{Lang::get('match.handicap')}}</th>
                        <th class="text-center" colspan="2">{{Lang::get('match.over_under')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($today)==0)
                        <tr>
                            <td colspan="13">{{Lang::get('match.no_match')}}</td>
                        </tr>
                    @else

                        @foreach($today as $match)
                            @foreach($match as $league_id =>$league_matchs)
                                <tr>
                                    <td colspan="13" class="bg-light-blue"><span
                                                class="fl tle-txt"
                                                >{{$leagues[$league_id]->name}}</span>
                                    </td>
                                </tr>
                                @foreach($league_matchs as $match_info)
                                    <tr>
                                        <td class="d-t">
                                            <div class="text-center bold-text">{{$match_info->start_date}}</div>
                                            <div class="text-center bold-text">{{$match_info->time}}</div>
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
                                                         class="text-center bold-text">{{$lastest_odd['1x2']['home']}}</div>
                                                    <div title="{{Lang::get('match.away')}}"
                                                         class="text-center bold-text">{{$lastest_odd['1x2']['away']}}</div>
                                                    <div title="{{Lang::get('match.draw')}}"
                                                         class="text-center bold-text">{{$lastest_odd['1x2']['draw']}}</div>
                                                @else
                                                    <div>&nbsp;</div>
                                                    <div>&nbsp;</div>
                                                    <div>&nbsp;</div>
                                                @endif

                                            </td>
                                            <td>
                                                @if(isset($lastest_odd['ah']))
                                                    <div class="text-center <?php if ($lastest_odd['ah']['h_draw'] < 0) echo "hide";?>">
                                                        {{$lastest_odd['ah']['draw']}}
                                                    </div>
                                                    <div class="text-center <?php if ($lastest_odd['ah']['g_draw'] <= 0) echo "hide";?>">{{$lastest_odd['ah']['draw']}}</div>
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
                                                         class="text-center bold-text">{{$lastest_odd['ah']['home']}}</div>
                                                    <div title="{{Lang::get('match.away')}}"
                                                         class="text-center bold-text">{{$lastest_odd['ah']['away']}}</div>
                                                    <div>&nbsp;</div>
                                                @else
                                                    <div>&nbsp;</div>
                                                    <div>&nbsp;</div>
                                                    <div>&nbsp;</div>
                                                @endif
                                            </td>
                                            <td>
                                                @if(isset($lastest_odd['ou']))
                                                    <div title="{{Lang::get('match.total_score')}}" class="text-center">{{$lastest_odd['ou']['draw']}}</div>
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
                                                         class="text-center bold-text">{{$lastest_odd['ou']['home']}}</div>
                                                    <div title="{{Lang::get('match.under')}}"
                                                         class="text-center bold-text">{{$lastest_odd['ou']['away']}}</div>
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
                                                         class="text-center bold-text">{{$lastest_odd['1x21st']['home']}}</div>
                                                    <div title="{{Lang::get('match.away')}}"
                                                         class="text-center bold-text">{{$lastest_odd['1x21st']['away']}}</div>
                                                    <div title="{{Lang::get('match.draw')}}"
                                                         class="text-center bold-text">{{$lastest_odd['1x21st']['draw']}}</div>
                                                @else
                                                    <div>&nbsp;</div>
                                                    <div>&nbsp;</div>
                                                    <div>&nbsp;</div>
                                                @endif
                                            </td>
                                            <td>
                                                @if(isset($lastest_odd['ah1st']))
                                                    <div class="text-center <?php if ($lastest_odd['ah1st']['h_draw'] < 0) echo "hide";?>">
                                                        {{$lastest_odd['ah1st']['draw']}}
                                                    </div>
                                                    <div class="text-center <?php if ($lastest_odd['ah1st']['g_draw'] <= 0) echo "hide";?>">{{$lastest_odd['ah1st']['draw']}}</div>
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
                                                         class="text-center bold-text">{{$lastest_odd['ah1st']['home']}}</div>
                                                    <div title="{{Lang::get('match.away')}}"
                                                         class="text-center bold-text">{{$lastest_odd['ah1st']['away']}}</div>
                                                    <div>&nbsp;</div>
                                                @else
                                                    <div>&nbsp;</div>
                                                    <div>&nbsp;</div>
                                                    <div>&nbsp;</div>
                                                @endif
                                            </td>
                                            <td>
                                                @if(isset($lastest_odd['ou1st']))
                                                    <div title="{{Lang::get('match.total_score')}}" class="text-center">{{$lastest_odd['ou1st']['draw']}}</div>
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
                                                         class="text-center bold-text">{{$lastest_odd['ou1st']['home']}}</div>
                                                    <div title="{{Lang::get('match.under')}}"
                                                         class="text-center bold-text">{{$lastest_odd['ou1st']['away']}}</div>
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
        </div>
    </div>

@endsection