<?php
namespace App\Libraries;
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 3/26/15
 * Time: 12:01
 */

class StringHelper {
    public static function getStringdata( $string, $firstCharactor, $secondCharactor) {
        $firt_post=strpos($string,$firstCharactor);
        $second_post=strpos($string,$secondCharactor);
        $result=substr($string,$firt_post+1,$second_post-$firt_post-1);

        return $result;
    }
    public static function getData( $string, $firstCharactor, $secondCharactor) {
        $main_data=self::getStringdata($string,$firstCharactor,$secondCharactor);
        $main_data=str_replace("'","",$main_data);
        $main_data=str_replace("[","",$main_data);
        $main_data=str_replace("]","",$main_data);
        $data_array=explode(",",$main_data);
        return $data_array;
    }
    public  static function getIndicatorClass($newest_odd, $old_odd)
    {
        $result = array('home' => '', 'draw' => '', 'away' => '');
        if (!isset($old_odd)) {
            return $result;
        } else {
            $keys = array('home', 'draw', 'away');
            foreach ($keys as $key) {
                if ($newest_odd[$key] > $old_odd[$key]) {
                    $result[$key] = ' square bg-square-blue ';
                } elseif ($newest_odd[$key] < $old_odd[$key]) {
                    $result[$key] = ' square bg-square-red ';
                }
            }
        }
        return $result;
    }
}