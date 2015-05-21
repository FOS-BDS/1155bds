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
use App\DAO\OddDAO;
use App\Http\Controllers\BaseController;
use App\Libraries\ResponseBuilder;

class OddController extends BaseController{
    public function getOddView($reference_id,$type) {
        $matchDao=new MatchDAO();

        $matchObj=$matchDao->findOne(array('reference_id'=>intval($reference_id)));
        if($matchObj==null) {
            return ResponseBuilder::success(array('error'=>1,'message'=>'Match not found'));
        }
        $matchObj=(object)$matchObj;
        $leagueDao=new LeagueDAO();
        $leagueobj=$leagueDao->findOne(array('_id'=>$matchObj->league_id));
        if($leagueobj==null) {
            return ResponseBuilder::success(array('error'=>1,'message'=>'League not found'));
        }
        $leagueobj=(object)$leagueobj;
        if(strtoupper($type)=="FULLTIME") {
            $type1x2="1X2";
            $typeah="AH";
            $typeou="OU";
            $type_title=" Tỉ lệ cả trận";
        } else {
            $type1x2="1X21ST";
            $typeah="AH1ST";
            $typeou="OU1ST";
            $type_title="Tỉ lệ hiệp 1";
        }
        $oddDao=new OddDAO();
        $odd1x2=$oddDao->find(array('match_id'=>$matchObj->_id,'type'=>$type1x2))->sort(array('_id'=>-1));
        $oddah=$oddDao->find(array('match_id'=>$matchObj->_id,'type'=>$typeah))->sort(array('_id'=>-1));
        $oddou=$oddDao->find(array('match_id'=>$matchObj->_id,'type'=>$typeou))->sort(array('_id'=>-1));

        return View('users.odd.index',array(
            'first_odd'=>iterator_to_array($odd1x2),
            'second_odd'=>iterator_to_array($oddah),
            'third_odd'=>iterator_to_array($oddou),
            'match'=>$matchObj,
            'league'=>$leagueobj,
            'type_title'=>$type_title
        ));
    }
    public function getOddData($reference_id,$type) {

    }
}