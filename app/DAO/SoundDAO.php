<?php
/**
 * Created by PhpStorm.
 * User: Kudo Shinichi
 * Date: 5/20/2015
 * Time: 11:52 AM
 */
namespace App\DAO;

use App\DAO\base\CollectionBase;

class SoundDAO extends CollectionBase {
    private static $instance;
    public static function getInstance()
    {
        if(self::$instance==null) {
            self::$instance=new SoundDAO();
        }
        return self::$instance;
    }

    public function __construct()
    {
        parent::__construct("sounds"); // TODO: Change the autogenerated stub
    }

}