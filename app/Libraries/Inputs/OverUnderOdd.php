<?php
/**
 * Created by PhpStorm.
 * User: Hieutrieu
 * Date: 4/21/2015
 * Time: 2:58 PM
 */
namespace App\Libraries\Inputs;
class OverUnderOdd extends InputBase {
    public $_view = 'over_under_odd';
    public function renderView($params){
        try {
            return parent::renderView($params);
        } catch(\Exception $e) {
            debug($e->getMessage());
        }
    }
}