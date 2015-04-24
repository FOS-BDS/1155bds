<?php

namespace App\Libraries;
use Illuminate\Http\Request;

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
}