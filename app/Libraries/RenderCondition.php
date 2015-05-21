<?php
/**
 * Created by PhpStorm.
 * User: Hieutrieu
 * Date: 5/20/2015
 * Time: 9:53 AM
 */

namespace App\Libraries;


class RenderCondition {
    private static $instance = null;
    private $conditions = array();
    private $rule = array();
    private $query = null;

    public static function getInstance($rule)
    {
        if (self::$instance == null) {
            self::$instance = new RenderCondition($rule);
        }
        return self::$instance;
    }

    /**
     * @param array $rule
     */
    public function __construct(array $rule) {
        $this->rule = $rule;
    }

    public function parserCondition() {
        if($this->rule['type'] == Constants::TYPE_CONDITION) {
            $this->parserAttribute();
            return $this->buildQuery();
        }
        return 0;
    }

    public function parserAttribute(){
        if(isset($this->rule['time'])) {
            $this->parserTime($this->rule['time']);
        }
        if(isset($this->rule['field'])) {
            $this->parserField($this->rule['field']);
        }

        if(isset($this->rule['odd_type']) && $this->rule['operator'] && isset($this->rule['condition_values'])) {
            //$this->parserOddType($this->rule['odd_type'], $this->rule['operator'], $this->rule['condition_values']);
        }
    }

    public function parserTime($time) {
        switch($time['type']) {
            case Constants::TIME_FULL:
            case Constants::TIME_HT:
            case Constants::TIME_PRE_MATCH:
                $this->conditions[] = array(
                    'time.value' => array(Constants::OPERATOR_EQ => $time['value'])
                );
                break;

        }
        return $this->conditions;
    }

    public function parserField($field) {
        $this->conditions[] = array(
            'field' => $field
        );
        return $this->conditions;
    }

    public function parserOddType($oddType, $operator, $conditions) {
        switch($operator) {
            case Constants::OPERATOR_IN:
                $this->conditions[] = array(
                    $oddType => array(
                        array(Constants::OPERATOR_GTE => $conditions['value_first']),
                        array(Constants::OPERATOR_LTE=> $conditions['value_last'])
                    )
                );
                break;
            case Constants::OPERATOR_NIN:
                $this->conditions[] = array(
                    $oddType => array(
                        array(Constants::OPERATOR_LT => $conditions['value_first']),
                        array(Constants::OPERATOR_GT=> $conditions['value_last'])
                    )
                );
                break;
            default:
                $this->conditions[] = array(
                    $oddType => array($operator => $conditions['value_first']),
                );

        }
        return $this->conditions;
    }

    private function buildQuery(){
        //$this->query = implode(Constants::OPERATOR_AND, $this->conditions);
        return $this->conditions[0];
    }
}