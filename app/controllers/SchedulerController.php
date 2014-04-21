<?php

class SchedulerController extends BaseController  {


	protected $layout = 'layouts.app';

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(){
		// $user = Auth::user();

		// //print_r($user);
		// $role = Role::find($user->role_id);
		// $this->layout->content = View::make('scheduler.index', array('usertype' => $role->role_level ));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */

	public function table(){
		$areas = Area::all();
		return Response::json( $areas->toArray() );	 
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(){

		//session data
		$user 			        = Auth::user();
		
		//form data
		$data 			        = Input::all();
		unset($data['_url']);	
		$data['user_id']        = $user->id;
		$data['area_id']        = $user->area_id;		
		
		//set status	
		if(isset($data['apt_status']) && empty($data['apt_status']) ){
			$data['apt_status'] = 1;
		}
		
		//create new guest
		if($data['apt_guest_id'] == 0 ){
			$visitor = User::create(array('user_fullname'=>$data['apt_guest_name'],'role_id'=>3,'user_status'=>1));
			$data['apt_guest_id'] = $visitor->id;
		}

		//update / create
		if($data['mode'] == 'update'){

			unset($data['mode']);

			if(isset($data['apt_end']) && empty($data['apt_end']) ){
				$data['apt_end'] = $data['apt_start'];
			}

			//update	
			$event 		     		= Appointment::where('id',Input::get('id') )->update($data);		
			$event     				= Appointment::find(Input::get('id'));
			$event                  = $event->toArray();

		}else{

			$event 		     		= Appointment::create($data);		

		}

		return Response::json($event);

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function events(){
		$user 	  = Auth::user();
		$start    = date( 'Y-m-d H:i:s', Input::get('start'));
		$end      = date('Y-m-d H:i:s', Input::get('end'));
		$area_id  = $user->area_id;

		$sql 	= "SELECT id, apt_subject as title, apt_start as start, apt_end as end, apt_status as status
					 FROM appointment 
					 WHERE apt_start BETWEEN '$start' AND '$end'";
					 
		$sql    .=	$user->role_id == 1 ? "" : "AND area_id = $area_id ";

		$sql    .=	"ORDER BY id";

		$Appointments = DB::select($sql);
		$Data         = array();
		foreach ($Appointments as $key => $value) {				
			$Apt 		   = array();
			$Apt['id']     = $Appointments[$key]->id;
            $Apt['title']  = $Appointments[$key]->title;
            $Apt['start']  = $Appointments[$key]->start;
            $Apt['end']    = $Appointments[$key]->end;
            $Apt['status'] = $Appointments[$key]->status;
            $Apt['allDay'] = false;
            array_push($Data, $Apt);
		}

		return Response::json($Data);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function hosts(){
		$user 	 = Auth::user();
		$roleid  = $user->role_id;
		$areaid  = $user->area_id;
		if( $roleid == 1){
			$Appointments = User::where('role_id',4)->get();
			return Response::json($Appointments);
		}else{
			$Appointments = User::where('role_id',4)->where('area_id',$areaid)->get();
			return Response::json($Appointments);
		}
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function user($name){
		$user = user::where('user_fullname', 'LIKE', '%'.$name.'%')->where('role_id',3)->get();
		return Response::json( $user->toArray()  );
	}

	/**
	 * get an appointment from the db
	 *
	 * @return Response
	 */
	public function apt(){
		$id = Input::get('id');
		$Apt = Appointment::find($id);
		return Response::json( $Apt->toArray() );	
	}

	/**
	 * report an appointment from the db
	 *
	 * @return Response
	 */
	public function report(){
	
		$DashboardView = DashboardView::all();
		return Response::json( $DashboardView->toArray() );
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