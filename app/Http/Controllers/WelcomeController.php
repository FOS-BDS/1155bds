<?php namespace App\Http\Controllers;

use App\DAO\RuleDAO;
use App\Libraries\Constants;
use App\Libraries\OutputHelper;
use App\Libraries\RenderCondition;

class WelcomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('acl');
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
        $ruleModel = new RuleDAO();
        //$data = $ruleModel->find(array('status'=>Constants::STATUS_MAIN));
        $data = $ruleModel->findOne(array('type'=>Constants::TYPE_CONDITION));
        $condition = RenderCondition::getInstance($data)->parserCondition();
        debug($condition);
        $data = $ruleModel->find($condition)->explain();
        //$data = iterator_to_array($data);
		//OutputHelper::getInstance()->setData($data);
		//OutputHelper::getInstance()->getData();
	}

}
