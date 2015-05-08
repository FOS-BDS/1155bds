<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 5/5/15
 * Time: 14:45
 */

namespace App\Logics\Odds;


use App\Libraries\Constants;
use App\Logics\base\OddServiceBase;
use App\Models\Odds;

class V9BetOdds extends OddServiceBase {
    public function processData($matchs=null,$match_odds=null)
    {
        $odd_types=array(
            '1x2'   =>array('home'=>1,'draw'=>5,'away'=>3,'type'=>Constants::ODD_1X2),
            '1x21st'=>array('home'=>1,'draw'=>5,'away'=>3,'type'=>Constants::ODD_1X21ST),
            'ah'    =>array('home'=>5,'draw'=>3,'away'=>7,'type'=>Constants::ODD_AH),
            'ah1st' =>array('home'=>5,'draw'=>3,'away'=>7,'type'=>Constants::ODD_AH1ST),
            'ou'    =>array('home'=>5,'draw'=>3,'away'=>7,'type'=>Constants::ODD_OU),
            'ou1st' =>array('home'=>5,'draw'=>3,'away'=>7,'type'=>Constants::ODD_OU1ST),
        );
        $odd_objs=array();
        foreach ($match_odds as $match_id=> $odds) {
            if(!is_array($odds)) $odds=(array)$odds;
            foreach ($odd_types as $key=> $config) {
                if(isset($odds[$key])) {
                    $home=floatval($odds[$key][$config['home']]);
                    $away=floatval($odds[$key][$config['away']]);
                    $draw=floatval($odds[$key][$config['draw']]);
                    $odd_obj=Odds::makeObject($matchs[$match_id],$home,$draw,$away,$config['type']);
                    $odd_objs[$odd_obj->md5]=$odd_obj;
                }
            }
        }

        // insert Odd to table
        $oddModel=new Odds();
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
    }

}