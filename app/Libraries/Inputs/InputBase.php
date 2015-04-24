<?php
/**
 * Created by PhpStorm.
 * User: Hieutrieu
 * Date: 4/21/2015
 * Time: 2:58 PM
 */
namespace App\Libraries\Inputs;
use App\Models\Rules;
use ReflectionClass;
use MongoId;

abstract class InputBase {
    public $_folderView = 'admin.rules_renders.views.';
    public $_folderForm = 'admin.rules_renders.forms.';
    public $_viewForm = 'default';
    public $_viewList = 'rules';
    public $_attributes = array();

    public function __construct($request){
        $this->_attributes = $request->all();
    }
    /**
     * @return string
     */
    public function getName() {
        $ref = new ReflectionClass($this);
        return $ref->getShortName();
    }

    /**
     * @return html view
     */
    public function renderView(){
        try {
            $ruleModels = new Rules();
            $className = $this->getName();
            $supplierId = $this->_attributes['supplier_id'];
            $rules = $ruleModels->find(array('class_name'=>$className,'supplier_id'=>$supplierId));
            $rules = iterator_to_array($rules);
            return view($this->_folderView.$this->_viewList, array('className' => $className, 'supplierId' => $supplierId))->with('rules', $rules)->render();
        } catch(\Exception $e) {
            debug($e->getMessage());
        }
    }

    /**
     * @return html form
     */
    public function renderForm(){
        try {
            if(isset($this->_attributes['_id']) && $this->_attributes['_id']) {
                $ruleModel = new Rules();
                $this->_attributes = $ruleModel->findOne(array('_id' => new MongoId($this->_attributes['_id'])));
            }
            $className = $this->getName();
            return view($this->_folderForm.$this->_viewForm, array('className' => $className))->with('params', $this->_attributes)->render();
        } catch(\Exception $e) {
            debug($e->getMessage());
        }
    }

    public function save() {
        $ruleModel = new Rules();
        if(isset($this->_attributes['_id']) && $this->_attributes['_id']) {
            $mongoId = new MongoId($this->_attributes['_id']);
            unset($this->_attributes['_id']);
            return $ruleModel->update(array('_id' => $mongoId),$this->_attributes,array("upsert" => true));
        } else {
            unset($this->_attributes['_id']);
            return $ruleModel->insert($this->_attributes);
        }
    }

    public function setAttributes($attributes) {
        $this->_attributes = $attributes;
    }

}