<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    function index(){

        $students = Student::all();

        // $data = [
        //     'status'=> 200,
        //     'students' => $students,
        // ];
        //  return response()->json($data, 200);

        if($students ->count() >0 ){
            return response()->json([
                'status'=>200,
                'students'=>$students, 
            ]);
        }
        else{
            return response()->json([
                'status'=>404,
                'message'=> 'No Records Found', 
            ]);
        }
      
    }



    function store(Request $request){
        // $validator =  $request->validate([
        //     'name'=>'required',
        //     'email '=>'required|email|unique:students,email',
        //     'phone '=>'required',
        // ]);

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:students,email',
            'phone' => 'required|min:11|numeric|unique:students,phone',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=> 422,       // input error status 422
                'error'=> $validator->messages(),
            ]);
        }
        else{
            $student = Student::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'phone'=>$request->phone,

            ]);
            if($student){
                return response()->json([
                    'status'=>200,
                    'message'=>'Student Created Successfully !',
                ]);
            }
            else{
                return response()->json([
                    'status'=>500,
                    'message'=>'something wrong !',
                ]);
            }
        }
    }



    function showStudentRecord($id){
        $student = Student::find($id);

        if($student){
            return response()->json([
                'status'=> 200,
                'student'=>$student,
            ]);
        }
        else{
            return response()->json([
                'status'=> 404,
                'message'=>"No Such Student Found !",
            ]);
        }
    }




    function edit($id){
        $student =  Student::find($id);

        if($student){
            return response()->json([
                'status'=> 200,
                'student'=>$student,
            ]);
        }
        else{
            return response()->json([
                'status'=>200,
                'message'=>"No Such Student Found !", 
            ]);
        }
    }


    function update(Request $request, int $id){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:students,email',
            'phone' => 'required|min:11|numeric|unique:students,phone',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=> 422,       // input error status 422
                'error'=> $validator->messages(),
            ]);
        }
        else{
            $student = Student::find($id);
            
            if($student){

                $student->update([
                    'name'=>$request->name,
                    'email'=>$request->email,
                    'phone'=>$request->phone,
    
                ]);

                return response()->json([
                    'status'=>200,
                    'message'=>'Student Updated Successfully !',
                ]);
            }
            else{
                return response()->json([
                    'status'=>404,
                    'message'=>'No Such Studen Found !',
                ]);
            }
        }
    }



    function destroy($id){
        $student = Student::find($id);

        if($student){
            $student->delete();
            return response()->json([
                'status'=>200,
                'message'=>'Student Deleted Successfully !',
            ],200);
        }
        else{
            return response()->json([
                'status'=>404,
                'message'=>'No Such Studen Found !',
            ],404);
        }
    }

}
