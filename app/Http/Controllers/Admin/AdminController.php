<?php namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Redirect;

abstract class AdminController extends BaseController {

	use DispatchesCommands, ValidatesRequests;
    public function __construct() {
        $this->middleware('auth');
    }
}
