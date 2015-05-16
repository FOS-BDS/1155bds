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

class LogController extends AdminController {
    public function manages(Request $request){
        try {
            //Log::info('test - '.time());
            //Log::error('test - '.time());
            $page = InputHelper::getInput('page', false, 1);
            $numberRecords = LogDAO::getInstance()->count(array());
            $numberPage = ceil($numberRecords / Constants::LIMIT_PERPAGE);
            $logs = LogDAO::getInstance()->find()->sort(array('create_at' => -1))->limit(Constants::LIMIT_PERPAGE);
            if (intval($page) > 0) {
                $logs->skip(($page - 1) * Constants::LIMIT_PERPAGE);
            }
            return view('admin.logs.index', array('logs' => iterator_to_array($logs), 'number_page' => $numberPage, 'page' => intval($page)));
        } catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
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
            $numberRecords = LogDAO::getInstance()->count($conditions);
            $numberPage = ceil($numberRecords/Constants::LIMIT_PERPAGE);
            $logData        = LogDAO::getInstance()->find($conditions)->sort(array('create_at' => -1))->limit(Constants::LIMIT_PERPAGE);
            if(intval($page) > 0){
                $logData->skip(($page-1)*Constants::LIMIT_PERPAGE);
            }
            return view('admin.logs.logs',array('logs'=>iterator_to_array($logData),'number_page'=>$numberPage,'page'=>intval($page)))->render();
        } catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }
    public function deleteLogs(Request $request) {
        try {
            LogDAO::getInstance()->remove(array());
            return view('admin.logs.logs',array('logs'=>array(),'number_page'=>1,'page'=>1))->render();
        } catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }
}