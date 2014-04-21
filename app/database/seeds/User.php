<?php

return array(
		'table' => 'user',
        array(	
        		'fullname' => 'Fernando Soto',
        		'role_id'=>1,
                'name' => 'ferso',
                'uuid' => '111111',
                'email' => 'erickfernando@gmail.com',
                'created'=> date('Y-m-d H:i:s'),
                'password' => Hash::make('casa'),
                'status'=>1
        )
);