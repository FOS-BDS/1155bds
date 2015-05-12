<?php
/**
 * Created by PhpStorm.
 * User: Kudo Shinichi
 * Date: 5/8/2015
 * Time: 3:06 PM
 */
namespace App\Http\Controllers;
    use App\Libraries\InputHelper;
    use App\Models\Log;

    class LogController extends BaseController{
        public function manages(){
            $page = InputHelper::getInput('page',false,0);
            $all_logs   = Log::getInstance()->find();
            $all_log    = iterator_to_array($all_logs);
            $all_record = count($all_log);
            $number_page= (int)($all_record/20)+1;
            $logs   = Log::getInstance()->find();
            $logs->limit(20);
            if($page != 0){
                $logs->skip(($page-1)*20);
                return view('manager.content.logsearch',array('logs'=>iterator_to_array($logs)));
            }
            return view('manager.content.home',array('all_log'=>iterator_to_array($logs),'number_page'=>$number_page));
        }
        /**
         * @return \Illuminate\View\View
         * @throws \App\Libraries\APIException
         */
        public function searchLogs(){
            try{
                $apiname        = InputHelper::getInput('apiname',false,'');
                $type_log       = InputHelper::getInput('type_log',false,'');
                $message_log    = InputHelper::getInput('message_log',false,'');

                if($apiname != '' && $type_log != '' && $message_log != '' ){
                    $where=array( '$and' => array( array('lever' =>$type_log), array('message'=>$message_log), array('apiName'=>$apiname)));
                    $logs       = Log::getInstance()->find($where);
                }elseif( $apiname != '' && $type_log != ''){
                    $where=array( '$and' => array( array('lever' =>$type_log), array('apiName'=>$apiname)));
                    $logs       = Log::getInstance()->find($where);
                }
                elseif($type_log != '' && $message_log != ''){
                    $where=array( '$and' => array( array('lever' =>$type_log), array('message'=>$message_log)));
                    $logs       = Log::getInstance()->find($where);
                }
                elseif($apiname != '' && $message_log != '' ){
                    $where=array( '$and' => array( array('apiName' =>$apiname), array('message'=>$message_log)));
                    $logs       = Log::getInstance()->find($where);
                }else{
                    $where=array( '$or' => array( array('lever' =>$type_log), array('message'=>$message_log), array('apiName'=>$apiname)));
                    $logs       = Log::getInstance()->find($where);
                }
                return view('manager.content.logsearch',array('logs'=>iterator_to_array($logs)));
            }catch (\Exception $e){
                throw new \Exception($e->getMessage());
            }
        }
    }