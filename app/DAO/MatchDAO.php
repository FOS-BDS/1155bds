<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 4/23/15
 * Time: 15:03
 */

namespace App\DAO;


use App\DAO\base\CollectionBase;

class MatchDAO extends CollectionBase {
    public function __construct()
    {
        parent::__construct("matchs"); // TODO: Change the autogenerated stub
    }
    public static function makeObject($reference_id,$h_name,$g_name,$date,$time,
                                      $h_goal,$g_goal,$h_yellow,$g_yellow,$h_red,$g_red,$started) {
        $new_obj=parent::formatObject();
        $new_obj->reference_id=intval($reference_id);
        $new_obj->h_name=$h_name;
        $new_obj->g_name=$g_name;
        $new_obj->start_date=$date;
        $new_obj->time=$time;
        $new_obj->h_goal=$h_goal==""?0:intval($h_goal);
        $new_obj->g_goal=$g_goal==""?0:intval($g_goal);
        $new_obj->h_yellow=$h_yellow==""?0:intval($h_yellow);
        $new_obj->g_yellow=$g_yellow==""?0:intval($g_yellow);
        $new_obj->h_red=$h_red==""?0:intval($h_red);
        $new_obj->g_red=$g_red==""?0:intval($g_red);
        $new_obj->started=intval($started);

        return $new_obj;
    }

}