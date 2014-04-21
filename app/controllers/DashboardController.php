<?php

class DashboardController extends BaseController  {


	protected $layout = 'layouts.app';
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(){
		$user         = Auth::user();
		$roleid       = $user->role_id;
		$account      = Account::find( $user->account_id);
		$role         = Role::find($roleid);	
		$account_name = $roleid == 1 ? 'Dashboard General - ' . $account->account_name : 'Dashboard ' .$account->account_name;
		$this->layout->content = View::make('scheduler.index', array('usertype' => $role->role_level,'account_name'=>$account_name ) );
	}

	/**
	 * report an appointment from the db
	 *
	 * @return Response
	 */
	public function report(){
		$user = Auth::user();
		$role = $user->role_id;
		$area = $user->area_id;

		if($role == 1){
			$DashboardView = DashboardView::all(); 
			return Response::json( $DashboardView->toArray() );
		}else{
			$DashboardView = DashboardView::loadByAreaId($area);
			return Response::json( $DashboardView );
		}			
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