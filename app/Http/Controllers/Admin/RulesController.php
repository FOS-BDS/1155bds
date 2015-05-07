<?php
namespace App\Http\Controllers\Admin;

use App\Libraries\InputHelper;
use App\Models\Rules;
use Illuminate\Http\Request;
use MongoId;
use MongoRegex;

class RulesController extends AdminController {
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	//public function __construct() {
		//$this->middleware('auth');
	//}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index() {
        $ruleModels = new Rules();
        $rules = $ruleModels->find(array());
        $rules = iterator_to_array($rules);
        return view('admin.rules.index', ['rules' => $rules]);
	}

    public function getRules(Request $request) {
        $type = $request->get('type', null);
        $ruleModels = new Rules();
        $rules = $ruleModels->find(array('type' => $type));
        $rules = iterator_to_array($rules);
        if($type == Rules::TYPE_RULE) {
            $view = 'admin.rules.rules';
        } else {
            $view = 'admin.rules.conditions';
        }
        return view($view)->with('rules', $rules)->render();
    }

    public function editRule(Request $request) {
        $type = $request->get('type', null);
        $params = $request->all();
        if($type == Rules::TYPE_RULE) {
            $conditions = InputHelper::getConditions();
            if (isset($params['_id']) && $params['_id']) {
                $ruleModel = new Rules();
                $params = $ruleModel->findOne(array('_id' => new MongoId($params['_id'])));
            }
            $conditionLeftId = isset($params['condition_left']['id']) ? $params['condition_left']['id'] : '';
            $conditionLeftType = isset($params['condition_left']['type']) ? $params['condition_left']['type'] : '';
            $conditionRightId = isset($params['condition_right']['id']) ? $params['condition_right']['id'] : '';
            $conditionRightType = isset($params['condition_right']['type']) ? $params['condition_right']['type'] : '';
            $params['condition_left_display'] = isset($params['condition_right']['name']) ? $params['condition_right']['name'] : '';
            $params['condition_left'] = $conditionLeftId . ':' . $conditionLeftType;
            $params['condition_right_display'] = isset($params['condition_right']['name']) ? $params['condition_right']['name'] : '';
            $params['condition_right'] = $conditionRightId . ':' . $conditionRightType;
            return view('admin.rules.rule_form', ['conditions' => $conditions])->with('params', $params)->render();
        } else {
            $conditions = InputHelper::getConditions();
            if (isset($params['_id']) && $params['_id']) {
                $ruleModel = new Rules();
                $params = $ruleModel->findOne(array('_id' => new MongoId($params['_id'])));
            }
            $conditionLeftId = isset($params['condition_left']['id']) ? $params['condition_left']['id'] : '';
            $conditionLeftType = isset($params['condition_left']['type']) ? $params['condition_left']['type'] : '';
            $conditionRightId = isset($params['condition_right']['id']) ? $params['condition_right']['id'] : '';
            $conditionRightType = isset($params['condition_right']['type']) ? $params['condition_right']['type'] : '';
            $params['condition_left_display'] = isset($params['condition_right']['name']) ? $params['condition_right']['name'] : '';
            $params['condition_left'] = $conditionLeftId . ':' . $conditionLeftType;
            $params['condition_right_display'] = isset($params['condition_right']['name']) ? $params['condition_right']['name'] : '';
            $params['condition_right'] = $conditionRightId . ':' . $conditionRightType;
            return view('admin.rules.condition_form', ['conditions' => $conditions])->with('params', $params)->render();
        }
    }

    public function save(Request $request) {
        $params = $request->all();
        $conditionLeftData  = explode(':', $params['condition_left']);
        $conditionRightData = explode(':', $params['condition_right']);
        $data['condition_left']    = array(
            'id'    => $conditionLeftData[0],
            'name'  => $params['condition_left_display'],
            'type'  => $conditionLeftData[1],
        );
        $data['condition_right']   = array(
            'id'    => $conditionRightData[0],
            'name'  => $params['condition_right_display'],
            'type'  => $conditionRightData[1],
        );
        $data['name']              = $params['name'];
        $data['operator']          = $params['operator'];
        $data['description']       = $params['description'];
        $data['type']              = $params['type'];

        $ruleModel = new Rules();

        if(isset($params['_id']) && $params['_id']) {
            $mongoId = new MongoId($params['_id']);
            return $ruleModel->update(array('_id' => $mongoId),$data,array("upsert" => true));
        } else {
            return $ruleModel->insert($data);
        }
    }

    public function getConditionAndRules(Request $request) {
        $q = $request->get('q', null);
        $ruleModel = new Rules();
        $values = array();
        if($q != null) {
            $regex = new MongoRegex("/$q/i");
            $datas = $ruleModel->find(array('name' => $regex));
        } else {
            $datas = $ruleModel->find();
        }
        $datas = iterator_to_array($datas);
        foreach ($datas as $data) {
            $id = (array) $data['_id'];
            $values[] = array(
                'id' => $id['$id'].':'.Rules::TYPE_RULE,
                'name' => $data['name'].'('.$data['description'].')',
            );
        }
        return json_encode($values);
    }
}
