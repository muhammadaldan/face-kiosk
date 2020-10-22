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
        User::create([
            'name' => 'Admin',
            'email' => 'admin@makerindo.com',
            'password' => Hash::make('12341234')
        ]);
    }
}
