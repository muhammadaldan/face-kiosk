<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::where('id' ,'>', 1)->orderBy('id', 'desc')->get();            
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
                'email' => 'required|unique:users',
            ]);

            if ($v->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $v->errors()->all(),
                ]);
            }
            

            $data = User::create([                          
                'name' => $request->name,                
                'email' => $request->email,                
                'password' => Hash::make('123456'),
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
                'email' => 'required|unique:users,email,'.$id,
            ]);

            if ($v->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $v->errors()->all(),
                ]);
            }

            $data = User::find($id);
            
            $data->update([            
                'name' => $request->name,                
                'email' => $request->email,                
                'password' => Hash::make('123456'),
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
        $data = User::find($id);
                            
        $data->delete();            
        return response()->json([
            'status' => true,                            
        ]);
    }
}
