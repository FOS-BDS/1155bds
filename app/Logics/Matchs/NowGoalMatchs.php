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
use App\Models\Leagues;
use App\Models\Teams;
use Exception;
use Illuminate\Support\Facades\Log;
use stdClass;

class NowGoalMatchs extends MatchDataServiceBase{
    public function processData()
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

        $teamModel=new Teams();
        $team_objects=array();
        // gen team objects
        $new_teams=array();
        foreach ($match as $match_obj) {
            if($match_obj==null) continue;
            $match_obj[1]=$leagues[$match_obj[1]][0];
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
            $t1=Teams::makeObject($match_obj[2],$h_team);
            $new_teams[intval($match_obj[2])]=$t1;
            $t2=Teams::makeObject($match_obj[3],$g_team);
            $new_teams[intval($match_obj[3])]=$t2;
        }

        $team_ids=array_keys($new_teams);

        $team_cur=$teamModel->find(array('reference_id'=>array('$in'=>$team_ids)));
        $team_cur->next();

        while($team_cur->hasNext()) {
            $team_obj=$team_cur->current();
            $team_objects[$team_obj->reference_id]=$team_obj;
            unset($new_teams[$team_obj->reference_id]);
            $team_cur->next();
        }
        if(count($new_teams)>0)
        {
            $teamModel->batchInsert(array_values($new_teams));
            foreach ($new_teams as $team_item) {
                $team_objects[$team_item->reference_id]=$team_item;
            }
        }

        $league_objects=array();
        $new_leagues=array();
        // gen leagues objects
        foreach ($leagues as $league_item) {
            $new_teams[intval($league_item[0])]
                =Leagues::makeObject($league_item[0],$league_item[1],$league_item[2],$league_item[5],$league_item[3]);
        }

        $leagueModel=new Leagues();
        $league_ids=array_keys($new_teams);

        $league_cur=$leagueModel->find(array('reference_id'=>array('$in'=>$league_ids)));

        // filter existing and new match
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
                'id'=>$id,
                'league_id'=>$leagues[$match[1]][0],
                'time_1'=>$time_1->format("Y,m,j,H,i,s"),
                'time_2'=>$time_2->format("Y,m,j,H,i,s"),
                'h_goal'=>$match[19],
                'g_goal'=>$match[20],
                'h_read_card'=>$match[23],
                'g_read_card'=>$match[24],
                'h_yellow_card'=>$match[25],
                'g_yellow_card'=>$match[26],
                'status'=>$match[18],
                'ht_h_goal'=>$match[21]==null?0:$match[21],
                'ht_g_goal'=>$match[22]==null?0:$match[22],
                'created_at'=>array('now()'),
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