@extends('manager.layouts.index')
@section('content')
    <div id="body" class="col-lg-12 col-md-12">
    <!-- Filter form -->
        <div class="col-lg-12 col-md-12 no-padding">
            <form class="form-horizontal" action="/manages/searchLogs" method="GET">
                <div class="form-group col-lg-3 col-md-3" >
                    <input type="text" class="form-control" id="apiname" name="apiname" placeholder="Api name...">
                </div>
                <div class="form-group col-lg-3 col-md-3">
                    <label class="control-label col-lg-2 col-md-2">Type:</label>
                    <div class="col-lg-10">
                        <select name="type_log" class="form-control" id="type_log" >
                            <option value="error" >Error</option>
                            <option value="info" >Infor</option>
                        </select>
                    </div>
                </div>
                <div class="form-group col-lg-4 col-md-4">
                    <input type="text" class="form-control" name="message_log" id="message_log" placeholder="Message...">
                </div>
                <div class="form-group col-lg-2 col-md-2">
                    <button type="submit" class="btn btn-success" data-text-loading="Filtering..">Search</button>
                    <a href="#" class="btn btn-danger" data-text-loading="Filtering..">Delete All</a>
                </div>
            </form>
        </div>
                <div id="loading" style="position:absolute;margin-top: 20%;margin-left: 45%;display: none;" >
                    <img src="<?php echo URL::to('/') ?>/admin/img/ajax-loader.gif">
                </div>
        <!-- Display infor-->
        <div id="dataAndpage">
            <div id="tableLog" class="">
                <table class="table table-bordered table-hover">
                            <tr class="bg-success">
                                <th class="text-center">API NAME</th>
                                <th class="text-center">CODE</th>
                                <th class="text-center">TYPE</th>
                                <th class="text-center">MESSAGE</th>
                                <th class="text-center">Created_at</th>
                            </tr>
                @foreach($all_log as $log)
                   @if($log['lever'] == 'info')
                         <tr class="info" >
                            <td class="text-center">{{$log['apiName']}}</td>
                            <td class="text-center">{{$log['errorCode']}}</td>
                            <td class="text-center">{{$log['lever']}}</td>
                             <td style="width: 50%;"><p style="max-width: 700px; word-wrap: break-word;">{{$log['message']}}</p></td>
                            <td class="text-center">{{$log['create_at']}}</td>
                        </tr>
                   @elseif($log['lever'] == 'error')
                         <tr class="bg-danger" >
                            <td class="text-center">{{$log['apiName']}}</td>
                            <td class="text-center">{{$log['errorCode']}}</td>
                            <td class="text-center">{{$log['lever']}}</td>
                             <td style="width: 50%;"><p style="max-width: 700px; word-wrap: break-word;">{{$log['message']}}</p></td>
                            <td class="text-center col-lg-1 col-md-1">{{$log['create_at']}}</td>
                        </tr>
                   @endif
                @endforeach
                </table>
            </div>
            <div style="text-align: center">
                @for($i=1;$i<=$number_page;$i++)
                    <a href="#" onclick="manage.searchPage(this,'{{$i}}');"><span class="badge page_{{$i}}" style="background-color:#9D928C;">{{$i}}</span></a>
                @endfor
            </div>
        </div>
    </div>
@endsection