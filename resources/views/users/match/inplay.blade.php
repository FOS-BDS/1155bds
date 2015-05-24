<?php
use Illuminate\Support\Facades\URL;
$new_ids = array_keys($matched_matchs);
if (isset($_COOKIE['match_ids'])) {
    $reported_ids = $_COOKIE['match_ids'];
    $reported_ids = json_decode($reported_ids);

    $diff = array_diff($new_ids, $reported_ids);

    if (count($diff) > 0) {

        $myAudioFile = URL::to("/") . "/audio/notification.mp3";
        echo '<video controls autoplay name="media" hidden="true"><source src="' . $myAudioFile . '" type="audio/mpeg"></video>';

    }
}
setcookie('match_ids', json_encode($new_ids), time() + (86400 * 30));
?>
<table class="table table-striped table-bordered table-hover table-responsive">
    <thead class="bg-olive">
    <tr>
        <th rowspan="2" colspan="2" style="width:30%;max-width:30%;">
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
    @if(count($matchs)==0)
        <tr>
            <td colspan="13">{{Lang::get('match.no_match')}}</td>
        </tr>
    @else
        @foreach($matchs as $match)
            @foreach($match as $league_id =>$league_matchs)

                <tr>
                    <td colspan="13" class="bg-olive"><span
                                class="fl tle-txt">{{$leagues[$league_id]->name}}</span></td>
                </tr>
                @foreach($league_matchs as $match_info)
                    <?php
                            if(isset($matched_matchs[$match_info->_id->__toString()])) {
                                $row_class="background-color: #ffff00;";
                            } else {
                                $row_class="";
                            }
                    ?>
                    <tr id="{{$match_info->reference_id}}">
                        <td style="width: 30px;">
                            <div class="text-center bold-text text-green">{{$match_info->h_goal}}
                                - {{$match_info->g_goal}}</div>
                            @if($match_info->time!=-2 && $match_info->time!=-3)
                                <div class="text-center">{{$match_info->haft}}</div>
                            @endif
                            @if($match_info->time==-2)
                                <div class="text-center">HT</div>
                            @elseif($match_info->time==-3)
                                <div class="text-center">FT</div>
                            @else
                                <div class="text-center">{{intval($match_info->time)+1}}
                                    <image src="{{URL::to('/')}}/img/in.gif" border="0"/>
                                </div>
                                @endif

                                        <!--Hide Date when it is Today-->
                        </td>
                        <td class="evt-col r-bdr" style="{{$row_class}}">
                            <div>
                                <div>
                                    <span class="h_team team-better">
                                        {{$match_info->h_name}}
                                        @if($match_info->h_red>0)
                                            <img src="{{URL::to("/")}}/img/redcard{{$match_info->h_red}}.gif">
                                        @endif
                                    </span>
                                </div>
                                <div>
                                    <span class="g_team">
                                        {{$match_info->g_name}}
                                        @if($match_info->g_red>0)
                                            <img src="{{URL::to("/")}}/img/redcard{{$match_info->g_red}}.gif">
                                        @endif
                                    </span>
                                </div>
                                <div><span class="draw"
                                           title="{{Lang::get('match.draw')}}">{{Lang::get('match.draw')}}</span>
                                </div>
                            </div>
                        </td>
                        @if(isset($match_info->newest_odd) && isset($match_info->old_odd))
                            <?php
                            $lastest_odd = (array)$match_info->newest_odd;
                            $old_odd = (array)$match_info->old_odd;
                            ?>
                            <td>
                                @if(isset($lastest_odd['1x2']))
                                    <?php
                                    $indicator=\App\Libraries\StringHelper::getIndicatorClass($lastest_odd,$old_odd,'1x2')
                                    ?>
                                    <div title="{{Lang::get('match.home')}}"
                                         class="text-center bold-text {{$indicator['home']}}">
                                        {{$lastest_odd['1x2']['home']}}
                                    </div>
                                    <div title="{{Lang::get('match.away')}}"
                                         class="text-center bold-text {{$indicator['away']}}">{{$lastest_odd['1x2']['away']}}</div>
                                    <div title="{{Lang::get('match.draw')}}"
                                         class="text-center bold-text {{$indicator['draw']}}">{{$lastest_odd['1x2']['draw']}}</div>
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
                                    <?php
                                    $class=\App\Libraries\StringHelper::getIndicatorClass($lastest_odd,$old_odd,'ah')
                                    ?>
                                    <div title="{{Lang::get('match.home')}}"
                                         class="text-center bold-text {{$class['home']}}">{{$lastest_odd['ah']['home']}}</div>
                                    <div title="{{Lang::get('match.away')}}"
                                         class="text-center bold-text {{$class['away']}}">{{$lastest_odd['ah']['away']}}</div>
                                    <div>&nbsp;</div>
                                @else
                                    <div>&nbsp;</div>
                                    <div>&nbsp;</div>
                                    <div>&nbsp;</div>
                                @endif
                            </td>
                            <td>
                                @if(isset($lastest_odd['ou']))
                                    <div title="{{Lang::get('match.total_score')}}"
                                         class="text-center">{{$lastest_odd['ou']['draw']}}</div>
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
                                    <?php
                                    $class=\App\Libraries\StringHelper::getIndicatorClass($lastest_odd,$old_odd,'ou')
                                    ?>
                                    <div title="{{Lang::get('match.over')}}"
                                         class="text-center bold-text {{$class['home']}}">{{$lastest_odd['ou']['home']}}</div>
                                    <div title="{{Lang::get('match.under')}}"
                                         class="text-center bold-text {{$class['away']}}">{{$lastest_odd['ou']['away']}}</div>
                                    <div>&nbsp;</div>
                                @else
                                    <div>&nbsp;</div>
                                    <div>&nbsp;</div>
                                    <div>&nbsp;</div>
                                @endif
                            </td>
                            <td>
                                @if(isset($lastest_odd['1x21st']))
                                    <?php
                                    $class=\App\Libraries\StringHelper::getIndicatorClass($lastest_odd,$old_odd,'1x21st')
                                    ?>
                                    <div title="{{Lang::get('match.home')}}"
                                         class="text-center bold-text {{$class['home']}}">{{$lastest_odd['1x21st']['home']}}</div>
                                    <div title="{{Lang::get('match.away')}}"
                                         class="text-center bold-text {{$class['away']}}">{{$lastest_odd['1x21st']['away']}}</div>
                                    <div title="{{Lang::get('match.draw')}}"
                                         class="text-center bold-text {{$class['draw']}}">{{$lastest_odd['1x21st']['draw']}}</div>
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
                                    <?php
                                    $class=\App\Libraries\StringHelper::getIndicatorClass($lastest_odd,$old_odd,'ah1st')
                                    ?>
                                    <div title="{{Lang::get('match.home')}}"
                                         class="text-center bold-text {{$class['home']}}">{{$lastest_odd['ah1st']['home']}}</div>
                                    <div title="{{Lang::get('match.away')}}"
                                         class="text-center bold-text {{$class['away']}}">{{$lastest_odd['ah1st']['away']}}</div>
                                    <div>&nbsp;</div>
                                @else
                                    <div>&nbsp;</div>
                                    <div>&nbsp;</div>
                                    <div>&nbsp;</div>
                                @endif
                            </td>
                            <td>
                                @if(isset($lastest_odd['ou1st']))
                                    <div title="{{Lang::get('match.total_score')}}"
                                         class="text-center">{{$lastest_odd['ou1st']['draw']}}</div>
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
                                    <?php
                                    $class=\App\Libraries\StringHelper::getIndicatorClass($lastest_odd,$old_odd,'ou1st')
                                    ?>
                                    <div title="{{Lang::get('match.over')}}"
                                         class="text-center bold-text {{$class['home']}}">{{$lastest_odd['ou1st']['home']}}</div>
                                    <div title="{{Lang::get('match.under')}}"
                                         class="text-center bold-text {{$class['home']}}">{{$lastest_odd['ou1st']['away']}}</div>
                                    <div>&nbsp;</div>
                                @else
                                    <div>&nbsp;</div>
                                    <div>&nbsp;</div>
                                    <div>&nbsp;</div>
                                @endif
                            </td>
                        @endif
                        <td>
                            <a href="{{URL::to('/')}}/matchs/{{$match_info->reference_id}}/odd/fulltime"
                               target="_blank"><img src="/img/inplay.gif" height="10" width="10"
                                                    title="Odd Ca tran"></a>
                            <a href="{{URL::to('/')}}/matchs/{{$match_info->reference_id}}/odd/hafttime"
                               target="_blank"><img src="/img/today.gif" height="10" width="10"
                                                    title="Odd Hiep 1"></a>
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