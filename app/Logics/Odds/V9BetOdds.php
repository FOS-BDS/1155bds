<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 5/5/15
 * Time: 14:45
 */

namespace App\Logics\Odds;


use App\DAO\BackgroundProcess;
use App\DAO\CacheDAO;
use App\DAO\MatchDAO;
use App\DAO\RuleDAO;
use App\Libraries\Constants;
use App\Logics\base\OddServiceBase;
use App\DAO\OddDAO;

class V9BetOdds extends OddServiceBase {
    public function processData($matchs=null,$match_odds=null)
    {
        $odd_types=array(
            '1x2'   =>array('home'=>1,'h_draw'=>5,'g_draw'=>5,'away'=>3,'type'=>Constants::ODD_1X2),
            '1x21st'=>array('home'=>1,'h_draw'=>5,'g_draw'=>5,'away'=>3,'type'=>Constants::ODD_1X21ST),
            'ah'    =>array('home'=>5,'h_draw'=>1,'g_draw'=>3,'away'=>7,'type'=>Constants::ODD_AH),
            'ah1st' =>array('home'=>5,'h_draw'=>1,'g_draw'=>3,'away'=>7,'type'=>Constants::ODD_AH1ST),
            'ou'    =>array('home'=>5,'h_draw'=>1,'g_draw'=>3,'away'=>7,'type'=>Constants::ODD_OU),
            'ou1st' =>array('home'=>5,'h_draw'=>1,'g_draw'=>3,'away'=>7,'type'=>Constants::ODD_OU1ST),
        );
        $matchDao=new MatchDAO();
        $odd_objs=array();
        foreach ($match_odds as $match_id=> $odds) {
            $lastest_odd=array();
            if(!is_array($odds)) $odds=(array)$odds;
            foreach ($odd_types as $key=> $config) {
                if(isset($odds[$key])) {
                    $home=$this->getOddVal($odds[$key][$config['home']]);
                    $away=$this->getOddVal($odds[$key][$config['away']]);
                    $h_draw=$this->getOddVal($odds[$key][$config['h_draw']]);
                    $g_draw=$this->getOddVal($odds[$key][$config['g_draw']]);
                    $odd_obj=OddDAO::makeObject($matchs[$match_id],$home,$h_draw,$g_draw,$away,$config['type']);
                    $odd_objs[$odd_obj->md5]=$odd_obj;
                    $lastest_odd[$key]=$odd_obj;
                }
            }

            $matchDao->update(
                array('reference_id'=>$match_id),
                array('$set'=>array('lastest_odd'=>$lastest_odd)),
                array('multi'=>true));
        }



        // insert Odd to table
        $oddModel=new OddDAO();
        $md5s=array_keys($odd_objs);
        $odd_cur=$oddModel->find(array('md5'=>array('$in'=>$md5s)));

        do {
            $odd_cur->next();
            $current_obj=$odd_cur->current();
            if($current_obj==null) break;
            $current_obj=(object)$current_obj;
            unset($odd_objs[$current_obj->md5]);

        } while($odd_cur->hasNext());

        if(count($odd_objs)>0) {
            $oddModel->batchInsert(array_values($odd_objs));
        }

        $cacheDao=new CacheDAO();
        $data=array('newest_odds'=>array_keys($odd_objs),'type'=>Constants::CACHE_NEWEST_ODDS);
        $cacheDao->update(array('type'=>Constants::CACHE_NEWEST_ODDS),$data,array('upsert'=>true));

        $background=new BackgroundProcess();
        $background->throwProcess("/cron/match/matchedNewOdds");

    }
    private function getOddVal($str_val) {
        if(strpos($str_val,"/")!==false) {
            // exist

            if(strpos($str_val,"-")!==false) {
                $pre=-1;
            } else {
                $pre=1;
            }

            $splits=explode("/",$str_val);

            $first=floatval($splits[0]);
            $second=floatval($splits[1]);

            $val=$pre*((abs($first)+abs($second))/2);
            return $val;
        } else {
            //not exist
            return floatval($str_val);
        }
    }
    private function getMatchedMatchWithNewOdds($new_odds) {
        $ruleDao=new RuleDAO();
        $condition_cur=$ruleDao->find(array());
    }
}