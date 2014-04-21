<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {
	
	 protected $fillable =  ['account_id','role_id','user_uuid','user_code','user_name','user_fullname','email','password', 'user_status','user_street' ,'user_neighbor','user_state' ,'user_locality','user_sublocality','user_country','user_mobile','user_phone','user_zip'];

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'user';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}


	public static function validate($input,$id=null) {
          if( $id ){
          	$rules = array(
		        'user_fullname' => 'Required|Min:3|Max:80',
		        'email'     => 'Required|Between:3,64|Email|Unique:user,email,'.$id,        
		        // 'password'  =>'Required|AlphaNum|Between:4,8'
			);
          }else{
          	$rules = array(
	        'user_fullname' => 'Required|Min:3|Max:80',
	        'email'     => 'Required|Between:3,64|Email|Unique:user,email'
			);
          }       
        return Validator::make($input, $rules);
    }

}