<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 4/23/15
 * Time: 14:58
 */

namespace App\Http\Controllers\Data;


use App\DAO\CacheDAO;
use App\DAO\LeagueDAO;
use App\DAO\MatchDAO;
use App\DAO\MatchedMatchsDAO;
use App\Factories\providers\MatchServiceProvider;
use App\Http\Controllers\BaseController;
use App\Libraries\Constants;
use App\Libraries\ResponseBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Monolog\Handler\Mongo;

class MatchController extends BaseController{
    public function postMatchs() {
        try {
            MatchServiceProvider::getInstance()->getServiceInstance()->processData();
        } catch(\Exception $e) {
            return ResponseBuilder::error($e);
        }
    }
    public function getMatchedMatch() {
        try {
            MatchServiceProvider::getInstance()->getServiceInstance()->getMatchedMatch();
        } catch(\Exception $e) {
            return ResponseBuilder::error($e);
        }
    }
    public function getMatchedMatchFromNewOdd() {
        try {
            MatchServiceProvider::getInstance()->getServiceInstance()->getMatchedMatchFromNewOdd();
        } catch(\Exception $e) {
            return ResponseBuilder::error($e);
        }
    }
    public function getMatchView() {
        return View("users.match.index");
    }
    private function formatMatch($matchcur,&$league_ids,&$match_ids) {
        $final=array();
        $current_league_id="";
        $current_league=null;
        $index=-1;

        do {
            $matchcur->next();
            $current=$matchcur->current();
            if($current==null) break;
            $current=(object)$current;
            $match_ids[]=$current->_id->__toString();
            $start_time=new \DateTime();
            $start_time->setTimestamp($current->start_date->sec);
            $start_time->add(new \DateInterval("PT".Constants::OFFSET_TIME_7H."H"));
            $current->start_date=$start_time->format("d/m");
            if($current->status==0) {
                // today
                $current->time=$start_time->format("H:i");
            }
            $league_ids[$current->league_id->__toString()]=$current->league_id;
            if($current->league_id->__toString()!=$current_league_id) {
                $current_league=array();
                $current_league_id=$current->league_id->__toString();
                $current_league[$current_league_id][]=$current;
                $index++;
            } else {
                $current_league[$current_league_id][]=$current;
            }
            $final[$index]=$current_league;

        } while($matchcur->hasNext());
        return $final;
    }
    public function getMatchData(Request $request) {
        //get match data include running, not started yet, finished
        $typeView = $request->get('type', '404');
        $view = "users.match.".$typeView;
        $user=(object)Session::get('user');

        $matchDao=new MatchDAO();

        $league_ids=array();
        $matchs = array();
        $match_ids=array();
        if($typeView == 'inplay') {
            $cacheDao=new CacheDAO();
            $inplay_cache=$cacheDao->findOne(array('type'=>Constants::CACHE_ONTIME_MATCH));
            if($inplay_cache==null) {
                return $matchs;
            }
            $inplay_cache=(object)$inplay_cache;
            $matchDatas = $matchDao->find(
                array('reference_id' => array('$in'=>$inplay_cache->matchs)))
                ->sort(array('time' => -1));
            $matchs = $this->formatMatch($matchDatas, $league_ids,$match_ids);
        } elseif($typeView == 'today') {
            $mongodate=new \MongoDate(time());
            $matchDatas=$matchDao->find(
                array('status'=>0,'start_date'=>array('$gt'=>$mongodate)))
                ->sort(array('start_date'=>1));
            $matchs = $this->formatMatch($matchDatas, $league_ids,$match_ids);
        } elseif($typeView == 'finished') {
            $mongodate=new \MongoDate(time()-24*60*60);
            $matchDatas=$matchDao->find(
                array('status'=>-1,'start_date'=>array('$gt'=>$mongodate)))
                ->sort(array('start_date'=>-1));
            $matchs = $this->formatMatch($matchDatas, $league_ids,$match_ids);
        }

        $league_dao=new LeagueDAO();

        $league_cur=$league_dao->find(array('_id'=>array('$in'=>array_values($league_ids))),array('name'));
        $leagues=array();
        do {
            $league_cur->next();
            $current_league=$league_cur->current();
            if($current_league==null) break;
            $current_league=(object)$current_league;
            $leagues[$current_league->_id->__toString()]=$current_league;
        } while($league_cur->hasNext());

        // get matched matchs
        $matched_match_cur=MatchedMatchsDAO::getInstance()->find(
            array('match_id'=>array('$in'=>$match_ids),'user_id'=>$user->_id));
        $matched_matchs=array();
        do {
            $matched_match_cur->next();
            $current=$matched_match_cur->current();
            if($current==null) break;
            $current=(object)$current;
            $matched_matchs[$current->match_id]=$current->color_lever;
        } while($matched_match_cur->hasNext());

        return View($view,array('matchs'=>$matchs,'leagues'=>$leagues,'matched_matchs'=>$matched_matchs));

    }
}