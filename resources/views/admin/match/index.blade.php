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
                <th rowspan="2" class="n-inplay-title clear-l-bdr" colspan="2"><h3>Hôm Nay</h3></th>
                <th colspan="5" style="text-align: center;">Cả Trận</th>
                <th colspan="5" style="text-align: center;">Hiệp 1</th>
                <th rowspan="2"></th>
            </tr>
            <tr class="top-bdr">
                <th>1x2</th>
                <th colspan="2">Cược Chấp</th>
                <th colspan="2">Trên / Dưới</th>
                <th>1x2</th>
                <th colspan="2">Cược Chấp</th>
                <th colspan="2">Trên / Dưới</th>
            </tr>
            </thead>
            <tbody>
            @if(count($matchs)==0)
                <tr>
                    <td colspan="13">{{"khong co tran dau nao!"}}</td>
                </tr>
            @else

                @foreach($matchs as $match)
                    @foreach($match as $league_id =>$league_matchs)
                        <tr>
                            <td colspan="13" class="comp-title" title="Cập Nhật"><span
                                        class="fl tle-txt"
                                        >{{$leagues[$league_id]->name}}</span><a
                                        class="fr btn-ref-sm" title="Cập Nhật"
                                        href="javascript:void(0)"></a>
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
                                        <div><span class="draw" title="Hòa">Hòa</span></div>
                                    </div>
                                </td>
                                @if(isset($match_info->lastest_odd))
                                    <?php
                                    $lastest_odd = (array)$match_info->lastest_odd;
                                    ?>
                                    <td>

                                        @if(isset($lastest_odd['1x2']))
                                            <div title="Chủ"
                                                 class="bold-text">{{$lastest_odd['1x2']['home']}}</div>
                                            <div title="Chủ"
                                                 class="bold-text">{{$lastest_odd['1x2']['away']}}</div>
                                            <div title="Chủ"
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
                                            <div title="Chủ"
                                                 class="bold-text">{{$lastest_odd['ah']['home']}}</div>
                                            <div title="Chủ"
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
                                            <div title="Chủ">{{$lastest_odd['ou']['draw']}}</div>
                                            <div title="Chủ"
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
                                            <div title="Chủ"
                                                 class="bold-text">{{$lastest_odd['ou']['home']}}</div>
                                            <div title="Chủ"
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
                                            <div title="Chủ"
                                                 class="bold-text">{{$lastest_odd['1x21st']['home']}}</div>
                                            <div title="Chủ"
                                                 class="bold-text">{{$lastest_odd['1x21st']['away']}}</div>
                                            <div title="Chủ"
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
                                            <div title="Chủ"
                                                 class="bold-text">{{$lastest_odd['ah1st']['home']}}</div>
                                            <div title="Chủ"
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
                                            <div title="Chủ">{{$lastest_odd['ou1st']['draw']}}</div>
                                            <div title="Chủ"
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
                                            <div title="Chủ"
                                                 class="bold-text">{{$lastest_odd['ou1st']['home']}}</div>
                                            <div title="Chủ"
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