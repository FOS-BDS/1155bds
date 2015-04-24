<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 4/23/15
 * Time: 16:37
 */

namespace App\Models;

use App\Models\base\CollectionBase;

class Teams extends CollectionBase {
    public function __construct()
    {
        parent::__construct("teams"); // TODO: Change the autogenerated stub
    }
    public static function makeObject($reference_id,$name,$logo='',$website='',$coach='',$stadium='',$city='') {
        $new_object=new \stdClass();
        $new_object->reference_id=intval($reference_id);
        $new_object->name=$name;
        $new_object->logo=$logo;
        $new_object->website=$website;
        $new_object->coach=$coach;
        $new_object->home_stadium=$stadium;
        $new_object->city=$city;
        $new_object->created_at=new \MongoDate();
        $new_object->updated_at=new \MongoDate();

        return $new_object;
    }

}