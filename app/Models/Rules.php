<?php
namespace App\Models;

class Rules {
    public $field;
    public $operator;
    public $name;
    public $description;
    public $left_condition_id;
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

}
