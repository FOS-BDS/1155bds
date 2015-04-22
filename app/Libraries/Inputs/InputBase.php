<?php
/**
 * Created by PhpStorm.
 * User: Hieutrieu
 * Date: 4/21/2015
 * Time: 2:58 PM
 */
namespace App\Libraries\Inputs;
use ReflectionClass;

abstract class InputBase {
    public $_folder = 'inputs/';
    public $_view = 'default';

    public function __construct($request){

    }
    /**
     * @return string
     */
    public function getName() {
        $ref = new ReflectionClass($this);
        return $ref->getShortName();
    }

    public function renderView(){
        try {
            $className = $this->getName();
            return view($this->_folder.$this->_view, array('className' => $className))->render();
        } catch(\Exception $e) {
            debug($e->getMessage());
        }
    }

}