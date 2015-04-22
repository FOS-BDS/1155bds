<?php
/**
 * Created by PhpStorm.
 * User: Hieutrieu
 * Date: 4/21/2015
 * Time: 2:58 PM
 */
namespace App\Libraries\Inputs;
use ReflectionClass;
use Exception;

class InputView {
    public $_refClass = null;
    public $_folderClass = "App\Libraries\Inputs\\";
    public function __construct($request){
        try {
            $className = ucfirst($request->get('class_name'));
            $classPath = $this->_folderClass . $className;
            $r = new ReflectionClass($classPath);
            $this->_refClass = $r->newInstanceArgs([$request]);
        } catch(Exception $e) {
            printf($e->getMessage());
        }
    }
    public function render() {
        if($this->_refClass !== null) {
            return $this->_refClass->renderView();
        }
    }
    public function setAttributes($request) {
        if($this->_refClass !== null) {
            $this->_refClass->setAttributes($request);
        }
    }
    public function save() {
        if($this->_refClass !== null) {
            return $this->_refClass->save();
        }
    }
}