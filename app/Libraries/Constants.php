<?php
namespace App\Libraries;

/**
 * Created by PhpStorm.
 * User: HUNG NGUYEN
 * Date: 5/27/14
 * Time: 11:28 PM
 */
class Constants
{
    const DATA_SOURCE='data_source';
    const SOURCE_NOWGOAL='NOWGOAL';
    const SOURCE_V9BET='V9BET';

    const ONTIME_KEY='i-ots';
    const OFFTIME_KEY='ot';

    const TIME_PRE_MATCH=-1;
    const TIME_HT=-2;
    const TIME_FULL=-3;

    const ODD_1X2="1X2";
    const ODD_1X21ST="1X21ST";
    const ODD_AH="AH";
    const ODD_AH1ST="AH1ST";
    const ODD_OU="OU";
    const ODD_OU1ST="OU1ST";

    const TYPE_RULE         = 'RULE';
    const TYPE_CONDITION    = 'CONDITION';

    const FIELD_HOME = 'home';
    const FIELD_DRAW = 'draw';
    const FIELD_AWAY = 'away';

    const TYPE_USER  = 'user';
    const TYPE_ADMIN = 'admin';
    const OPERATOR_IN = '$in';
    const OPERATOR_NIN = '$nin';
    const OPERATOR_AND = '$and';
    const OPERATOR_OR = '$or';
    const OPERATOR_LT = '$lt';
    const OPERATOR_LTE = '$lte';
    const OPERATOR_GT = '$gt';
    const OPERATOR_GTE = '$gte';
    const OPERATOR_EQ = '$eq';
    const OPERATOR_NE = '$ne';


    const STATUS_PUBLISH = 1;
    const STATUS_UNPUBLISH = 0;
    const STATUS_MAIN = 3;
    const STATUS_INTERMEDIATE = 2;

    const CACHE_NEWEST_ODDS="NEWEST_ODD";
    const CACHE_ODDS_VERSION="ODD_VERSION";

    const  CACHE_ONTIME_MATCH="ONTIME_MATCH";

    const PRIORITY_HIGHT    =3;
    const PRIORITY_MIDDLE   =2;
    const PEIORITY_SLOW     =1;
    const PROCESS_WAITING = 'waiting';
    const PROCESS_PROCESSING = "processing";

    const LIMIT_PERPAGE = 20;

    const MATCH_STATUS_RUNNING=1;
    const MATCH_STATUS_NOT_STARTED=0;
    const MATCH_STATUS_FT=-1;

    const OFFSET_TIME=11;
}