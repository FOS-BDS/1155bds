<?php
namespace App\Http\Controllers\Admin;

use App\Libraries\Inputs\InputView;
use App\Models\Suppliers;
use Illuminate\Http\Request;

class RulesController extends AdminController {
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		//$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index() {
        $suppliers = Suppliers::all();
        return view('admin.rules.index', ['suppliers' => $suppliers]);
	}

    public function getRules(Request $request) {
        $inputClass = new InputView($request);
        echo $inputClass->render();
    }

}
