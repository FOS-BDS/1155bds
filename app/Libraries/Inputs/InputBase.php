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
            $className = $this->getName();
            $supplierId = $this->_attributes['supplier_id'];
            $rules = Rules::where('class_name', '=', $className)->where('supplier_id', '=', $supplierId)->take(100)->get();
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
                $rule = Rules::find($this->_attributes['_id']);
                $params = $rule->getAttributes();
            }
            $className = $this->getName();
            return view($this->_folderForm.$this->_viewForm, array('className' => $className))->with('params', $this->_attributes)->render();
        } catch(\Exception $e) {
            debug($e->getMessage());
        }
    }

    public function save() {
        if(isset($this->_attributes['_id']) && $this->_attributes['_id']) {
            $ruleModel = Rules::find($this->_attributes['_id']);
        } else {
            unset($this->_attributes['_id']);
            $ruleModel = new Rules();
        }
        foreach($this->_attributes as $attribute => $value) {
            if(!in_array($attribute, array('_token'))) {
                $ruleModel->$attribute = $value;
            }
        }

        return $ruleModel->save();
    }

    public function setAttributes($attributes) {
        $this->_attributes = $attributes;
    }

}