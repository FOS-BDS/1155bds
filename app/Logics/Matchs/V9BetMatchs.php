<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 5/5/15
 * Time: 14:44
 */

namespace App\Logics\Matchs;


use App\Libraries\Constants;
use App\Logics\base\MatchDataServiceBase;

class V9BetMatchs extends MatchDataServiceBase {
    public function processData($data=null)
    {
        $data_json=json_decode($data);
        $data_json=(array)$data_json;
        if(array_key_exists(Constants::ONTIME_KEY,$data_json)) {
            $match_data=$data_json[Constants::ONTIME_KEY];
        } elseif(array_key_exists(Constants::OFFTIME_KEY,$data_json)) {
            $match_data=$data_json[Constants::OFFTIME_KEY];
        }

        // match data processing

    }
}