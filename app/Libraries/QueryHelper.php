<?php

namespace App\Libraries;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Created by PhpStorm.
 * User: michael
 * Date: 12/25/14
 * Time: 12:14
 */

class QueryHelper {
    public static function LogQueries()
    {
        if($_ENV['APP_ENV']=='local') {
            // only write query log when running on debug mode
            $queries = DB::getQueryLog();
            Log::info(json_encode($queries));
        }
    }
} 