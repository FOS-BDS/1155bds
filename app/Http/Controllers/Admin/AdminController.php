<?php namespace App\Http\Controllers\Admin;

//use App\Http\Requests\Request;
use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Session;

abstract class AdminController extends BaseController {

	use DispatchesCommands, ValidatesRequests;
    protected $uid = null;
    public function __construct() {
        $request = Request::capture();
        if($request->ajax()){
            if(!Session::has('user')) {
                echo view('admin.errors.access', [])->render();
                exit;
            }
        }
        $this->middleware('auth');
        $this->uid = Session::get('user.id');

    }
    public function beforeFilter($filter, array $options = array()) {
        debug($this->beforeFilter('aaaaaaaaaaa'));
    }
}
