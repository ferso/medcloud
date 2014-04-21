<?php

class SettingsController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	protected $layout = 'layouts.app';


	public function index(){	
		if( Auth::user()->role_id > 1 ){			
			return Response::view('errors.403', array(), 403);
		}
		$this->layout->content = View::make('settings.index');

	}





}