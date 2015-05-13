<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 4/24/15
 * Time: 09:51
 */

namespace App\Logics\Matchs;


use App\Libraries\InputHelper;
use App\Libraries\ResponseBuilder;
use App\Libraries\StringHelper;
use App\Logics\base\MatchDataServiceBase;
use App\DAO\LeagueDAO;
use App\DAO\MatchDAO;
use App\DAO\TeamDAO;
use DateTime;
use Exception;
use Illuminate\Support\Facades\Log;
use stdClass;

class NowGoalMatchs extends MatchDataServiceBase{
    public function processData($eee=null)
    {
        try {
            Log::info("Run Post Matchs");
            $json=InputHelper::getInput("data",true);

            $data=$this->formatData($json);

            $matchs=$data->a_array;
            $leags=$data->b_array;

            $this->generateObjects($matchs,$leags);

            //$this->updateMatchs($matchs,$leags);

            //$this->updateLeagues($leags);

        } catch(Exception $e) {
            return ResponseBuilder::error($e);
        }
    }
    private function generateObjects($match,$leagues) {

        $teamModel=new TeamDAO();
        $team_objects=array();
        // gen team objects
        $new_teams=array();
        foreach ($match as $key=>$match_obj) {
            if($match_obj==null) continue;
            $match[$key][1]=$leagues[$match_obj[1]][0];
            $h_team=$match_obj[4];

            $pos=strpos($h_team,'<');
            if($pos>0) {
                $h_team=substr($h_team,0,$pos);
            }
            $g_team=$match_obj[5];

            $pos=strpos($g_team,'<');
            if($pos>0) {
                $g_team=substr($g_team,0,$pos);
            }
            $t1=TeamDAO::makeObject($match_obj[2],$h_team);
            $new_teams[intval($match_obj[2])]=$t1;
            $t2=TeamDAO::makeObject($match_obj[3],$g_team);
            $new_teams[intval($match_obj[3])]=$t2;
        }

        $team_ids=array_keys($new_teams);

        $team_cur=$teamModel->find(array('reference_id'=>array('$in'=>$team_ids)));

        do {
            $team_cur->next();
            $team_obj=(object)$team_cur->current();
            $team_objects[$team_obj->reference_id]=$team_obj;
            unset($new_teams[$team_obj->reference_id]);
        }
        while($team_cur->hasNext());

        if(count($new_teams)>0)
        {
            $teamModel->batchInsert(array_values($new_teams));
            foreach ($new_teams as $team_item) {
                $team_objects[$team_item->reference_id]=$team_item;
            }
        }

        // generate league objects
        $league_objects=array();
        $new_leagues=array();
        // gen leagues objects
        foreach ($leagues as $league_item) {
            if($league_item==null) continue;
            $new_leagues[intval($league_item[0])]
                =LeagueDAO::makeObject($league_item[0],$league_item[1],$league_item[2],$league_item[5],$league_item[3]);
        }

        $leagueModel=new LeagueDAO();
        $league_ids=array_keys($new_leagues);

        $league_cur=$leagueModel->find(array('reference_id'=>array('$in'=>$league_ids)));

        do {
            $league_cur->next();
            $league_obj=(object)$league_cur->current();
            $league_objects[$league_obj->reference_id]=$league_obj;
            unset($new_leagues[$league_obj->reference_id]);
        } while($league_cur->hasNext());

        if(count($new_leagues)>0) {
            $leagueModel->batchInsert(array_values($new_leagues));
            foreach ($new_leagues as $league) {
                $league_objects[$league->reference_id]=$league;
            }
        }

        // generate match objects
        $this->generateMatchObject($team_objects,$league_objects,$match);
        
    }
    private function generateMatchObject($teams,$leagues,$matchs) {

        $match_objs=array();
        foreach ($matchs as $match) {
            if($match==null) continue;

            $id=$match[0];

            $link="http://data.nowgoal.com/3in1odds/{$id}.html";

            $time_1=new DateTime();
            $time_1->setDate($match[6],$match[7]+1,$match[8]);
            $time_1->setTime($match[9],$match[10],$match[11]);

            $time_2=new DateTime();
            $time_2->setDate($match[12],$match[13]+1,$match[14]);
            $time_2->setTime($match[15],$match[16],$match[17]);

            $league_obj=$leagues[$match[1]];
            $h_team=$teams[$match[2]];
            $g_team=$teams[$match[3]];

            $match_objs[]=array(
                'reference_id'=>intval($id),
                'league_id'=>$league_obj->_id,
                'time_1'=>new \MongoDate($time_1->getTimestamp()),
                'time_2'=>new \MongoDate($time_2->getTimestamp()),
                'h_goal'=>intval($match[19]),
                'g_goal'=>intval($match[20]),
                'h_read_card'=>intval($match[23]),
                'g_read_card'=>intval($match[24]),
                'h_yellow_card'=>intval($match[25]),
                'g_yellow_card'=>intval($match[26]),
                'status'=>intval($match[18]),
                'ht_h_goal'=>$match[21]==null?0:intval($match[21]),
                'ht_g_goal'=>$match[22]==null?0:intval($match[22]),
                'created_at'=>new \MongoDate(),
                'updated_at'=>new \MongoDate(),
                'h_team'=>$h_team->_id,
                'g_team'=>$g_team->_id,
                'have_odd'=>$match[30]=='True'?1:0,
                'odd_link'=>$match[30]=='True'?$link:""
            );
        }
        $match=new MatchDAO();
        $match->batchInsert($match_objs);
    }
    private function formatData($js_data) {
        $data=explode("\r\n",$js_data);
        $number_matchs=intval(StringHelper::getStringdata($data[3],"=",";"));
        $number_leagues=intval(StringHelper::getStringdata($data[4],"=",";"));

        $datarrr=new stdClass();
        $datarrr->a_array=array();
        $datarrr->b_array=array();
        for($index=5;$index<5+$number_matchs;$index++) {
            $datarrr->a_array[]=StringHelper::getData($data[$index],"=",";");
        }
        for($index=5+$number_matchs;$index<5+$number_matchs+$number_leagues;$index++) {
            $datarrr->b_array[$index-$number_matchs-4]=StringHelper::getData($data[$index],"=",";");
        }

        return $datarrr;
    }
    private function updateMatchs($matchs,$leagues) {
        $match_objs=array();

        $match_ids=array();

        $match_odds=array();

        foreach ($matchs as $match) {
            if($match==null) continue;
            $id=$match[0];

            $match_ids[]=$id;

            $link="http://data.nowgoal.com/3in1odds/{$id}.html";
            $h_team=$match[4];

            $pos=strpos($h_team,'<');
            if($pos>0) {
                $h_team=substr($h_team,0,$pos);
            }
            $g_team=$match[5];

            $pos=strpos($g_team,'<');
            if($pos>0) {
                $g_team=substr($g_team,0,$pos);
            }

            $time_1=new DateTime();
            $time_1->setDate($match[6],$match[7]+1,$match[8]);
            $time_1->setTime($match[9],$match[10],$match[11]);

            $time_2=new DateTime();
            $time_2->setDate($match[12],$match[13]+1,$match[14]);
            $time_2->setTime($match[15],$match[16],$match[17]);

            $match_objs[$id]=array(
                'id'=>intval($id),
                'league_id'=>$leagues[$match[1]][0],
                'time_1'=>$time_1->format("Y,m,j,H,i,s"),
                'time_2'=>$time_2->format("Y,m,j,H,i,s"),
                'h_goal'=>intval($match[19]),
                'g_goal'=>intval($match[20]),
                'h_read_card'=>intval($match[23]),
                'g_read_card'=>intval($match[24]),
                'h_yellow_card'=>intval($match[25]),
                'g_yellow_card'=>intval($match[26]),
                'status'=>intval($match[18]),
                'ht_h_goal'=>$match[21]==null?0:intval($match[21]),
                'ht_g_goal'=>$match[22]==null?0:intval($match[22]),
                'created_at'=>new \MongoDate(),
                'updated_at'=>new \MongoDate(),
                'h_team'=>$h_team,
                'g_team'=>$g_team,
                'have_odd'=>$match[30]=='True'?1:0,
                'odd_link'=>$match[30]=='True'?$link:""

            );
            if($match[30]=='True') {
                $match_odds[$id]=$link;
            }
        }

        Match::getInstance()->updates(array('id'=>$match_ids,'objs'=>$match_objs));

        $exist=Match::getInstance()->getObjectsByFields(array('id'=>$match_ids));

        $existing_ids=array();

        foreach ($exist as $item) {
            $existing_ids[]=$item->id;
        }

        $new_ids=array_diff($match_ids,$existing_ids);

        $new_objs=array();

        foreach ($new_ids as $item_id) {
            $new_objs[]=$match_objs[$item_id];
        }


        Match::getInstance()->inserts(
            array('id','league_id','time_1','time_2','h_goal','g_goal','h_read_card',
                'g_read_card','h_yellow_card','g_yellow_card','status','ht_h_goal',
                'ht_g_goal','created_at','h_team','g_team','have_odd','odd_link'),
            $new_objs);

        // create BG process to update data every minute
        $commands=array();
        $parameters=array();
        foreach ($match_odds as $match_id=>$odd_link) {
            $commands[]="/background/updateodd";
            $parameters[]=array('match_id'=>$match_id,'odd_link'=>$odd_link);
        }
        if(BackgroundProcess::countRecords()==0) {
            BackgroundProcess::getInstance()->throwMultipleProcesses(array('command'=>$commands,'parameter'=>$parameters));
        }
    }
    private function updateLeagues($leagues) {
        $league_objs=array();
        $league_ids=array();
        foreach ($leagues as $leag) {

            if($leag==null) continue;

            $league_ids[]=$leag[0];

            $league_objs[$leag[0]]=array(
                'id'=>$leag[0],
                'created_at'=>array('now()'),
                'code'=>$leag[1],
                'name'=>$leag[2],
                'color'=>$leag[3],
                'link'=>$leag[5]
            );
        }
        //League::getInstance()->updates($league_ids);

        $exist=League::getInstance()->getObjectsByFields(array('id'=>$league_ids));

        $existing_ids=array();

        foreach ($exist as $item) {
            $existing_ids[]=$item->id;
        }

        $new_ids=array_diff($league_ids,$existing_ids);

        $new_ids=array_unique($new_ids);

        $new_objs=array();

        foreach ($new_ids as $item_id) {
            $new_objs[]=$league_objs[$item_id];
        }
        League::getInstance()->inserts(array('id','created_at','code','name','color','link'),$new_objs);

    }

}