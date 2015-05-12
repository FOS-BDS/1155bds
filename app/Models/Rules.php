<?php
namespace App\Models;


use App\Libraries\Constants;
use App\Models\base\CollectionBase;
use MongoId;

class Rules extends CollectionBase {
    public function __construct() {
        parent::__construct("rules"); // TODO: Change the autogenerated stub
    }

    public static function makeObject($params) {
        $rule = parent::formatObject();
        if(isset($params['type'])) {
            // Rules
            if($params['type'] == Constants::TYPE_RULE) {
                $conditionLeftData = explode(':', $params['conditions'][0]);
                $conditionRightData = explode(':', $params['conditions'][1]);
                $data['condition_left'] = array(
                    'id' => new MongoId($conditionLeftData[0]),
                    'type' => $conditionLeftData[1],
                );
                $data['condition_right'] = array(
                    'id' => new MongoId($conditionRightData[0]),
                    'type' => $conditionRightData[1],
                );

                $rule->condition_left = $data['condition_left'];
                $rule->condition_right = $data['condition_right'];
                $rule->rule_color = $params['rule_color'];
                $rule->status = $params['status'];
            } elseif($params['type'] == Constants::TYPE_CONDITION) {
                $rule->field = $params['field'];
                if($params['time_type'] == Constants::TIME_FULL) {
                    $rule->time = array(
                        'type' => $params['time_type'],
                        'value' => $params['time_value'],
                    );
                } else {
                    $rule->time = array(
                        'type' => $params['time_type'],
                        'value' => $params['time_type'],
                    );
                }
                $rule->condition_values = $params['condition_values'];
                $rule->odd_type = $params['odd_type'];
            }
            $rule->name = $params['name'];
            $rule->operator = $params['operator'];
            $rule->description = $params['description'];
            $rule->type = $params['type'];

        }
        return $rule;
    }
}
