<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 4/24/15
 * Time: 09:30
 */

namespace App\Logics\base;


abstract class OddServiceBase {
    public abstract function processData($match=null,$match_odd=null);
}