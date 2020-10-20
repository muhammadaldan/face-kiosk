<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SettingApp;

class SettingAppSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SettingApp::create([
            'name' => 'Attendance System'
        ]);
    }
}
