<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Abcent;
use App\Models\Setting;

class AbcentController extends Controller
{
    public function abcent(Request $request)
    {
        $setting = Setting::first();
                
        if (now()->format('H:i') <= $setting->waktu_pulang) {
            $data = Abcent::whereDate('created_at', now()->format('Y-m-d'))->where('employee_id', $request->id)->first();
            if(!$data){
                $data = Abcent::create([
                    'employee_id' => $request->id,
                    'late' => $setting->arrival_time >= now()->format('H:i'),
                    'arrival' => now(),
                    'waktu_pulang' => Null
                ]);       
            }
        }else{
            $data = Abcent::whereDate('created_at', now()->format('Y-m-d'))->where('employee_id', $request->id)->first();
            if(!$data){                
               $data = Abcent::create([
                    'employee_id' => $request->id,
                    'late' => $setting->arrival_time >= now()->format('H:i'),
                    'arrival' => now(),
                    'waktu_pulang' => Null
                ]);                       
            }else{
                if(!$data->waktu_pulang){
                    $data = Abcent::where('employee_id', $request->id)->update([                    
                        'waktu_pulang' => now()
                    ]);       
                }
            }
          
        } 

        return response()->json([
            'data' => $data
        ]);
    }
}
