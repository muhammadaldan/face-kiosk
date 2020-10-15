<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Abcent;
use App\Models\Setting;

class AbcentController extends Controller
{

    public function index(Request $request)
    {   
        $data = Abcent::with(['employee'])->whereDate('arrival', now()->format('Y-m-d'))->get();
        $pie = [];
        $barLabel = [];
        $barValue = [];
        $late = 0 ;
        $ontime = 0 ;
        foreach ($data as $key => $value) {
            if ($value->late) {
                $late ++;
            }else{
                $ontime ++;
            }            

            $time = $value->arrival->format('H:00');

            if (!in_array($time, $barLabel)) {
                array_push($barLabel, $time);
                array_push($barValue, 1);
            }else{
                $key = array_search($time, $barLabel);
                $barValue[$key] ++;
            }
        }
        array_push($pie,$ontime);
        array_push($pie,$late);
        
        return response()->json([
            'table' => $data,
            'pie' => $pie,
            'bar_label' => $barLabel,
            'bar_value' => $barValue,
        ]);
    }

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
