<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 5/8/15
 * Time: 17:03
 */

namespace App\Models\base;


class ModelBase extends CollectionBase {
    public function __construct($collection_name)
    {
        parent::__construct($collection_name); // TODO: Change the autogenerated stub
    }
    public function getObjectsByField($condition_left,$operator,$condition_right) {
        $this->find();
    }
    public function getOneObjectByField() {

    }
    public function getObjectsByFields() {

    }
}