<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 4/23/15
 * Time: 14:59
 */

namespace App\Http\Controllers;


use App\Libraries\InputHelper;

class BaseController extends Controller{
    protected $request;
    public function __construct() {
        $this->request=$this->getRouter()->getCurrentRequest();
        //parent::__construct();
        $input = $this->request->json()->all();
        if ( count($input) == 0 ) {
            $input = $this->request->all();
        }

        InputHelper::setInputArray( $input );
    }
}