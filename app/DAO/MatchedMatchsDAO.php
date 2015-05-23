<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 5/23/15
 * Time: 11:38
 */

namespace App\DAO;


use App\DAO\base\CollectionBase;

class MatchedMatchsDAO extends CollectionBase {
    public function __construct()
    {
        parent::__construct("matched_matchs"); // TODO: Change the autogenerated stub
    }
    private static $instance;
    public static function getInstance()
    {
        if(self::$instance==null) {
            self::$instance=new MatchedMatchsDAO();
        }
        return self::$instance;
    }
}