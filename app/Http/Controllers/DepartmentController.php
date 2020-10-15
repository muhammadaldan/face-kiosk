<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use Validator;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Department::orderBy('id', 'desc')->get();            
        return response()->json([
            'status' => true,            
            'data' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
          $v = Validator::make($request->all(), [             
                'name' => 'required',
            ]);

            if ($v->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $v->errors()->all(),
                ]);
            }
            

            $data = Department::create([                          
                'name' => $request->name,                
            ]);                                        

            return response()->json([
                'status' => true,            
                'data' => $data        
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
            $v = Validator::make($request->all(), [             
                'name' => 'required',                        
            ]);

            if ($v->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $v->errors()->all(),
                ]);
            }

            $data = Department::find($id);
            
            $data->update([            
                'name' => $request->name,
            ]);                                        
          

            return response()->json([
                'status' => true,            
                'data' => $data
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Department::find($id);
                            
        $data->delete();            
        return response()->json([
            'status' => true,                            
        ]);
    }
}
