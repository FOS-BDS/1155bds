<?php
/**
 * Created by PhpStorm.
 * User: Hieutrieu
 * Date: 4/21/2015
 * Time: 2:58 PM
 */
namespace App\Libraries\Inputs;
use App\Libraries\Inputs\InputBase;
class Xxx extends InputBase {
    public $_view = 'xxx';

    public function renderView(){
        try {
            return parent::renderView();
        } catch(\Exception $e) {
            debug($e->getMessage());
        }
    }
}