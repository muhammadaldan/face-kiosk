<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Abcent;
use App\Models\Employee;
use App\Exports\AbcentExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class ReportController extends Controller
{
    public function excel(Request $request)
    {
        
        return Excel::download(new AbcentExport($request->date), 'report abcent '.now().'.xlsx');
    }

    public function pdf(Request $request)
    {
        $firstDate = '';
        $secondDate = '';
        if (count($request->date) === 1) {
            $employee = Employee::with(['abcent' => function($q) use($request){
                $q->whereDate('arrival', $request->date[0]);
            }])->orderBy('nim', 'asc')->get();
            $firstDate = $request->date[0];
        }else if(count($request->date) > 1){
           
            if($request->date[0] > $request->date[1]){
                $firstDate = $request->date[1];
                $secondDate = $request->date[0];
            }else{
                $firstDate = $request->date[0];
                $secondDate = $request->date[1];                
            }

            $employee = Employee::with(['abcent' => function($q) use ($firstDate, $secondDate){
                $q->whereDate('arrival'  ,'>=',  $firstDate)->whereDate('arrival', '<=', $secondDate);
            }])->orderBy('name', 'asc')->get();
        }        

        $data['date'] = [$firstDate, $secondDate];
        $data['abcent'] = $employee;

        $pdf = PDF::loadView('report.pdf', $data);
        return $pdf->download('report '.$firstDate.' - '.$secondDate.'.pdf');
    }
}
