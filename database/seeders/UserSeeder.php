<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Employee;
use Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        for ($i=0; $i < 100 ; $i++) { 
            Employee::create([
                'department_id' => 1,
                'nim' => rand(10,10000),
                'name' => 'Admin',
                'email' => 'admin@makerindo.com',
                'gender' => 'Male',
                'photo' => '-',
            ]);
        }
        // User::create([
        //     'name' => 'Admin',
        //     'email' => 'admin@makerindo.com',
        //     'password' => Hash::make('12341234')
        // ]);
    }
}
