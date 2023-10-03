<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function createStudent(Request $request){

        $validator = Validator::make($request->all(),[
            "name"=>"required",
            "roll_no"=>"required",
            "stream"=>"required",
            "year"=>"required",
            "dob"=>"required",
            "city"=>"required"
        ]);

        if($validator->fails()){
            return response()->json([
                "status" => "failure",
                "status_code" => 400,
                "message" => "Validation Error",
                "errors" => $validator->errors()
            ]);
        }

        try{

            $student = new Student();
            $student->name = $request->name;
            $student->roll_no = $request->roll_no;
            $student->stream = $request->stream;
            $student->year = $request->year;
            $student->dob = $request->dob;
            $student->city = $request->city;
            $student->save();

            return response()->json([
                "status" => "success",
                "status_code" => 200,
                "message" => "Student Created Successfully",
                "data" => $student
            ]);

        }catch(Exception $e){
            return response()->json([
                "status" => "failure",
                "status_code" => 500,
                "message" => "Internal Server Error",
                "errors" => $e->getMessage()
            ]);
        }
    }
}
