<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 4/23/15
 * Time: 15:05
 */

namespace App\Models;

use Jenssegers\Mongodb\Model as Eloquent;
class Leagues extends Eloquent{
    protected $collection = 'leagues';
}