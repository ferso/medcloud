<?php

class AreasController extends BaseController {

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
		$this->layout->content = View::make('areas.index');		 
	}

	public function get($id=null){
		if($id){
			$area = Area::find($id);
			return Response::json( $area->toArray() );
		}else{
			return Response::json( array('error'=>100,'message'=>'Area no found' ) ); 
		}
	}

	public function delete($id=null){
		if($id){
			Area::destroy($id);
			return Response::json( array('code'=>0,'message'=>'Area was deleted' ) ); 
		}else{
			return Response::json( array('error'=>100,'message'=>'Area no found' ) ); 
		}
		
	}
	public function table(){

		$page = Input::get('page');	
		$rows = Input::get('rows');

		if(  Input::get('keyword') ){
			$keyword = Input::get('keyword');
			$areas   = Area::where('area_name', 'like', "$keyword%")->withTrashed()->orderBy('created_at', 'desc')->paginate(15);
		}else{
			$areas = Area::orderBy('created_at', 'desc')->paginate($rows);
		}

		return Response::json( $areas->toArray() );

	}


	public function save(){

		#form data
		$data = Input::all();
		unset($data['_url']);
		
		#if id comes with data, this is for update process
		
		if( Input::get('id') != 0 ){
			$Area = Area::where('id',Input::get('id') )->update($data);
		}else{

			$Area = Area::create($data);
			#--------------			
		}

		return Response::json( array('code'=>0,'message'=>'Save ok!','data' => $Area )  );

	}



}