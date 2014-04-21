<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class Appointment extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'appointment';

	protected $fillable = array('user_id','area_id','apt_subject','host_id','apt_start','apt_end','apt_guest_name','apt_guest_id','apt_comments','apt_status','apt_uuid');

}