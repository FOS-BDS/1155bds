<?php
namespace App\Models;

use App\DAO\OddDAO;
use App\DAO\RuleDAO;
use App\Libraries\Constants;
use Illuminate\Support\Facades\Log;
use MongoId;

class Rules extends ModelBase {
    /**
     * @var MongoId $id
     */
    public $id;
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
    public $user_id;
    public $color_lever=0;

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

    public function initFromID($id,$paraent_rules) {
        $this->id=$id;
        $this->parent_rules=$paraent_rules;
    }

    public function initFromDBObject($db_object,$load_child_obj=false)
    {
        if(!is_object($db_object)) $db_object=(object)$db_object;

        $this->id=$db_object->_id;
        $this->name=$db_object->name;
        $this->description=$db_object->description;
        $this->type=$db_object->type;
        $this->status=$db_object->status;
        $this->operator=$db_object->operator;
        $this->needed_update=$db_object->needed_update;
        $this->parent_rules=$db_object->parent_rules;
        $this->match_matched=$db_object->match_matched;
        $this->matched_md5=$db_object->matched_md5;
        $this->user_id=$db_object->user_id;

        if($db_object->type==Constants::TYPE_CONDITION) {
            $this->field=$db_object->field;

            $db_object->time=(object)$db_object->time;
            $db_object->condition_values=(object)$db_object->condition_values;

            $this->first_value=$db_object->condition_values->value_first;
            $this->second_value=$db_object->condition_values->value_last;
            $this->time=$db_object->time->value;

            $this->odd_type=$db_object->odd_type;

        } elseif($db_object->type==Constants::TYPE_RULE) {
            $this->rule_color=$db_object->rule_color;

            $db_object->condition_left=(object)$db_object->condition_left;
            $db_object->condition_right=(object)$db_object->condition_right;

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
        $left_cond_obj=$ruleDao->findOne(array('_id'=>$this->left_condition_id));
        if($left_cond_obj!=null) {
            $left_condition->initFromDBObject((object)$left_cond_obj);
        } else {
            $left_condition=null;
        }
        $this->left_condition=$left_condition;

        // load right condition
        $right_condition=new Rules();
        $right_cond_obj=$ruleDao->findOne(array('_id'=>$this->right_condition_id));
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
    public function process($newest_odds=array(),$update_parent=false) {
        if($this->needed_update) {
            $oddDAO=new OddDAO();
            $match_matched=array();
            if($this->type==Constants::TYPE_CONDITION) {

                $query=$this->buildQuery($newest_odds);
                if($query==null) return array();
                $matched_cur=$oddDAO->find($query,array('match_id'));
                do {
                    $matched_cur->next();
                    $current=$matched_cur->current();
                    if($current==null) break;
                    $current=(object)$current;
                    $match_matched[]=$current->match_id->__toString();
                } while($matched_cur->hasNext());

            } elseif($this->type==Constants::TYPE_RULE) {

                if(!$this->is_loaded_child) {
                    $this->loadChildRule();
                }

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
            asort($match_matched);
            asort($this->match_matched);
            // value changed
            //1- update this object
            $ruleDao=new RuleDAO();
            $ruleDao->update(array('_id'=>$this->id),array('$set'=>array('needed_update'=>false,'match_matched'=>array_values($match_matched))));

            if(md5(json_encode($this->match_matched))!=md5(json_encode($match_matched))) {
                // update for all parent
                if($update_parent) {
                    $this->notifyChangeParent();
                }
            }
            return $match_matched;

        } else {
            return $this->match_matched;
        }
    }
    public function notifyChangeParent() {
        $ruleDao=new RuleDAO();
        $ruleDao->update(array('_id'=>array('$in'=>$this->parent_rules)),array('$set'=>array('needed_update'=>true)),array('multi'=>true));

        $parent_curs=$ruleDao->find(array('_id'=>array('$in'=>$this->parent_rules)));


        do {
            $parent_curs->next();
            $current=$parent_curs->current();
            if($current==null)  break;
            $current=(object)$current;

            $ruleObj=new Rules();
            $ruleObj->initFromID($current->_id,$current->parent_rules);
            $ruleObj->notifyChangeParent();
        } while($parent_curs->hasNext());
    }
    private function buildQuery($newest_odd_md5s=array()) {
        $result=array('time'=>intval($this->time),
                      'type'=>strval($this->odd_type));
        if($newest_odd_md5s!=null && count($newest_odd_md5s)>0) {
            $result['md5']=array('$in'=>$newest_odd_md5s);
        }
        switch($this->operator) {
            case Constants::OPERATOR_NE:
            case Constants::OPERATOR_EQ:
            case Constants::OPERATOR_LT:
            case Constants::OPERATOR_LTE:
            case Constants::OPERATOR_GT:
            case Constants::OPERATOR_GTE:
                $result[$this->field]=array($this->operator=>floatval($this->first_value));
                break;
            case Constants::OPERATOR_NIN:
                $result[Constants::OPERATOR_OR]=array(
                    array($this->field=>array(Constants::OPERATOR_LT=>floatval($this->first_value))),
                    array($this->field=>array(Constants::OPERATOR_GT=>floatval($this->second_value)))
                );
                break;
            case Constants::OPERATOR_IN:
                $result[Constants::OPERATOR_AND]=array(
                    array($this->field=>array(Constants::OPERATOR_GTE=>floatval($this->first_value))),
                    array($this->field=>array(Constants::OPERATOR_LTE=>floatval($this->second_value)))
                );
                break;
            default:
                return null;
        }
        return $result;

    }
}
