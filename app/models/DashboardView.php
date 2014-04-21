<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class DashboardView extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'dashboard_view';

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	protected function loadByAreaId($id){
		
		$users     = DB::table('user')->where('area_id',$id)->count();
		$visitors  = DB::table('user')->where('role_id',3)->where('area_id',$id)->count();
		$apts      = DB::table('appointment')->where('area_id',$id)->count();
		$cancelled = DB::table('appointment')->where('area_id',$id)->where('apt_status',3)->count();  
		return array( 0 => array('users' => $users,'visitors'=>$visitors,'appoitnments'=>$apts,'cancelleds'=>$cancelled ) );

	}


}