<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'username' => 'admin_pibs',
	        'email' => 'adminpibs@example.com',
	        'password' => Hash::make('s3cur1ty'),
	        'contact' => '911',
	        'level' => 'admin',
	        'fname' => 'ADMIN',
	        'mname' => 'ADMIN',
	        'lname' => 'ADMIN',
	        'suffixname' => 'ADMIN',
	        'gender' => 'male',
	        'dob' => '2000-10-10',
	        'civil_status' => 'single',
	        'address' => 'Cotabato City',
	        'specialization' => 'N/A',
	        'image' => 'N/A',
	        'is_accept' => '0'
        ]);
    }
}
