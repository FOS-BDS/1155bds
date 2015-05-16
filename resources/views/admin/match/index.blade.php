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
            <tr>
                <td colspan="13" class="comp-title" title="Cập Nhật"><span class="fl tle-txt"
                                                                           id="c27412">English League Championship - PlayOff</span><a
                            class="fr btn-ref-sm" title="Cập Nhật" href="javascript:void(0)"></a>
                </td>
            </tr>
            <tr>
                <td class="d-t">
                    <div class="bold-text">16/05</div>
                    <div class="bold-text">01:45</div>
                    <!--Hide Date when it is Today-->   </td>
                <td class="evt-col r-bdr">
                    <div>
                        <div><span class="h_team team-better" title="Middlesbrough">Middlesbrough</span></div>
                        <div><span class="g_team" title="Brentford">Brentford</span></div>
                        <div><span class="draw" title="Hòa">Hòa</span></div>
                    </div>
                </td>
                <td>
                    <div title="Chủ" class="bold-text">1.96</div>
                    <div title="Chủ" class="bold-text">3.95</div>
                    <div title="Chủ" class="bold-text">3.45</div>
                </td>
                <td>
                    <div>0.5</div>
                    <div class="hide">0.5</div>
                    <div>&nbsp;</div>
                </td>
                <td >
                    <div title="Chủ" class="bold-text">0.98</div>
                    <div title="Chủ" class="bold-text">0.94</div>
                    <div>&nbsp;</div>
                </td>
                <td >
                    <div title="Chủ">2.5</div>
                    <div title="Chủ" class="hide">2.5</div>
                    <div>&nbsp;</div>
                </td>
                <td >
                    <div title="Chủ" class="bold-text">0.96</div>
                    <div title="Chủ" class="bold-text">0.94</div>
                    <div>&nbsp;</div>
                </td>
                <td >
                    <div title="Chủ" class="bold-text">2.60</div>
                    <div title="Chủ" class="bold-text">4.10</div>
                    <div title="Chủ" class="bold-text">2.10</div>
                </td>
                <td >
                    <div title="Chủ">0/0.5</div>
                    <div title="Chủ" class="hide">0/0.5</div>
                    <div>&nbsp;</div>
                </td>
                <td >
                    <div title="Chủ" class="bold-text">1.12</div>
                    <div title="Chủ" class="bold-text">0.77</div>
                    <div>&nbsp;</div>
                </td>
                <td >
                    <div title="Chủ">1</div>
                    <div title="Chủ" class="hide">1</div>
                    <div>&nbsp;</div>
                </td>
                <td >
                    <div title="Chủ" class="bold-text">0.95</div>
                    <div title="Chủ" class="bold-text">0.93</div>
                    <div>&nbsp;</div>
                </td>
                <td>
                    Tools
                </td>
            </tr>
            <tr>
                <td class="d-t">
                    <div class="bold-text">16/05</div>
                    <div class="bold-text">01:45</div>
                    <!--Hide Date when it is Today-->   </td>
                <td class="evt-col r-bdr">
                    <div>
                        <div><span class="h_team team-better" title="Middlesbrough">Middlesbrough</span></div>
                        <div><span class="g_team" title="Brentford">Brentford</span></div>
                        <div><span class="draw" title="Hòa">Hòa</span></div>
                    </div>
                </td>
                <td>
                    <div title="Chủ" class="bold-text">1.96</div>
                    <div title="Chủ" class="bold-text">3.95</div>
                    <div title="Chủ" class="bold-text">3.45</div>
                </td>
                <td>
                    <div>0.5</div>
                    <div class="hide">0.5</div>
                    <div>&nbsp;</div>
                </td>
                <td >
                    <div title="Chủ" class="bold-text">0.98</div>
                    <div title="Chủ" class="bold-text">0.94</div>
                    <div>&nbsp;</div>
                </td>
                <td >
                    <div title="Chủ">2.5</div>
                    <div title="Chủ" class="hide">2.5</div>
                    <div>&nbsp;</div>
                </td>
                <td >
                    <div title="Chủ" class="bold-text">0.96</div>
                    <div title="Chủ" class="bold-text">0.94</div>
                    <div>&nbsp;</div>
                </td>
                <td >
                    <div title="Chủ" class="bold-text">2.60</div>
                    <div title="Chủ" class="bold-text">4.10</div>
                    <div title="Chủ" class="bold-text">2.10</div>
                </td>
                <td >
                    <div title="Chủ">0/0.5</div>
                    <div title="Chủ" class="hide">0/0.5</div>
                    <div>&nbsp;</div>
                </td>
                <td >
                    <div title="Chủ" class="bold-text">1.12</div>
                    <div title="Chủ" class="bold-text">0.77</div>
                    <div>&nbsp;</div>
                </td>
                <td >
                    <div title="Chủ">1</div>
                    <div title="Chủ" class="hide">1</div>
                    <div>&nbsp;</div>
                </td>
                <td >
                    <div title="Chủ" class="bold-text">0.95</div>
                    <div title="Chủ" class="bold-text">0.93</div>
                    <div>&nbsp;</div>
                </td>
                <td>
                    Tools
                </td>
            </tr>
            <tr>
                <td class="d-t">
                    <div class="bold-text">16/05</div>
                    <div class="bold-text">01:45</div>
                    <!--Hide Date when it is Today-->   </td>
                <td class="evt-col r-bdr">
                    <div>
                        <div><span class="h_team team-better" title="Middlesbrough">Middlesbrough</span></div>
                        <div><span class="g_team" title="Brentford">Brentford</span></div>
                        <div><span class="draw" title="Hòa">Hòa</span></div>
                    </div>
                </td>
                <td>
                    <div title="Chủ" class="bold-text">1.96</div>
                    <div title="Chủ" class="bold-text">3.95</div>
                    <div title="Chủ" class="bold-text">3.45</div>
                </td>
                <td>
                    <div>0.5</div>
                    <div class="hide">0.5</div>
                    <div>&nbsp;</div>
                </td>
                <td >
                    <div title="Chủ" class="bold-text">0.98</div>
                    <div title="Chủ" class="bold-text">0.94</div>
                    <div>&nbsp;</div>
                </td>
                <td >
                    <div title="Chủ">2.5</div>
                    <div title="Chủ" class="hide">2.5</div>
                    <div>&nbsp;</div>
                </td>
                <td >
                    <div title="Chủ" class="bold-text">0.96</div>
                    <div title="Chủ" class="bold-text">0.94</div>
                    <div>&nbsp;</div>
                </td>
                <td >
                    <div title="Chủ" class="bold-text">2.60</div>
                    <div title="Chủ" class="bold-text">4.10</div>
                    <div title="Chủ" class="bold-text">2.10</div>
                </td>
                <td >
                    <div title="Chủ">0/0.5</div>
                    <div title="Chủ" class="hide">0/0.5</div>
                    <div>&nbsp;</div>
                </td>
                <td >
                    <div title="Chủ" class="bold-text">1.12</div>
                    <div title="Chủ" class="bold-text">0.77</div>
                    <div>&nbsp;</div>
                </td>
                <td >
                    <div title="Chủ">1</div>
                    <div title="Chủ" class="hide">1</div>
                    <div>&nbsp;</div>
                </td>
                <td >
                    <div title="Chủ" class="bold-text">0.95</div>
                    <div title="Chủ" class="bold-text">0.93</div>
                    <div>&nbsp;</div>
                </td>
                <td>
                    Tools
                </td>
            </tr>

            <tr>
                <td colspan="13"></td>
            </tr>
            <tr>
                <td colspan="13" class="comp-title" title="Cập Nhật"><span class="fl tle-txt"
                                                                           id="c27412">English League Championship - PlayOff</span><a
                            class="fr btn-ref-sm" title="Cập Nhật" href="javascript:void(0)"></a>
                </td>
            </tr>
            <tr>
                <td class="d-t">
                    <div class="bold-text">16/05</div>
                    <div class="bold-text">01:45</div>
                    <!--Hide Date when it is Today-->   </td>
                <td class="evt-col r-bdr">
                    <div>
                        <div><span class="h_team team-better" title="Middlesbrough">Middlesbrough</span></div>
                        <div><span class="g_team" title="Brentford">Brentford</span></div>
                        <div><span class="draw" title="Hòa">Hòa</span></div>
                    </div>
                </td>
                <td>
                    <div title="Chủ" class="bold-text">1.96</div>
                    <div title="Chủ" class="bold-text">3.95</div>
                    <div title="Chủ" class="bold-text">3.45</div>
                </td>
                <td>
                    <div>0.5</div>
                    <div class="hide">0.5</div>
                    <div>&nbsp;</div>
                </td>
                <td >
                    <div title="Chủ" class="bold-text">0.98</div>
                    <div title="Chủ" class="bold-text">0.94</div>
                    <div>&nbsp;</div>
                </td>
                <td >
                    <div title="Chủ">2.5</div>
                    <div title="Chủ" class="hide">2.5</div>
                    <div>&nbsp;</div>
                </td>
                <td >
                    <div title="Chủ" class="bold-text">0.96</div>
                    <div title="Chủ" class="bold-text">0.94</div>
                    <div>&nbsp;</div>
                </td>
                <td >
                    <div title="Chủ" class="bold-text">2.60</div>
                    <div title="Chủ" class="bold-text">4.10</div>
                    <div title="Chủ" class="bold-text">2.10</div>
                </td>
                <td >
                    <div title="Chủ">0/0.5</div>
                    <div title="Chủ" class="hide">0/0.5</div>
                    <div>&nbsp;</div>
                </td>
                <td >
                    <div title="Chủ" class="bold-text">1.12</div>
                    <div title="Chủ" class="bold-text">0.77</div>
                    <div>&nbsp;</div>
                </td>
                <td >
                    <div title="Chủ">1</div>
                    <div title="Chủ" class="hide">1</div>
                    <div>&nbsp;</div>
                </td>
                <td >
                    <div title="Chủ" class="bold-text">0.95</div>
                    <div title="Chủ" class="bold-text">0.93</div>
                    <div>&nbsp;</div>
                </td>
                <td>
                    Tools
                </td>
            </tr>
            <tr>
                <td class="d-t">
                    <div class="bold-text">16/05</div>
                    <div class="bold-text">01:45</div>
                    <!--Hide Date when it is Today-->   </td>
                <td class="evt-col r-bdr">
                    <div>
                        <div><span class="h_team team-better" title="Middlesbrough">Middlesbrough</span></div>
                        <div><span class="g_team" title="Brentford">Brentford</span></div>
                        <div><span class="draw" title="Hòa">Hòa</span></div>
                    </div>
                </td>
                <td>
                    <div title="Chủ" class="bold-text">1.96</div>
                    <div title="Chủ" class="bold-text">3.95</div>
                    <div title="Chủ" class="bold-text">3.45</div>
                </td>
                <td>
                    <div>0.5</div>
                    <div class="hide">0.5</div>
                    <div>&nbsp;</div>
                </td>
                <td >
                    <div title="Chủ" class="bold-text">0.98</div>
                    <div title="Chủ" class="bold-text">0.94</div>
                    <div>&nbsp;</div>
                </td>
                <td >
                    <div title="Chủ">2.5</div>
                    <div title="Chủ" class="hide">2.5</div>
                    <div>&nbsp;</div>
                </td>
                <td >
                    <div title="Chủ" class="bold-text">0.96</div>
                    <div title="Chủ" class="bold-text">0.94</div>
                    <div>&nbsp;</div>
                </td>
                <td >
                    <div title="Chủ" class="bold-text">2.60</div>
                    <div title="Chủ" class="bold-text">4.10</div>
                    <div title="Chủ" class="bold-text">2.10</div>
                </td>
                <td >
                    <div title="Chủ">0/0.5</div>
                    <div title="Chủ" class="hide">0/0.5</div>
                    <div>&nbsp;</div>
                </td>
                <td >
                    <div title="Chủ" class="bold-text">1.12</div>
                    <div title="Chủ" class="bold-text">0.77</div>
                    <div>&nbsp;</div>
                </td>
                <td >
                    <div title="Chủ">1</div>
                    <div title="Chủ" class="hide">1</div>
                    <div>&nbsp;</div>
                </td>
                <td >
                    <div title="Chủ" class="bold-text">0.95</div>
                    <div title="Chủ" class="bold-text">0.93</div>
                    <div>&nbsp;</div>
                </td>
                <td>
                    Tools
                </td>
            </tr>
            <tr>
                <td class="d-t">
                    <div class="bold-text">16/05</div>
                    <div class="bold-text">01:45</div>
                    <!--Hide Date when it is Today-->   </td>
                <td class="evt-col r-bdr">
                    <div>
                        <div><span class="h_team team-better" title="Middlesbrough">Middlesbrough</span></div>
                        <div><span class="g_team" title="Brentford">Brentford</span></div>
                        <div><span class="draw" title="Hòa">Hòa</span></div>
                    </div>
                </td>
                <td>
                    <div title="Chủ" class="bold-text">1.96</div>
                    <div title="Chủ" class="bold-text">3.95</div>
                    <div title="Chủ" class="bold-text">3.45</div>
                </td>
                <td>
                    <div>0.5</div>
                    <div class="hide">0.5</div>
                    <div>&nbsp;</div>
                </td>
                <td >
                    <div title="Chủ" class="bold-text">0.98</div>
                    <div title="Chủ" class="bold-text">0.94</div>
                    <div>&nbsp;</div>
                </td>
                <td >
                    <div title="Chủ">2.5</div>
                    <div title="Chủ" class="hide">2.5</div>
                    <div>&nbsp;</div>
                </td>
                <td >
                    <div title="Chủ" class="bold-text">0.96</div>
                    <div title="Chủ" class="bold-text">0.94</div>
                    <div>&nbsp;</div>
                </td>
                <td >
                    <div title="Chủ" class="bold-text">2.60</div>
                    <div title="Chủ" class="bold-text">4.10</div>
                    <div title="Chủ" class="bold-text">2.10</div>
                </td>
                <td >
                    <div title="Chủ">0/0.5</div>
                    <div title="Chủ" class="hide">0/0.5</div>
                    <div>&nbsp;</div>
                </td>
                <td >
                    <div title="Chủ" class="bold-text">1.12</div>
                    <div title="Chủ" class="bold-text">0.77</div>
                    <div>&nbsp;</div>
                </td>
                <td >
                    <div title="Chủ">1</div>
                    <div title="Chủ" class="hide">1</div>
                    <div>&nbsp;</div>
                </td>
                <td >
                    <div title="Chủ" class="bold-text">0.95</div>
                    <div title="Chủ" class="bold-text">0.93</div>
                    <div>&nbsp;</div>
                </td>
                <td>
                    Tools
                </td>
            </tr>

            <tr>
                <td colspan="13"></td>
            </tr>
            <tr>
                <td colspan="13" class="comp-title" title="Cập Nhật"><span class="fl tle-txt"
                                                                           id="c27412">English League Championship - PlayOff</span><a
                            class="fr btn-ref-sm" title="Cập Nhật" href="javascript:void(0)"></a>
                </td>
            </tr>
            <tr>
                <td class="d-t">
                    <div class="bold-text">16/05</div>
                    <div class="bold-text">01:45</div>
                    <!--Hide Date when it is Today-->   </td>
                <td class="evt-col r-bdr">
                    <div>
                        <div><span class="h_team team-better" title="Middlesbrough">Middlesbrough</span></div>
                        <div><span class="g_team" title="Brentford">Brentford</span></div>
                        <div><span class="draw" title="Hòa">Hòa</span></div>
                    </div>
                </td>
                <td>
                    <div title="Chủ" class="bold-text">1.96</div>
                    <div title="Chủ" class="bold-text">3.95</div>
                    <div title="Chủ" class="bold-text">3.45</div>
                </td>
                <td>
                    <div>0.5</div>
                    <div class="hide">0.5</div>
                    <div>&nbsp;</div>
                </td>
                <td >
                    <div title="Chủ" class="bold-text">0.98</div>
                    <div title="Chủ" class="bold-text">0.94</div>
                    <div>&nbsp;</div>
                </td>
                <td >
                    <div title="Chủ">2.5</div>
                    <div title="Chủ" class="hide">2.5</div>
                    <div>&nbsp;</div>
                </td>
                <td >
                    <div title="Chủ" class="bold-text">0.96</div>
                    <div title="Chủ" class="bold-text">0.94</div>
                    <div>&nbsp;</div>
                </td>
                <td >
                    <div title="Chủ" class="bold-text">2.60</div>
                    <div title="Chủ" class="bold-text">4.10</div>
                    <div title="Chủ" class="bold-text">2.10</div>
                </td>
                <td >
                    <div title="Chủ">0/0.5</div>
                    <div title="Chủ" class="hide">0/0.5</div>
                    <div>&nbsp;</div>
                </td>
                <td >
                    <div title="Chủ" class="bold-text">1.12</div>
                    <div title="Chủ" class="bold-text">0.77</div>
                    <div>&nbsp;</div>
                </td>
                <td >
                    <div title="Chủ">1</div>
                    <div title="Chủ" class="hide">1</div>
                    <div>&nbsp;</div>
                </td>
                <td >
                    <div title="Chủ" class="bold-text">0.95</div>
                    <div title="Chủ" class="bold-text">0.93</div>
                    <div>&nbsp;</div>
                </td>
                <td>
                    Tools
                </td>
            </tr>
            <tr>
                <td class="d-t">
                    <div class="bold-text">16/05</div>
                    <div class="bold-text">01:45</div>
                    <!--Hide Date when it is Today-->   </td>
                <td class="evt-col r-bdr">
                    <div>
                        <div><span class="h_team team-better" title="Middlesbrough">Middlesbrough</span></div>
                        <div><span class="g_team" title="Brentford">Brentford</span></div>
                        <div><span class="draw" title="Hòa">Hòa</span></div>
                    </div>
                </td>
                <td>
                    <div title="Chủ" class="bold-text">1.96</div>
                    <div title="Chủ" class="bold-text">3.95</div>
                    <div title="Chủ" class="bold-text">3.45</div>
                </td>
                <td>
                    <div>0.5</div>
                    <div class="hide">0.5</div>
                    <div>&nbsp;</div>
                </td>
                <td >
                    <div title="Chủ" class="bold-text">0.98</div>
                    <div title="Chủ" class="bold-text">0.94</div>
                    <div>&nbsp;</div>
                </td>
                <td >
                    <div title="Chủ">2.5</div>
                    <div title="Chủ" class="hide">2.5</div>
                    <div>&nbsp;</div>
                </td>
                <td >
                    <div title="Chủ" class="bold-text">0.96</div>
                    <div title="Chủ" class="bold-text">0.94</div>
                    <div>&nbsp;</div>
                </td>
                <td >
                    <div title="Chủ" class="bold-text">2.60</div>
                    <div title="Chủ" class="bold-text">4.10</div>
                    <div title="Chủ" class="bold-text">2.10</div>
                </td>
                <td >
                    <div title="Chủ">0/0.5</div>
                    <div title="Chủ" class="hide">0/0.5</div>
                    <div>&nbsp;</div>
                </td>
                <td >
                    <div title="Chủ" class="bold-text">1.12</div>
                    <div title="Chủ" class="bold-text">0.77</div>
                    <div>&nbsp;</div>
                </td>
                <td >
                    <div title="Chủ">1</div>
                    <div title="Chủ" class="hide">1</div>
                    <div>&nbsp;</div>
                </td>
                <td >
                    <div title="Chủ" class="bold-text">0.95</div>
                    <div title="Chủ" class="bold-text">0.93</div>
                    <div>&nbsp;</div>
                </td>
                <td>
                    Tools
                </td>
            </tr>
            <tr>
                <td class="d-t">
                    <div class="bold-text">16/05</div>
                    <div class="bold-text">01:45</div>
                    <!--Hide Date when it is Today-->   </td>
                <td class="evt-col r-bdr">
                    <div>
                        <div><span class="h_team team-better" title="Middlesbrough">Middlesbrough</span></div>
                        <div><span class="g_team" title="Brentford">Brentford</span></div>
                        <div><span class="draw" title="Hòa">Hòa</span></div>
                    </div>
                </td>
                <td>
                    <div title="Chủ" class="bold-text">1.96</div>
                    <div title="Chủ" class="bold-text">3.95</div>
                    <div title="Chủ" class="bold-text">3.45</div>
                </td>
                <td>
                    <div>0.5</div>
                    <div class="hide">0.5</div>
                    <div>&nbsp;</div>
                </td>
                <td >
                    <div title="Chủ" class="bold-text">0.98</div>
                    <div title="Chủ" class="bold-text">0.94</div>
                    <div>&nbsp;</div>
                </td>
                <td >
                    <div title="Chủ">2.5</div>
                    <div title="Chủ" class="hide">2.5</div>
                    <div>&nbsp;</div>
                </td>
                <td >
                    <div title="Chủ" class="bold-text">0.96</div>
                    <div title="Chủ" class="bold-text">0.94</div>
                    <div>&nbsp;</div>
                </td>
                <td >
                    <div title="Chủ" class="bold-text">2.60</div>
                    <div title="Chủ" class="bold-text">4.10</div>
                    <div title="Chủ" class="bold-text">2.10</div>
                </td>
                <td >
                    <div title="Chủ">0/0.5</div>
                    <div title="Chủ" class="hide">0/0.5</div>
                    <div>&nbsp;</div>
                </td>
                <td >
                    <div title="Chủ" class="bold-text">1.12</div>
                    <div title="Chủ" class="bold-text">0.77</div>
                    <div>&nbsp;</div>
                </td>
                <td >
                    <div title="Chủ">1</div>
                    <div title="Chủ" class="hide">1</div>
                    <div>&nbsp;</div>
                </td>
                <td >
                    <div title="Chủ" class="bold-text">0.95</div>
                    <div title="Chủ" class="bold-text">0.93</div>
                    <div>&nbsp;</div>
                </td>
                <td>
                    Tools
                </td>
            </tr>

            <tr>
                <td colspan="13"></td>
            </tr>
            </tbody>
        </table>
    </div>

@endsection