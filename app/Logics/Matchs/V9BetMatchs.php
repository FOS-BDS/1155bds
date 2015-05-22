<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 5/5/15
 * Time: 14:44
 */

namespace App\Logics\Matchs;


use App\DAO\CacheDAO;
use App\DAO\RuleDAO;
use App\Libraries\Constants;
use App\Libraries\InputHelper;
use App\Logics\base\MatchDataServiceBase;
use App\Logics\Odds\V9BetOdds;
use App\DAO\LeagueDAO;
use App\DAO\MatchDAO;
use App\Models\Rules;

class V9BetMatchs extends MatchDataServiceBase {
    public function processData($data=null)
    {
        $ontime_cache=$this->getOntimecache();
        $is_ontime=true;
        $version=-1;
        $matchDao=new MatchDAO();
        $data_json=json_decode($data);
        $data_json=(array)$data_json;

        if(array_key_exists(Constants::ONTIME_KEY,$data_json)) {
            $match_data=$data_json[Constants::ONTIME_KEY];

            if(count($match_data)==0) {
                $matchDao->update(
                    array('reference_id'=>array('$in'=>$ontime_cache->matchs)),
                    array('$set'=>array('status'=>-1)),
                    array('multi'=>true));
                $ontime_cache->matchs=array();
                $this->updateOntimeCache($ontime_cache);
                return $version;
            }
            $match_data=$match_data[0];
            $is_ontime=true;
            $version=$match_data->v;
        } elseif(array_key_exists(Constants::OFFTIME_KEY,$data_json)) {
            $match_data=$data_json[Constants::OFFTIME_KEY];
            $is_ontime=false;
            $version=$match_data->v;
        } elseif(array_key_exists(Constants::ONTIME_US_KEY,$data_json)) {
            $us_object=$data_json[Constants::ONTIME_US_KEY];
            $us_object=$us_object[0];
            $version=$us_object->v;
            $d=$us_object->d;
            if(count($d)==0) {
                // al matchs are finished
                $matchDao->update(
                    array('reference_id'=>array('$in'=>$ontime_cache->matchs)),
                    array('$set'=>array('status'=>-1)),
                    array('multi'=>true));
                $ontime_cache->matchs=array();
                $this->updateOntimeCache($ontime_cache);
            }
            return $version;
        } elseif(array_key_exists(Constants::OFFTIME_IR_KEY,$data_json)) {
            $ir_object=$data_json[Constants::OFFTIME_IR_KEY];
            //$ir_object=$ir_object[0];
            $version=$ir_object->v;
            return $version;
        }
        if(!isset($match_data)||!isset($match_data->egs))
        {
            $this->updateOntimeCache($ontime_cache);
            return $version;
        }

        // match data processing

        $egs=$match_data->egs;

        $leagues=array();
        $new_leagues=array();
        $matchs=array();
        $new_matchs=array();
        $league_match=array();
        $match_odds=array();

        foreach ($egs as $egs_item) {
            $league_c=$egs_item->c;
            $league_object=LeagueDAO::makeObject($league_c->k,$league_c->k,$league_c->n);
            $new_leagues[$league_c->k]=$league_object;

            // process to get match info
            $match_es=$egs_item->es;
            if(!array_key_exists($league_c->k,$league_match)) {
                $league_match[$league_c->k]=array();
            }
            foreach ($match_es as $match_item) {
                // register league_match
                $league_match[$league_c->k][]=$match_item->k;

                // get match_odds
                $match_odds[$match_item->k]=$match_item->o;

                // get match info
                $info=$match_item->i;

                $match_obj=MatchDAO::makeObject(
                    $match_item->k,$info[0],$info[1],
                    $this->getMatchStartTime($is_ontime,$info[4],$info[5]),
                    $this->getMatchTime($is_ontime,$info[5],$info[12]),
                    $info[10],$info[11],
                    0,0,$info[8],$info[9],$is_ontime,$info[12]);

                $new_matchs[$match_item->k]=$match_obj;
            }
        }
        $leagueModel=new LeagueDAO();
        $league_ids=array_keys($new_leagues);

        $league_cur=$leagueModel->find(array('reference_id'=>array('$in'=>$league_ids)));

        do {
            $league_cur->next();
            $league_obj=$league_cur->current();
            if($league_obj==null) break;
            $league_obj=(object)$league_obj;
            unset($new_leagues[$league_obj->reference_id]);
            $leagues[$league_obj->reference_id]=$league_obj;

        } while($league_cur->hasNext());

        if(count($new_leagues)>0) {
            $leagueModel->batchInsert(array_values($new_leagues));
            foreach ($new_leagues as $league) {
                $leagues[$league->reference_id]=$league;
            }
        }

        // update league id to match
        foreach ($league_match as $league_id => $match_ids) {
            foreach ($match_ids as $match_id) {
                $new_matchs[$match_id]->league_id=$leagues[$league_id]->_id;
            }

        }

        // insert new matchs




        $match_ids=array_keys($new_matchs);

        $match_cur=$matchDao->find(array('reference_id'=>array('$in'=>$match_ids)));

        do {
            $match_cur->next();
            $match_obj=$match_cur->current();
            if($match_obj==null) break;
            $match_obj=(object)$match_obj;

            $new_match_obj=$new_matchs[$match_obj->reference_id];
            if($is_ontime==true) {
                // skip start date when match is running
                $new_match_obj->start_date=$match_obj->start_date;
                $new_match_obj->newest_odd=$match_obj->newest_odd;
                $new_match_obj->old_odd=$match_obj->old_odd;
            }

            $matchDao->update(array('reference_id'=>$match_obj->reference_id),$new_match_obj);

            $new_match_obj->_id=$match_obj->_id;

            $matchs[$match_obj->reference_id]=$new_match_obj;

            unset($new_matchs[$match_obj->reference_id]);
        } while($match_cur->hasNext());
        // insert new match
        if(count($new_matchs)>0) {
            $matchDao->batchInsert(array_values($new_matchs));
            foreach ($new_matchs as $match) {
                $matchs[$match->reference_id]=$match;
            }
        }

        // update FT match status
        $fulltime_match_ids=array_diff($ontime_cache->matchs,$match_ids);
        $matchDao->update(array('reference_id'=>array('$in'=>array_values($fulltime_match_ids))),array('$set'=>array('status'=>-1)),array('multi'=>true));

        // update ontime cache
        if($is_ontime) {
            // update list ontime matchs for next time
            $ontime_cache->matchs=$match_ids;
            $this->updateOntimeCache($ontime_cache);
        }

        // processing Odd data
        $v9betOdd=new V9BetOdds();
        $v9betOdd->processData($matchs,$match_odds);

        return $version;

    }
    private function getOntimecache() {
        $cache_dao=new CacheDAO();
        $intime_matchs=$cache_dao->findOne(array('type'=>Constants::CACHE_ONTIME_MATCH));
        if($intime_matchs==null) {
            $intime_matchs=array('type'=>Constants::CACHE_ONTIME_MATCH,'matchs'=>array());
        }
        return (object)$intime_matchs;
    }
    private function updateOntimeCache($ontime_cache) {
        $cache_dao=new CacheDAO();
        $cache_dao->update(array('type'=>Constants::CACHE_ONTIME_MATCH),$ontime_cache,array('upsert'=>true));
    }
    private function getMatchStartTime($is_ontime,$start_date,$match_time) {
        if($is_ontime==true) {
            $mongoDate=new \MongoDate();
            return $mongoDate;// do not care this case
        } else {
            // only care this case
            $dates=explode("/",$start_date);
            $time=explode(":",$match_time);
            $current_time=new \DateTime();
            $year=$current_time->format("Y");

            $current_time->setDate(intval($year),intval($dates[1]),intval($dates[0]));
            $current_time->setTime(intval($time[0]),intval($time[1]));

            $current_time->add(new \DateInterval("PT".Constants::OFFSET_TIME_4H."H"));

            $timestamp=$current_time->getTimestamp();
            return new \MongoDate($timestamp);
        }
    }
    private function getMatchTime($is_ontime,$time,$match_haft) {

        if($time=="") {
            if($match_haft=="") {
                return Constants::TIME_PRE_MATCH;
            } elseif($match_haft=="1H") {
                return 0;
            } elseif($match_haft=="HT") {
                return Constants::TIME_HT;
            } elseif($match_haft=="2H") {
                return 46;
            } elseif($match_haft=="FT") {
                return Constants::TIME_FULL;
            }

        }elseif($is_ontime==true) {
            $time= explode(":",$time);
            return intval($time[0]);
        } else {
            $time= explode(":",$time);
            $hour=intval($time[0])+Constants::OFFSET_TIME_11H;
            $minute=intval($time[1]);
            $hour=$hour>=24?$hour-24:$hour;
            return $hour.":".$minute;
        }
    }

