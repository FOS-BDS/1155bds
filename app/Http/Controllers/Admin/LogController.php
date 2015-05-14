<?php
/**
 * Created by PhpStorm.
 * User: Kudo Shinichi
 * Date: 5/8/2015
 * Time: 3:06 PM
 */
namespace App\Http\Controllers\Admin;
use App\Libraries\Constants;
use App\Libraries\InputHelper;
use App\DAO\LogDAO;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use MongoRegex;

class LogController extends AdminController{
        public function manages(Request $request){
            //Log::info('test - '.time());
            $page = InputHelper::getInput('page', false, 1);
            $all_logs   = LogDAO::getInstance()->find();
            $all_log    = iterator_to_array($all_logs);
            $all_record = count($all_log);
            $number_page= (int)($all_record/Constants::LIMIT_PERPAGE)+1;
            $logs = LogDAO::getInstance()->find()->sort(array('create_at' => -1))->limit(20);
            if(intval($page) > 0){
                $logs->skip(($page-1)*Constants::LIMIT_PERPAGE);
            }
            return view('admin.logs.index',array('all_log'=>iterator_to_array($logs),'number_page'=>$number_page,'page'=>intval($page)));
        }
        /**
         * @return \Illuminate\View\View
         * @throws \App\Libraries\APIException
         */
        public function searchLogs(Request $request){
            try{
                $apiname        = $request->get('apiname','');
                $type_log       = $request->get('type_log','');
                $page           = $request->get('page',1);
                $message_log    = $request->get('message_log','');
                $where = array();
                if($apiname != '') {
                    $nameRegex = new MongoRegex("/$apiname/i");
                    $where[] = array('apiName'=>$nameRegex);
                }
                if($type_log != '') {
                    $where[] = array('lever'=>$type_log);
                }
                if($message_log != '') {
                    $messageRegex = new MongoRegex("/$message_log/i");
                    $where[] = array('message'=>$messageRegex);
                }
                if(count($where) > 0) {
                    $conditions['$and'] = $where;
                } else {
                    $conditions = $where;
                }

                $logCounter       = LogDAO::getInstance()->find($conditions);
                $number     = count(iterator_to_array($logCounter));
                $logData       = LogDAO::getInstance()->find($conditions)->sort(array('create_at' => -1))->limit(Constants::LIMIT_PERPAGE);
                $number_page = (int)($number/Constants::LIMIT_PERPAGE)+1;
                if(intval($page) > 0){
                    $logData->skip(($page-1)*Constants::LIMIT_PERPAGE);
                }
                return view('admin.logs.logs',array('logs'=>iterator_to_array($logData),'number_page'=>$number_page,'page'=>intval($page)))->render();
            }catch (\Exception $e){
                throw new \Exception($e->getMessage());
            }
        }
    }