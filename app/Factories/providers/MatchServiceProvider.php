<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 4/24/15
 * Time: 09:46
 */

namespace App\Factories\providers;


use App\Libraries\APIException;
use App\Libraries\Constants;
use App\Libraries\InputHelper;
use App\Logics\Matchs\NowGoalMatchs;
use App\Logics\base\MatchDataServiceBase;

class MatchServiceProvider implements IServiceProvider {
    private static $instance;
    /**
     * @return  MatchServiceProvider
     */
    public static function getInstance()
    {
        if(self::$instance==null) {
            self::$instance=new MatchServiceProvider();
        }
        return self::$instance;
    }

    /**
     * @return MatchDataServiceBase
     * @throws APIException
     */
    public function getServiceInstance()
    {
        if(InputHelper::getDataSource()==Constants::SOURCE_NOWGOAL) {
            return new NowGoalMatchs();
        } else {
            throw new APIException("Invalid Data Source");
        }
    }

}