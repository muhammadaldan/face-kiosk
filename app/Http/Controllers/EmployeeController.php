<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\Employee;
use App\Models\Department;
use Str;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Employee::with(['department'])->orderBy('id', 'desc')->get();            
        $department = Department::orderBy('id', 'desc')->get();            
        $dataDepartment = [];
        foreach ($department as $key => $value) {
            array_push($dataDepartment, ['text' => $value->name, 'value' => $value->id ]);
        }

        return response()->json([
            'status' => true,            
            'data' => $data,
            'department' => $dataDepartment,
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
            'nim' => 'required|unique:employees',
            'image' => 'required',
            'department_id' => 'required',
        ]);        
    
        if ($v->fails()) {
            return response()->json([
                'status' => false,
                'message' => $v->errors()->all(),
            ]);
        }

        $image = $request->image;  // your base64 encoded
        $image = str_replace('data:image/png;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        $imageName = Str::random(4).'.jpeg';
        \File::put(public_path(). '/assets/images/upload/employee/' . $imageName, base64_decode($image));
        
        
        $info = getimagesize(public_path().'/assets/images/upload/employee/' . $imageName);
        
        $image = imagecreatefrompng(public_path().'/assets/images/upload/employee/' . $imageName );
        imagejpeg($image, public_path().'/assets/images/upload/employee/' . $imageName , 70);


       $data = Employee::create([
            'nim' => $request->nim,
            'name' => $request->name,
            'department_id' => $request->department_id,
            'email' => $request->email,                
            'phone_number' => $request->phone_number,                            
            'gender' => $request->gender,                
            'photo' => '/assets/images/upload/employee/'.$imageName,
        ]);
        
       
        $show = Employee::with(['department'])->where('id', $data->id)->first();            

        return response()->json([
            'status' => true,            
            'data' => $show
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
            'nim' => 'required|unique:employees,nim,'.$id,
            'department_id' => 'required',
        ]);        
    
        if ($v->fails()) {
            return response()->json([
                'status' => false,
                'message' => $v->errors()->all(),
            ]);
        }


       $data = Employee::find($id);


        if($request->image){
            $image = $request->image;  // your base64 encoded
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = Str::random(4).'.'.'png';
            \File::put(public_path(). '/assets/images/upload/employee/' . $imageName, base64_decode($image));
            if (is_writable(public_path($data->photo))) {
                unlink(public_path($data->photo));
            }                                    
            
            $info = getimagesize(public_path().'/assets/images/upload/employee/' . $imageName);
            
            $image = imagecreatefrompng(public_path().'/assets/images/upload/employee/' . $imageName );
            imagejpeg($image, public_path().'/assets/images/upload/employee/' . $imageName , 70);

            $data->update([
                'photo' => '/assets/images/upload/employee/'.$imageName
            ]);
        }


       $data->update([
            'nim' => $request->nim,
            'name' => $request->name,
            'department_id' => $request->department_id,
            'email' => $request->email,                
            'phone_number' => $request->phone_number,                            
            'gender' => $request->gender,                            
        ]);
        
        $show = Employee::with(['department'])->where('id', $data->id)->first();            
        

        return response()->json([
            'status' => true,            
            'data' => $show
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
        $data = Employee::find($id);
        
        if ($data->photo) {            
            if (is_writable(public_path($data->photo))) {
                unlink(public_path($data->photo));
            }
        }      
        
        $data->delete();            
        return response()->json([
            'status' => true,                            
        ]);
    }
}
