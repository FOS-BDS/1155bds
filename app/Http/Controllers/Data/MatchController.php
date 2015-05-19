<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 4/23/15
 * Time: 14:58
 */

namespace App\Http\Controllers\Data;


use App\DAO\LeagueDAO;
use App\DAO\MatchDAO;
use App\Factories\providers\MatchServiceProvider;
use App\Http\Controllers\BaseController;
use App\Libraries\ResponseBuilder;

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
        //get match data include running, not started yet, finished
        $matchDao=new MatchDAO();

       // $running=$matchDao->find(array('status'=>1))->sort('time',1);

        $matchcur=$matchDao->find()->sort(array('status'=>-1,'start_date'=>1));

        $league_ids=array();
        $final=array();
        $current_league_id="";
        $current_league=null;
        $index=-1;

        do {
            $matchcur->next();
            $current=(object)$matchcur->current();
            if($current==null) break;
            $start_time=new \DateTime();
            $start_time->setTimestamp($current->start_date->sec);
            $current->start_date=$start_time->format("d/m");
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

        $league_dao=new LeagueDAO();

        $league_cur=$league_dao->find(array('_id'=>array('$in'=>array_values($league_ids))));
        $leagues=array();
        do {
            $league_cur->next();
            $current_league=(object)$league_cur->current();
            if($current_league==null) break;
            $leagues[$current_league->_id->__toString()]=$current_league;
        } while($league_cur->hasNext());

        return View("admin.match.index",array('matchs'=>$final,'leagues'=>$leagues));
    }
}