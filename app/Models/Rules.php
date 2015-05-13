<?php
namespace App\Models;

use App\DAO\RuleDAO;
use App\Libraries\Constants;
use MongoId;

class Rules extends ModelBase {
    public $field;
    public $operator;
    public $name;
    public $description;
    /**
     * @var MongoId $left_condition_id
     */
    public  $left_condition_id;
    /**
     * @var MongoId $right_condition_id
     */
    public $right_condition_id;
    /**
     * @var Rules left_condition;
     */
    public $left_condition;
    /**
     * @var Rules right_condition;
     */
    public $right_condition;
    public $time;
    public $first_value;
    public $second_value;
    public $odd_type;
    public $status;
    public $type;
    public $rule_color;

    /**
     * @var bool
     */
    public $needed_update=false;
    /**
     * @var array
     */
    public $parent_rules=array();
    /**
     * @var array
     */
    public $match_matched=array();
    /**
     * @var String
     */
    public $matched_md5;

    /**
     * @var bool
     */
    private $is_loaded_child=false;

    public function initFromDBObject($db_object,$load_child_obj=false)
    {
        if(!is_object($db_object)) $db_object=(object)$db_object;

        $this->name=$db_object->name;
        $this->description=$db_object->description;
        $this->status=$db_object->status;
        $this->operator=$db_object->operator;
        $this->needed_update=$db_object->needed_update;
        $this->parent_rules=$db_object->parent_rules;
        $this->match_matched=$db_object->match_matched;
        $this->matched_md5=$db_object->matched_md5;

        if($db_object->type==Constants::TYPE_CONDITION) {
            $this->field=$db_object->field;
            $this->first_value=$db_object->condition_values->first_value;
            $this->second_value=$db_object->condition_values->second_value;
            $this->time=$db_object->time->value;
        } elseif($db_object->type==Constants::TYPE_RULE) {
            $this->rule_color=$db_object->rule_color;
            $this->left_condition_id=$db_object->condition_left->id;
            $this->right_condition_id=$db_object->condition_right->id;

            if($load_child_obj) {
                $this->loadChildRule();
            }
        }
    }
    private function loadChildRule() {
        $this->is_loaded_child=true;
        $ruleDao=new RuleDAO();

        // load left condition
        $left_condition=new Rules();
        $left_cond_obj=$ruleDao->findOne(array('id'=>$this->left_condition_id));
        if($left_cond_obj!=null) {
            $left_condition->initFromDBObject((object)$left_cond_obj);
        } else {
            $left_condition=null;
        }
        $this->left_condition=$left_condition;

        // load right condition
        $right_condition=new Rules();
        $right_cond_obj=$ruleDao->findOne(array('id'=>$this->right_condition_id));
        if($left_cond_obj!=null) {
            $right_condition->initFromDBObject((object)$right_cond_obj);
        } else {
            $right_condition=null;
        }
        $this->right_condition=$right_condition;
    }

    /**
     * @return array
     */
    public function process() {
        if($this->needed_update) {
            $match_matched=array();
            if($this->type==Constants::TYPE_CONDITION) {

            } elseif($this->type==Constants::TYPE_RULE) {
                $left_match_matched=array();
                if($this->left_condition!=null &&
                    $this->left_condition->needed_update) {
                    $left_match_matched=$this->left_condition->process();
                } else {
                    $left_match_matched=$this->left_condition->match_matched;
                }
                $right_match_matched=array();
                if($this->right_condition!=null &&
                    $this->right_condition->needed_update) {
                    $right_match_matched=$this->right_condition->process();
                } else {
                    $right_match_matched=$this->right_condition->match_matched;
                }
                $match_matched=array_intersect($left_match_matched,$right_match_matched);
            }
        }
    }
    public function processWithNewestData() {

    }

}
