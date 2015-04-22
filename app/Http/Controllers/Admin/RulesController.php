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

    public function testInput(Request $request) {
        /*$supplierArr = array('Crown','ibcbet','Sbobet','Macauslot');
        foreach($supplierArr as $index => $suppli) {
            $user = new Suppliers();
            $user->id = $index+1;
            $user->name = $suppli;
            $user->save();
        }*/
        $supplies = Suppliers::all();
        debug($supplies);
        $inputClass = new InputView($request);
        return view('admin/index');
        echo $inputClass->render();
    }

}
