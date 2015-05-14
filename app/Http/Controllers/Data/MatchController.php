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
use App\Libraries\ResponseBuilder;

class MatchController extends BaseController{
    public function postMatchs() {
        try {
            MatchServiceProvider::getInstance()->getServiceInstance()->processData();
        } catch(\Exception $e) {
            return ResponseBuilder::error($e);
        }
    }
    public function getMatchedMatch() {
        try {
            MatchServiceProvider::getInstance()->getServiceInstance()->getMatchedMatch();
        } catch(\Exception $e) {
            return ResponseBuilder::error($e);
        }
    }
    public function getMatchedMatchFromNewOdd() {
        try {
            MatchServiceProvider::getInstance()->getServiceInstance()->getMatchedMatchFromNewOdd();
        } catch(\Exception $e) {
            return ResponseBuilder::error($e);
        }
    }
}