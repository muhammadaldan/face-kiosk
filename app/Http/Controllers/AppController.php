<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SettingApp;

class AppController extends Controller
{
    public function index(){
        $data['setting'] = SettingApp::first();

        return view('app', $data);
    }
}
