@extends('admin.layouts.app')
@section('scripts')
    <?php echo Html::script('/admin/js/sound.js') ?>
    <script type="text/javascript">
        $(document).ready(function(){
            Sound.loadSounds();
        })
    </script>
@endsection
@section('content')
    <div class="col-lg-1 btn btn-info">
        <div class="ion-plus-round fa-5x" data-toggle="modal" data-target="#modalInsertSound">
        </div>
    </div>
    <div class="col-lg-11" id="soundList">

    </div>
    <!-- form insert sound -->
    <div class="modal fade" id="modalInsertSound" tabindex="-1" role="dialog" aria-labelledby="modalInsertSound" aria-hidden="true">
          <div class="modal-dialog">
                <div class="modal-content">
                      <div class="panel panel-info no-margin no-padding">
                            <div class="panel-heading">
                                   <h5 class="header text-center">Thêm âm thanh</h5>
                            </div>
                            <div class="panel-body">
                                <form id="formInsertSound" class="form-horizontal" role="form" action="#" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="soundName" class="control-label col-xs-2">Tên </label>
                                        <div class="col-xs-10">
                                            <input type="text" class="form-control" name="soundName" placeholder="Nhập tên âm thanh...">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="soundFile" class="control-label col-xs-2">Âm thanh</label>
                                        <div class="col-xs-10">
                                            <input type="file" class="form-control" name="soundFile"  placeholder="Chèn file âm thanh...">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-xs-offset-4 col-xs-10">
                                            <a  class="btn btn-lg btn-default" onclick="Sound.cancelProcess('#formInsertSound','#modalInsertSound');">Hủy</a>
                                            <a  class="btn btn-lg btn-primary" onclick="Sound.addSound(this);">Thêm</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                      </div>
                </div>
          </div>
    </div>
@endsection