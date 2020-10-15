<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Setting;

class RecognitionController extends Controller
{
    public function getFaces()
    {
        $data = Employee::all();
        $setting = Setting::first();

        return response()->json([
            'data' => $data,
            'setting' => $setting
        ]);
    }
}
