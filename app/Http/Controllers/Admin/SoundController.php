<?php
/**
 * Created by PhpStorm.
 * User: Kudo Shinichi
 * Date: 5/20/2015
 * Time: 9:41 AM
 */
namespace App\Http\Controllers\Admin;
use App\DAO\SoundDAO;
use App\Http\Controllers\Admin\AdminController;
use App\Libraries\InputHelper;
use App\Libraries\ResponseBuilder;

class SoundController extends AdminController{
    public function manageSounds(){
        return view('admin.sounds.index');
    }
    public function insertSound(){
        try{
            $soundName = InputHelper::getInput('soundName',true,'');
            $soundFile = InputHelper::getFile('soundFile',true);
            $extension = $soundFile->getClientOriginalExtension();
            if(strtoupper($extension) != 'MP3'){
                return ResponseBuilder::success(array('message'=>'Bạn hãy chọn file MP3!','error'=>1));
            }
            $filename = time() . "_" . rand(0, 10000000) . "." . $extension;
            $soundFile->move('sounds', $filename);
            $inputFile = array(
                'soundName'     => $soundName,
                'extension'     => $extension,
                'file_name'     => $filename,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s')
            );
            SoundDAO::getInstance()->insert($inputFile);
            return ResponseBuilder::success(array('message'=>'Thêm thành công','error'=>0));
        }catch (\Exception $e){
            return ResponseBuilder::error($e);
        }
    }
    public function allSounds(){
        try{
            $allSounds = SoundDAO::getInstance()->find(array());
            return view('admin.sounds.listSound',array('sounds'=>iterator_to_array($allSounds)));
        }catch (\Exception $e){
            return ResponseBuilder::error($e->getMessage());
        }
    }
}