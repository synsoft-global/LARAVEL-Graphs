<?php

use Illuminate\Database\Seeder;
Use App\Model\userRole;
Use App\Model\User;
Use App\Model\userCapability;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
	protected $totalUser = 1;
	
	protected $totalUserRole = 1;
	
	/**
     * Populate the database with dummy data for testing.
     * Complete dummy data generation including relationships.
     * Set the property values as required before running database seeder.
     *
     * @param \Faker\Generator $faker
     */
    public function run(\Faker\Generator $faker)
    {
        static $reduce = 999;
        $role=[
            ['title'=>'Admin','capabilities'=>'','slug'=>'admin'],
            ['title'=>'Manager','capabilities'=>'','slug'=>'manager'],
            ['title'=>'Sales Person','capabilities'=>'','slug'=>'sales_person'],
            ['title'=>'Producer','capabilities'=>'','slug'=>'producer']
        ];

        $capability=[
            ['capability'=>'can_edit_product']
        ];

        $users['Admin']=[
            [               
            "name"=>"Ajay Mishra",
            "email"=>"ajaym.synsoft@gmail.com",
            "password"=>bcrypt('Synsoft@123'), 
            "email_verified_at"=> \Carbon\Carbon::now()->subSeconds($reduce--),   
            ], 
            [               
            "name"=>"Chris Young",
            "email"=>"chris@thebeerconnect.com",
            "password"=>bcrypt('Synsoft@123'), 
            "email_verified_at"=> \Carbon\Carbon::now()->subSeconds($reduce--),   
            ],           
                    
        ];

       array_map(function($layout) use($users) {   
          $rid = userRole::updateorcreate(['title'=>$layout['title']],$layout);
           if(isset($users[$layout['title']])){               
               $layoutItem = array_map(function($items) use($rid){            
                    return User::create([
                           'name' => $items['name'],
                           'email' => $items['email'], 
                           'password' => $items['password'],
                           'user_role_id' => $rid->id,
                           'email_verified_at' => $items['email_verified_at']
                                       
                        ]);
                },$users[$layout['title']]);                  
             }
        }, $role); 

        array_map(function($layout){   
           $rid = userCapability::updateorcreate(['capability'=>$layout['capability']],$layout);         
        }, $capability); 

    }
}
