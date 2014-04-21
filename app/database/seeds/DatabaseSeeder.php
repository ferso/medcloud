<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();
		$this->call('UserTableSeeder');
		$this->command->info('User table seeded!');
	}

};


class UserTableSeeder extends Seeder {

    public function run(){
        // DB::table('user')->delete();
        User::create( array(	
        		'fullname' => 'Fernando Soto',
        		'role_id'=>1,
                'name' => 'ferso',
                'uuid' => '111111',
                'email' => 'erickfernando@gmail.com',               
                'password' => Hash::make('casa'),
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
                'status'=>1
        ));
    }

}