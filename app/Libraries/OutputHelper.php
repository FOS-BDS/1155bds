<?php
/**
 * Created by PhpStorm.
 * User: Hieutrieu
 * Date: 5/19/2015
 * Time: 10:02 AM
 */

namespace App\Libraries;


class OutputHelper {
    private static $instance = null;
    private $rules = array();
    private $datas = array();

    const CONDITION_LEFT = 'condition_left';
    const CONDITION_RIGHT = 'condition_right';


    public static function getInstance() {
        if(self::$instance == null) {
            self::$instance = new OutputHelper();
        }
        return self::$instance;
    }

    /**
     * @param array $data
     * @return array
     */
    public function setData(array $rules) {
        return $this->rules = $rules;
    }

    public function getCondition() {
        foreach($this->rules as $rule) {
            $ruleId = (string) $rule['_id'];
            $userId = (string) $rule['user_id'];
            if (isset($rule[self::CONDITION_LEFT])) {
                $this->datas[$userId][$ruleId][self::CONDITION_LEFT] = $this->parserCondition($rule[self::CONDITION_LEFT]);
            }
            if (isset($rule[self::CONDITION_RIGHT])) {
                $this->datas[$userId][$ruleId][self::CONDITION_RIGHT] = $this->parserCondition($rule[self::CONDITION_RIGHT]);
            }
        }

    }

    private function parserCondition(array $conditionData) {
        if($conditionData['type'] == Constants::TYPE_RULE) {
            debug($conditionData);
        }
    }

    public function getData() {
        $datas = $this->getCondition();

        debug($this->datas);
    }

}