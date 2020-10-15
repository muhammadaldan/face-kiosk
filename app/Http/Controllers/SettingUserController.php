<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Auth;
use Hash;

class SettingUserController extends Controller
{
    public function account(Request $request)
    {
        $v = Validator::make($request->all(), [             
            'name' => 'required',
            'email' => 'required|unique:users,email,'.Auth::user()->id,            
        ]);        
    
        if ($v->fails()) {
            return response()->json([
                'status' => false,
                'message' => $v->errors()->all(),
            ]);
        }
        $data = User::find(Auth::user()->id);

        $data->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        
        return response()->json([
            'status' => true,            
            'data' => $data
        ]);
    }

    public function password(Request $request)
    {
         $v = Validator::make($request->all(), [
                'current_password' => 'required',
                'password' => 'required|min:6|confirmed'
            ]);

        $data = User::find(Auth::user()->id);

        if ($v->fails()) {
            return response()->json([
                'status' => false,
                'message' => $v->errors()->all(),
            ]); 
        }

        if(!(Hash::check($request->current_password, Auth::user()->password))){
            return response()->json([
                'status' => false,
                'message' => [__('Current password wrong!!')]
            ]);
        }

        $data->update([
            'password' => Hash::make($request->password)
        ]);               

        return response()->json([
            'status' => true,            
            'data' => $data
        ]);
    }
}
