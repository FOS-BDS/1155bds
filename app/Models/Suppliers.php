<?php
namespace App\Models;

use Jenssegers\Mongodb\Model as Eloquent;

class Suppliers extends Eloquent {
    protected $collection = 'suppliers';
}
