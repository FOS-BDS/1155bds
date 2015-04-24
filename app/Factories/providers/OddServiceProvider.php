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
use App\Logics\Odds\NowGoalOdds;

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
        if(InputHelper::getDataSource()==Constants::SOURCE_NOWGOAL) {
            return new NowGoalOdds();
        } else {
            throw new APIException("Invalid Datasource");
        }
    }

}