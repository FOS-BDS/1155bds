<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 4/23/15
 * Time: 14:58
 */

namespace App\Http\Controllers\Data;


use App\Factories\providers\MatchServiceProvider;
use App\Http\Controllers\BaseController;

class MatchController extends BaseController{
    public function postMatchs() {
        MatchServiceProvider::getInstance()->getServiceInstance()->processData();
    }
}