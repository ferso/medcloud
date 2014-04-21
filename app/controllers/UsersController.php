<?php

class UsersController extends BaseController {

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
		$this->layout->content = View::make('users.index');

	}


	public function save(){

		#form data
		$data = Input::all();
		unset($data['_url']);
		#if id comes with data, this is for update process
		if( Input::get('id') != 0 ){	

			$Validate = User::validate(Input::all(),Input::get('id'));
			if( $Validate->passes() ) {
				
				if( Input::get('password') ){
					$data['password'] = Hash::make( Input::get('password') );
				}
				//update process
				$user = User::where('id',Input::get('id') )->update($data);
				//return response
				return Response::json( array('code'=>0,'message'=>'Save ok!','data' => $user, 'process'=>'update' )  ); 

			}else { 

			   #code for validation failure
			   return Response::json( array('error'=>100,'message'=>$Validate->messages(),'data' => '','process'=>'update')  );			   
			}

		}else{

			$Validate = User::validate(Input::all());
			if( $Validate->passes() ) {        	
				#code for validation success!
				$password    	     = Input::get('password') ?  Input::get('password') : uniqid();
				$data['password']    = Hash::make($password);
				#the objec to save
				$user = User::create($data);				
				$body = array('name'=> $data['user_fullname'],'password'=>$password);
				#Send access information to user
				Mail::send('layouts.email',$body,function($message){
					$message->from('erickfernando@gmail.com', 'ITVH::Citas');
		    		$message->to( Input::get('email'), Input::get('user_fullname'))->subject('Welcome!');
				});
				//return response
				return Response::json( array('code'=>0,'message'=>'Save ok!','data' => $user, 'process'=>'create' )  );
			}else {

			   #code for validation failure
			   return Response::json( array('error'=>100,'message'=>'Data error!','data' => $Validate->messages()->all(), 'process'=>'create' )  );			   
			}			
			#--------------			
		}
	}

	public function get($id=null){
		if($id){
			$user = User::find($id);
			return Response::json( $user->toArray() );
		}else{
			return Response::json( array('error'=>100,'message'=>'User no found' ) ); 
		}
	}

	public function delete($id=null){
		if($id){
			User::destroy($id);
			return Response::json( array('code'=>0,'message'=>'User was deleted' ) ); 
		}else{
			return Response::json( array('error'=>100,'message'=>'User no found' ) ); 
		}
		
	}

	public function table(){
		
		$page = Input::get('page');	
		$rows = Input::get('rows');

		if(  Input::get('keyword') ){
			$keyword = Input::get('keyword');
			$users   = UserView::where('user_fullname', 'like', "$keyword%")->withTrashed()->orderBy('created_at', 'desc')->paginate(15);
		}else{
			$users = UserView::orderBy('created_at', 'desc')->paginate($rows);
		}

		return Response::json( $users->toArray() );
	 
	}

	public function roles(){

		$Roles = Role::orderBy('role_level', 'asc')->get(); 
		return Response::json($Roles->toArray());
	 
	}






}