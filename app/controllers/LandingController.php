<?php

class LandingController extends BaseController  {

	protected $layout = 'layouts.landing';

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function get_index(){			
		 $this->layout->content =  View::make('landing');
	}

	public function post_index(){

		$user = array(
		  'email' => Input::get('email'),
		  'password' => Input::get('password'),
		  'user_status' => 1
		);
		
		if (Auth::attempt($user, true)){
		    //Auth::user()->user_id;
		     return Redirect::to('/dashboard')
                ->with('flash_notice', 'You are successfully logged in.');

		}else{

			
			return Redirect::to('/')
		        ->with('message', 'Your username/password combination was incorrect')
		        ->withInput();
		}	

		 $this->layout->content =  View::make('landing');

		// if (Auth::attempt(array('email'=> Input::get('email'), 'password'=> Input::get('password')))) {
		//     return Redirect::to('/dashboard')->with('message', 'You are now logged in!');
		// } else {
		//     return Redirect::to('/')
		        //->with('message', 'Your username/password combination was incorrect')
		        //->withInput();
		// }
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}