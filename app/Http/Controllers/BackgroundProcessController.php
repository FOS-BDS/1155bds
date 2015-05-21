<?php
namespace App\Http\Controllers;

use App\DAO\CacheDAO;
use App\Factories\providers\MatchServiceProvider;
use App\Libraries\Constants;
use App\Libraries\InputHelper;
use App\Libraries\ResponseBuilder;
use App\Logics\Matchs\V9BetMatchs;
use App\DAO\BackgroundProcess;
use Exception;
use Illuminate\Support\Facades\Log;

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
            do {
                $processCur->next();
                $current = $processCur->current();
                if($current!=null && isset($current["_id"])) {
                    $this->process($current['_id']);
                }
            } while($processCur->hasNext());
        } catch (Exception $e) {
            return ResponseBuilder::error($e);
        }
    }
    public function cronGetMatchData($ontime) {
        Log::info("Run Get Match data cron");
        try {
            $cache_dao=new CacheDAO();
            $version_cache=$cache_dao->findOne(array('type'=>Constants::CACHE_ODDS_VERSION));
            if($version_cache==null) {
                // call first time
                $this->getFirstTimeVersion();

            } else {
                // call follow $ontime param
                $in_v=intval($version_cache["intime_v"]);
                $off_v=intval($version_cache["offtime_v"]);

                $inplay=$ontime==1?"true":"false";
                $link="http://sb.v9bet.com/vi-vn/OddsService/GetOdds?_=".(time()*1000)."&sportId=1&programmeId=0&pageType=1&uiBetType=am&displayView=2&oddsType=2&sortBy=1&isFirstLoad=false&MoreBetEvent=null&sportIds=1&versions=".$in_v."&version=".$off_v."&isInplay=".$inplay;

                //http://sb.v9bet.com/vi-vn/OddsService/GetOdds?_=1431933424000&sportId=1&programmeId=0&pageType=1&uiBetType=am&displayView=2&oddsType=2&sortBy=1&isFirstLoad=false&MoreBetEvent=null&sportIds=1&versions=0&version=4911&isInplay=false
                //http://sb.v9bet.com/vi-vn/OddsService/GetOdds?_=1431933450036&sportId=1&programmeId=0&pageType=1&uiBetType=am&displayView=2&oddsType=2&sortBy=1&isFirstLoad=false&MoreBetEvent=null&sportIds=1&versions=0&version=4749&isInplay=false

                $result=$this->curlGet($link);

                if($result==false) return;

                $v9betMatch=new V9BetMatchs();
                $version=$v9betMatch->processData($result);
                if($version!=-1) {
                    if($ontime) {
                        $version_cache['intime_v']=$version;
                    } else {
                        $version_cache['offtime_v']=$version;
                    }
                    $cache_dao->update(array('_id'=>$version_cache['_id']),$version_cache);
                } else {
                    Log::error("Nothing to process,result:".$result);
                }
            }
        } catch(Exception $e) {
            return ResponseBuilder::error($e);
        }

    }
    public function getOddVersion() {
        $this->getFirstTimeVersion();
    }
    private function getFirstTimeVersion() {
        $link="http://sb.v9bet.com/vi-vn/OddsService/GetOdds?_=".(time()*1000)."&sportId=1&programmeId=0&pageType=1&uiBetType=am&displayView=2&oddsType=2&sortBy=1&isFirstLoad=true&MoreBetEvent=null";

        $result=$this->curlGet($link);

        $intime_version=0;
        $offtime_version=0;

        if($result==false) return;
        $data=json_decode($result);
        $data=(array)$data;
        if(isset($data['i-ot'])){
            $iot=(array)$data['i-ot'];
            if(isset($iot['v'])) {
                $intime_version=intval($iot['v']);
            } else {
                return;
            }
        }
        if(isset($data['n-ot'])) {
            $not=(array)$data['n-ot'];
            if(isset($not['v'])) {
                $offtime_version=intval($not['v']);
            } else {
                return;
            }
        }
        $cache_dao=new CacheDAO();
        $cache=array('intime_v'=>$intime_version,'offtime_v'=>$offtime_version,'type'=>Constants::CACHE_ODDS_VERSION);
        $cache_dao->update(array('type'=>Constants::CACHE_ODDS_VERSION),$cache,array('upsert'=>true));
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
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        /* if you want to force to ipv6, uncomment the following line */
        //curl_setopt( $ch , CURLOPT_IPRESOLVE , 'CURLOPT_IPRESOLVE_V6');
        $tmp = curl_exec( $ch );
        curl_close( $ch );
        return $tmp;
    }
    public function testCurl() {
        $link=InputHelper::getInput('link',true);
        echo $this->curlGet($link);
    }
}
