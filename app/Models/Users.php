<?php
namespace App\Models;

use Jenssegers\Mongodb\Model as Eloquent;

class Users extends Eloquent {
    protected $collection = 'users';
}
