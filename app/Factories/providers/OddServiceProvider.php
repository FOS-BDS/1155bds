<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 4/24/15
 * Time: 09:47
 */

namespace App\Factories\providers;


use App\Libraries\APIException;
use App\Libraries\Constants;
use App\Libraries\InputHelper;
use App\Logics\Matchs\V9BetMatchs;
use App\Logics\Odds\NowGoalOdds;
use App\Logics\Odds\V9BetOdds;

class OddServiceProvider implements IServiceProvider{
    private static $instance;
    /**
     * @return  mixed Correspond service instance
     */
    public static function  getInstance()
    {
        if(self::$instance==null) {
            self::$instance=new OddServiceProvider();
        }
        return self::$instance;
    }

    public function getServiceInstance()
    {
        if(InputHelper::getDataSource()==Constants::SOURCE_V9BET) {
            return new V9BetOdds();
        } else {
            throw new APIException("Invalid Datasource");
        }
    }

}