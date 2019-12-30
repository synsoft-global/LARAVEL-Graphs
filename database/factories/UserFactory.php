<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Model\User::class, function (\Faker\Generator $faker) {
	static $reduce = 999;
    return [
        'name' => 'admin',
        'email' => 'ajaym.synsoft@gmail.com',
        'password' => bcrypt('Synsoft@123'), 
		'profile_image' => 'https://cdn.worldvectorlogo.com/logos/laravel.svg',       
        'email_verified_at' => \Carbon\Carbon::now()->subSeconds($reduce--)    		
    ];
});

$factory->define(App\Model\userRole::class, function (\Faker\Generator $faker) {   
    return [
        'title' => 'admin',
        'capabilities' => ''               
    ];
});

$factory->define(App\Model\userCapability::class, function (\Faker\Generator $faker) {    return [
        'capability' => 'can_edit_product'	                 
    ];
});
