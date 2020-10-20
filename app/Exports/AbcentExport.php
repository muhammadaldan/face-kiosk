<?php

namespace App\Exports;

use App\Models\Abcent;
use App\Models\Employee;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use DB;

class AbcentExport implements FromView, ShouldAutoSize
{    
    protected $date;

    public function __construct($date) 
    {
        $this->date = $date;
    }

    public function view(): View
    {        
        $firstDate = '';
        $secondDate = '';
        if (count($this->date) === 1) {
            $employee = Employee::with(['abcent' => function($q){
                $q->whereDate('arrival', $this->date[0]);
            }])->orderBy('nim', 'asc')->get();
            $firstDate = $this->date[0];
        }else if(count($this->date) > 1){
           
            if($this->date[0] > $this->date[1]){
                $firstDate = $this->date[1];
                $secondDate = $this->date[0];
            }else{
                $firstDate = $this->date[0];
                $secondDate = $this->date[1];                
            }

            $employee = Employee::with(['abcent' => function($q) use ($firstDate, $secondDate){
                $q->whereDate('arrival'  ,'>=',  $firstDate)->whereDate('arrival', '<=', $secondDate);
            }])->orderBy('name', 'asc')->get();
        }        
        
        return view('report.excel', [
            'abcent' => $employee,
            'date' => [$firstDate, $secondDate]
        ]);
    }
}
