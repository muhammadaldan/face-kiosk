<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\SettingApp;

class SettingAppController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = SettingApp::first();

        return response()->json([
            'status' => true,            
            'data' => $data,            
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
       $data = SettingApp::find(1);        
        if ($request->logo) {              
            if ( $request->logo != 'undefined') {                

                $v = Validator::make($request->all(), [ 
                    'logo' => 'required|mimes:jpeg,jpg,png|max:20048',     
                ]);
                    
                if ($v->fails()) {
                    return response()->json([
                        'status' => false,
                        'message' => $v->errors()->all(),
                        ]);
                    }

                if ($data->logo) {            
                    if (is_writable(public_path($data->logo))) {
                        unlink(public_path($data->logo));
                    }
                }       


                $image = rand(). '.' . $request->logo->getClientOriginalExtension();           
                $request->logo->move(public_path("/assets/images/upload/setting/"), $image);
                $imagename = '/assets/images/upload/setting/'.$image;            

            $data->update([            
                'logo' => $imagename,
            ]);       
        }
        }
        

       $data->update([            
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
