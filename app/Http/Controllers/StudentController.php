<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index()
    {
        $data = Student::all();
        if ($data->count()>0) {

            $response = [  
                'students'=> $data,
                'status'  => '200'
           ];
        
        return response()->json(
          $response, 200);
    }else {
        return response()->json([
            'message'=> 'No students',
            'status'  => '404'
        ], 404);
    }
    }


    public function  store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=> 'required| max:60',
            'email'=> 'required|email|max:100',
            'phone'=> 'required|digits:10'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'=> 422,
                'message'=> $validator->messages()
            ]);
        }else {
            $student = Student::create([
                'name'=> $request->name,
                'email'=>$request->email,
                'phone'=>$request->phone
            ]);
            if ($student->count()>0) {
                return response()->json([
                  'status'=> 200,
                  'message'=>'student created successfully',
                  'student'=>$student
                ], 200);
            }else {
                return response()->json([
                    'status'=> 500,
                    'message'=>'ssomething went wrong'  
                  ], 500);
            }
        }
    }

    public function single($id)
    {
        $student = Student::find($id);

        if ($student) {
            return response()->json([
                'student'=>$student,
                'status'=> 200,
                'message'=>'Studentfound'
                
            ],200);
        }else {
            return response()->json([
                'status'=> 404,
                'message'=>'student not found'  
              ], 404);
        }
        
    }

    public function  update(Request $request, int $id)
    {

        $validator = Validator::make($request->all(), [
            'name'=> 'required| max:60',
            'email'=> 'required|email|max:100',
            'phone'=> 'required|digits:10'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'=> 422,
                'message'=> $validator->messages()
            ]);
        }else {
            $student= Student::find($id);

            if ($student) {
                $student->update([
                    'name'=> $request->name,
                    'email'=>$request->email,
                    'phone'=>$request->phone
                ]);
                
                return response()->json([
                  'status'=> 200,
                  'message'=>'student Updated successfully',
                  'student'=>$student
                ], 200);
            }else {
                return response()->json([
                    'status'=> 500,
                    'message'=>'something went wrong'  
                  ], 500);
            }
        }
    }

    public function  destroy($id)
    {
        $student = Student::find($id);

        if ($student) {
            $student->delete();
            return response()->json([
                'status'=> 200,
                'message'=>'Student deleted'
                
            ],200);
        }else {
            return response()->json([
                'status'=> 404,
                'message'=>'student not found'  
              ], 404);
        }

        
    }
}


