<?php

namespace App\Libraries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

/**
 * Created by PhpStorm.
 * User: HUNG NGUYEN
 * Date: 4/7/14
 * Time: 10:34 PM
 */
class InputHelper
{
    private static $input;
    private static $access_token;
    public static function setInputArray( $input ) {
        self::$input = $input;
    }

    public static function exist($name) {
        return array_key_exists($name, self::$input);
    }

    public static function getInput($name, $require, $default_value = null)
    {
        if (array_key_exists($name, self::$input)) {
            return self::$input[$name];
        } else {
            if (!$require) {
                return $default_value;
            } else {
                throw new APIException("$name Invalid", APIException::ERRORCODE_LACK_PARAMETER);
            }
        }
    }

    public static function getAccessToken()
    {
        $request=Request::capture();
        if ( self::$access_token ) return self::$access_token;

        $headers = $request->headers->all();

        if ( $request->has('access_token')) {
            return $request->input('access_token');
        } elseif ( $request->has('accesstoken')) {
            return $request->input('accesstoken');
        } elseif (array_key_exists('access_token', $headers)) {
            return $headers['access_token'][0];
        } elseif (array_key_exists('accesstoken', $headers)) {
            return $headers['accesstoken'][0];
        } else {
            return null;
        }
    }
    public static function setAccessToken( $token ) {
        self::$access_token = $token;
    }
    public static function getFile($filename,$require=false)
    {
        $request=Request::capture();
        if($request->hasFile($filename)) {
            return $request->file($filename);
        } elseif($require) {
            throw new APIException("$filename not attachment", APIException::ERRORCODE_LACK_PARAMETER);
        } else {
            return null;
        }
    }
    public static function getAllInput()
    {
        return self::$input;
    }
    public static function getDataSource() {
        if(array_key_exists(Constants::DATA_SOURCE,self::$input)) {
            return self::$input[Constants::DATA_SOURCE];
        } else {
            return Constants::SOURCE_NOWGOAL;// default is nowgoal
        }
    }

    /**
     * Create conditions
     */
    public static function getAllOpearators() {
        return array(
            '$or' => Lang::get('app.or'),
            '$and' => Lang::get('app.and'),
            '$lt' => Lang::get('app.less'),
            '$lte' => Lang::get('app.less_or_equal'),
            '$gt' => Lang::get('app.greater'),
            '$gte' => Lang::get('app.greater_or_equal'),
            '$eq' => Lang::get('app.equal'),
            '$ne' => Lang::get('app.not_equal'),
            Constants::OPERATOR_IN => Lang::get('app.in_array'),
            Constants::OPERATOR_NIN => Lang::get('app.not_in_array'),
        );
    }
    public static function getOperator($operator) {
        $operators = self::getAllOpearators();
        if(isset($operators[$operator])) {
            return $operators[$operator];
        } else {
            return false;
        }
    }
    public static function getField($field) {
        switch($field) {
            case Constants::FIELD_HOME:
                return Lang::get('app.home');
            case Constants::FIELD_DRAW:
                return Lang::get('app.draw');
            case Constants::FIELD_AWAY:
                return Lang::get('app.away');
        }
    }

    public static function getConditionValue($oparator, $values) {
        switch($oparator) {
            case Constants::OPERATOR_IN:
            case Constants::OPERATOR_NIN:
                return '['.implode(' ... ', $values).']';
            default:
                return $values['value_first'];
        }
    }

    public static function getOddType($oddType) {
        switch($oddType) {
            case Constants::ODD_1X2:
                return Lang::get('app.fulltime').':'.Lang::get('app.odd_1x2');
            case Constants::ODD_AH:
                return Lang::get('app.fulltime').':'.Lang::get('app.odd_ah');
            case Constants::ODD_OU:
                return Lang::get('app.fulltime').':'.Lang::get('app.odd_ou');
            case Constants::ODD_1X21ST:
                return Lang::get('app.firsthalf').':'.Lang::get('app.odd_1x2');
            case Constants::ODD_AH1ST:
                return Lang::get('app.firsthalf').':'.Lang::get('app.odd_ah');
            case Constants::ODD_OU1ST:
                return Lang::get('app.firsthalf').':'.Lang::get('app.odd_ou');
        }
    }

    public static function getRuleOparators() {
        $oparators = array(
            Constants::OPERATOR_AND => Lang::get('app.and'),
            Constants::OPERATOR_OR => Lang::get('app.or'),
        );
        return $oparators;
    }
    public static function getConditionOparators() {
        $oparators = self::getAllOpearators();
        unset($oparators['$or']);
        unset($oparators['$and']);
        return $oparators;
    }

    public static function getTime($time) {
        $timeType = $time['time']['type'];
        switch($timeType) {
            case Constants::TIME_PRE_MATCH:
                return Lang::get('app.beforetime');
            case Constants::TIME_HT:
                return Lang::get('app.halftime');
            case Constants::TIME_FULL:
                return Lang::get('app.attime').' <i class="label label-danger">'.$time['time']['value'].'</i>';
        }
    }
}
