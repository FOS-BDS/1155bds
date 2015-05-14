<?php
/**
 * Created by PhpStorm.
 * User: Kudo Shinichi
 * Date: 5/8/2015
 * Time: 3:06 PM
 */
namespace App\Http\Controllers;
    use App\Libraries\InputHelper;
    use App\DAO\LogDAO;

    class LogController extends BaseController{
        public function manages(){
            $page = InputHelper::getInput('page',false,0);
            $all_logs   = LogDAO::getInstance()->find();
            $all_log    = iterator_to_array($all_logs);
            $all_record = count($all_log);
            $number_page= (int)($all_record/20)+1;
            $logs   = LogDAO::getInstance()->find();
            $logs->limit(20);
            if($page != 0){
                $logs->skip(($page-1)*20);
                return view('manager.content.logpage',array('logs'=>iterator_to_array($logs)));
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
                $page           = InputHelper::getInput('page',false,0);
                if($apiname != '' && $type_log != '' && $message_log != '' ){
                    $where=array( '$and' => array( array('lever' =>$type_log), array('message'=>$message_log), array('apiName'=>$apiname)));
                }elseif( $apiname != '' && $type_log != ''){
                    $where=array( '$and' => array( array('lever' =>$type_log), array('apiName'=>$apiname)));
                }
                elseif($type_log != '' && $message_log != ''){
                    $where=array( '$and' => array( array('lever' =>$type_log), array('message'=>$message_log)));
                }
                elseif($apiname != '' && $message_log != '' ){
                    $where=array( '$and' => array( array('apiName' =>$apiname), array('message'=>$message_log)));
                }else{
                    $where=array( '$or' => array( array('lever' =>$type_log), array('message'=>$message_log), array('apiName'=>$apiname)));
                }
                $logs       = LogDAO::getInstance()->find($where);
                $number     = count(iterator_to_array($logs));
                $logss       = LogDAO::getInstance()->find($where);
                $logss->limit(20);
                $number_page = (int)($number/20)+1;
                if($page != 0){
                    $logss->skip(($page-1)*20);
                    return view('manager.content.logsearchpage',array('logs'=>iterator_to_array($logss)));
                }
                return view('manager.content.logsearch',array('logs'=>iterator_to_array($logs),'number_page'=>$number_page,'apiname'=>$apiname,'type_log'=>$type_log,'message_log'=>$message_log));
            }catch (\Exception $e){
                throw new \Exception($e->getMessage());
            }
        }
    }