    public function getMatchedMatch() {
        // get all finale edited data
        $ruleDao=new RuleDAO();
        $final_rule_cur=$ruleDao->find(
            array('needed_update'=>true,'status'=>Constants::STATUS_MAIN));

        do {
            $final_rule_cur->next();
            $current=$final_rule_cur->current();
            if($current==null) break;
            $current=(object)$current;
            $rule=new Rules();
            $rule->initFromDBObject($current);
            $rule->process();

        } while($final_rule_cur->hasNext());
    }
    public function getMatchedMatchFromNewOdd() {
        $cacheDao=new CacheDAO();

        $cache_obj=$cacheDao->findOne(array('type'=>Constants::CACHE_NEWEST_ODDS));
        if($cache_obj==null) return;

        if(!isset($cache_obj['newest_odds'])) return;

        $new_odd_md5s=$cache_obj['newest_odds'];
        // get all Condition
        $ruleDao=new RuleDAO();
        $final_rule_cur=$ruleDao->find(
            array('type'=>Constants::TYPE_CONDITION,'status'=>Constants::STATUS_PUBLISH));

        do {
            $final_rule_cur->next();

            $current=$final_rule_cur->current();
            if($current==null) break;
            $current=(object)$current;
            $rule=new Rules();
            $rule->initFromDBObject($current);
            $rule->needed_update=true;
            $rule->process($new_odd_md5s,true);

        } while($final_rule_cur->hasNext());
    }
}