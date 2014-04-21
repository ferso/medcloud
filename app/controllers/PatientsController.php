<?php

class PatientsController extends BaseController {

	
	protected $layout = 'layouts.app';

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(){		
		$this->layout->content = View::make('patients.index');
	}

	public function table(){

		$user = Auth::user();
		$role = $user->role_id;
		$area = $user->area_id;

		$page = Input::get('page');	
		$rows = Input::get('rows');

		if(  Input::get('keyword') ){
			$keyword = Input::get('keyword');
			$users   = VisitorView::where('role_id',4)->where('user_fullname', 'like', "$keyword%")->withTrashed()->orderBy('created_at', 'desc')->paginate($rows);
		}else{
			$users = VisitorView::where('role_id',4)->orderBy('created_at', 'desc')->paginate($rows);					
		}	

		// if($role == 1){					

		// 		if(  Input::get('keyword') ){
		// 			$keyword = Input::get('keyword');
		// 			$users   = VisitorView::where('user_fullname', 'like', "$keyword%")->withTrashed()->orderBy('created_at', 'desc')->paginate($rows);
		// 		}else{
		// 			$users = VisitorView::orderBy('created_at', 'desc')->paginate($rows);	
		// 		}

		// }else{
			//........
		// }			
		return Response::json( $users->toArray() );
	}

	

}