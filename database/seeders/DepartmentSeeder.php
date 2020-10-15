<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
          $input = array(
            [
             'name' => 'Electrical',
            ],        
            [
             'name' => 'Mechanical',
            ],        
        );

        DB::table('departments')->insert($input);
    }
}
