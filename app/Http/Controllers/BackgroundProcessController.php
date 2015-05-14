<?php
namespace App\Http\Controllers;

use App\Factories\providers\MatchServiceProvider;
use App\Libraries\ResponseBuilder;
use App\Logics\Matchs\V9BetMatchs;
use App\DAO\BackgroundProcess;
use Exception;

class BackgroundProcessController extends BaseController {
    const NUMBER_RECORD = 30;
    public function process( $processId ) {
        $bg = new BackgroundProcess();
        try {
            //$runTime['start_time'] = microtime(true);
            $bg->process($processId);
            //Log::info("Run process: $processId", $runTime);
        } catch( Exception $e ) {
            return ResponseBuilder::error($e);
        }
        return;
    }

    public function cron()
    {
        try {
            $processCur = BackgroundProcess::getInstance()->getBatchProcess(self::NUMBER_RECORD);
            $processCur->next();
            do {
                $current = $processCur->current();
                if($current!=null && isset($current["_id"])) {
                    $this->process($current['_id']);
                }
                $processCur->next();
            } while($processCur->hasNext());
        } catch (Exception $e) {
            return ResponseBuilder::error($e);
        }
    }
    public function cronGetMatchData($ontime) {
        $inplay=$ontime==1?"true":"false";
        //$link="http://sb.v9bet.com/vi-vn/OddsService/GetOdds?_=".(time()*1000)."&sportId=1&programmeId=0&pageType=1&uiBetType=am&displayView=2&pageNo=0&oddsType=2&sortBy=1&isFirstLoad=false&isInplay=".$inplay;
        $link="http://sb.v9bet.com/vi-vn/OddsService/GetOdds?_=".(time()*1000)."&sportId=1&programmeId=0&pageType=1&uiBetType=am&displayView=2&oddsType=2&sortBy=1&isFirstLoad=false&MoreBetEvent=null&sportIds=1&versions=645747&version=645747&isInplay=".$inplay;
        $result=$this->curlGet($link);

        if($result==false) return;

        $v9betMatch=new V9BetMatchs();
        $v9betMatch->processData($result);
    }
    function curlGet($URL) {
        session_start();
        $ch = curl_init();
        $timeout = 3;
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
        curl_setopt( $ch , CURLOPT_URL , $URL );
        curl_setopt( $ch , CURLOPT_RETURNTRANSFER , 1 );
        curl_setopt( $ch , CURLOPT_CONNECTTIMEOUT , $timeout );
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Connection: Keep-Alive'
        ));
        /* if you want to force to ipv6, uncomment the following line */
        //curl_setopt( $ch , CURLOPT_IPRESOLVE , 'CURLOPT_IPRESOLVE_V6');
        $tmp = curl_exec( $ch );
        curl_close( $ch );
        return $tmp;
    }
}
