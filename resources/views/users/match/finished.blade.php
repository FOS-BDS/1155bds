<table class="table table-striped table-bordered table-hover table-responsive">
    <thead class="bg-orange">
    <tr>
        <th rowspan="2" colspan="2" style="width:30%;max-width:30%;">
            <h3>{{Lang::get('match.finished')}}</h3></th>
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
    @if(count($matchs)==0)
        <tr>
            <td colspan="13">{{Lang::get('match.no_match')}}</td>
        </tr>
    @else

        @foreach($matchs as $match)
            @foreach($match as $league_id =>$league_matchs)
                <tr>
                    <td colspan="13" class="bg-orange"><span
                                class="fl tle-txt"
                                >{{$leagues[$league_id]->name}}</span>
                    </td>
                </tr>
                @foreach($league_matchs as $match_info)
                    <tr id="{{$match_info->reference_id}}">
                        <td style="width: 30px;">
                            <div class="text-center bold-text text-green">{{$match_info->h_goal}}
                                - {{$match_info->g_goal}}</div>
                            <div class="text-center">FT</div>
                            <!--Hide Date when it is Today-->
                        </td>
                        <td class="evt-col r-bdr">
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
                        <td>

                            <div>&nbsp;</div>
                            <div>&nbsp;</div>
                            <div>&nbsp;</div>

                        </td>
                        <td>

                            <div>&nbsp;</div>
                            <div>&nbsp;</div>
                            <div>&nbsp;</div>

                        </td>
                        <td>

                            <div>&nbsp;</div>
                            <div>&nbsp;</div>
                            <div>&nbsp;</div>

                        </td>
                        <td>

                            <div>&nbsp;</div>
                            <div>&nbsp;</div>
                            <div>&nbsp;</div>

                        </td>
                        <td>

                            <div>&nbsp;</div>
                            <div>&nbsp;</div>
                            <div>&nbsp;</div>

                        </td>
                        <td>

                            <div>&nbsp;</div>
                            <div>&nbsp;</div>
                            <div>&nbsp;</div>

                        </td>
                        <td>

                            <div>&nbsp;</div>
                            <div>&nbsp;</div>
                            <div>&nbsp;</div>

                        </td>
                        <td>

                            <div>&nbsp;</div>
                            <div>&nbsp;</div>
                            <div>&nbsp;</div>

                        </td>
                        <td>

                            <div>&nbsp;</div>
                            <div>&nbsp;</div>
                            <div>&nbsp;</div>

                        </td>
                        <td>

                            <div>&nbsp;</div>
                            <div>&nbsp;</div>
                            <div>&nbsp;</div>

                        </td>

                        <td>
                            <a href="{{URL::to('/')}}/matchs/{{$match_info->reference_id}}/odd/fulltime" target="_blank"><img src="/img/inplay.gif" height="10" width="10" title="Odd Ca tran"></a>
                            <a href="{{URL::to('/')}}/matchs/{{$match_info->reference_id}}/odd/hafttime" target="_blank"><img src="/img/today.gif" height="10" width="10" title="Odd Hiep 1"></a>
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
