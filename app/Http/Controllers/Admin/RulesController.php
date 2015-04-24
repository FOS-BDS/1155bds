<?php
namespace App\Http\Controllers\Admin;

use App\Libraries\Inputs\InputView;
use App\Models\Rules;
use App\Models\Suppliers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $supplierModel = new Suppliers();
        $suppliers = $supplierModel->find();
        $suppliers = iterator_to_array($suppliers);
        return view('admin.rules.index', ['suppliers' => $suppliers]);
	}

    public function getRules(Request $request) {
        $inputClass = new InputView($request);
        echo $inputClass->renderView($request);
    }

    public function editRule(Request $request) {
        $inputClass = new InputView($request);
        $params = $request->all();
        echo $inputClass->renderForm($params);
    }

    public function save(Request $request) {
        $all = $request->all();
        $inputClass = new InputView($request);
        $inputClass->save();
        echo $inputClass->renderForm($all);
    }
}
