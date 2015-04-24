<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 4/23/15
 * Time: 15:04
 */

namespace App\Models;

use Jenssegers\Mongodb\Model as Eloquent;
class Odds extends Eloquent{
    protected $collection = 'odds';
}