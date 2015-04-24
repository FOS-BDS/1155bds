<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 4/23/15
 * Time: 16:37
 */

namespace App\Models;

use Jenssegers\Mongodb\Model as Eloquent;
class Teams extends Eloquent {
    protected $collection = 'teams';
}