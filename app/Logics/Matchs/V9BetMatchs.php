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
        $data_json=json_decode($data);
        $data_json=(array)$data_json;
        $is_ontime=true;
        $version=-1;
        if(array_key_exists(Constants::ONTIME_KEY,$data_json)) {
            $match_data=$data_json[Constants::ONTIME_KEY];

            if(count($match_data)==0) {
                return;
            }
            $match_data=$match_data[0];
            $is_ontime=true;
            $version=$match_data->v;
        } elseif(array_key_exists(Constants::OFFTIME_KEY,$data_json)) {
            $match_data=$data_json[Constants::OFFTIME_KEY];
            $is_ontime=false;
            $version=$match_data->v;
        }
        if(!isset($match_data)||!isset($match_data->egs)) return $version;

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
                $match_obj=MatchDAO::makeObject($match_item->k,$info[0],$info[1],$info[4],
                    $this->getMatchTime($is_ontime,$info[5],$info[12]),$info[10],$info[11],0,0,$info[8],$info[9],$is_ontime);
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
        $match_model=new MatchDAO();
        $match_ids=array_keys($new_matchs);

        $match_cur=$match_model->find(array('reference_id'=>array('$in'=>$match_ids)));

        do {
            $match_cur->next();
            $match_obj=$match_cur->current();
            if($match_obj==null) break;
            $match_obj=(object)$match_obj;

            $new_match_obj=$new_matchs[$match_obj->reference_id];

            $match_model->update(array('reference_id'=>$match_obj->reference_id),$new_match_obj);

            $new_match_obj->_id=$match_obj->_id;

            $matchs[$match_obj->reference_id]=$new_match_obj;

            unset($new_matchs[$match_obj->reference_id]);
        } while($match_cur->hasNext());
        // insert new match
        if(count($new_matchs)>0) {
            $match_model->batchInsert(array_values($new_matchs));
            foreach ($new_matchs as $match) {
                $matchs[$match->reference_id]=$match;
            }
        }

        // processing Odd data
        $v9betOdd=new V9BetOdds();
        $v9betOdd->processData($matchs,$match_odds);

        return $version;

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
            return $time[0];
        } else {
            return $time;
        }
    }

    public function getMatchedMatch() {
        // get all finale edited data
        $ruleDao=new RuleDAO();
        $final_rule_cur=$ruleDao->find(array('needed_update'=>true,'status'=>Constants::STATUS_MAIN));

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
        $cache_id=InputHelper::getInput("cache_id",true);
        $mongo_id=new \MongoId($cache_id);

        $cacheDao=new CacheDAO();

        $cache_obj=$cacheDao->findOneObjectById($mongo_id);
        if($cache_obj==null) return;

        if(!isset($cache_obj['newest_odds'])) return;

        $new_odd_ids=$cache_obj['newest_odds'];

        $new_odd_Mongoids=array();
        foreach ($new_odd_ids as $id) {
            $new_odd_Mongoids[]=new \MongoId($id);
        }
        // get all Condition
        $ruleDao=new RuleDAO();
        $final_rule_cur=$ruleDao->find(array('type'=>Constants::TYPE_CONDITION,'status'=>Constants::STATUS_PUBLISH));

        do {
            $final_rule_cur->next();

            $current=$final_rule_cur->current();
            if($current==null) break;
            $current=(object)$current;
            $rule=new Rules();
            $rule->initFromDBObject($current);
            $rule->process($new_odd_Mongoids,true);

        } while($final_rule_cur->hasNext());
    }
}