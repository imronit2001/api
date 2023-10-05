<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    /** Function to Create Student */
    public function createStudent(Request $request)
    {

        $validator = Validator::make($request->all(), [
            "name" => "required",
            "roll_no" => "required",
            "stream" => "required",
            "year" => "required",
            "dob" => "required",
            "city" => "required"
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => "failure",
                "status_code" => 400,
                "message" => "Validation Error",
                "errors" => $validator->errors()
            ]);
        }

        try {

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
        } catch (Exception $e) {
            return response()->json([
                "status" => "failure",
                "status_code" => 500,
                "message" => "Internal Server Error",
                "errors" => $e->getMessage()
            ]);
        }
    }

    /** Function to Fetch All Students */
    public function fetchStudents()
    {
        try {
            $student = Student::get();

            return response()->json([
                "status" => "success",
                "status_code" => 200,
                "message" => "Students Fetched Successfully",
                "data" => $student
            ]);
        } catch (Exception $e) {
            return response()->json([
                "status" => "failure",
                "status_code" => 500,
                "message" => "Internal Server Error",
                "errors" => $e->getMessage()
            ]);
        }
    }

    /** Function to fetchBCAStudents */
    public function fetchBCAStudents()
    {
        try {
            $student = Student::where("stream", "BCA")->get();

            return response()->json([
                "status" => "success",
                "status_code" => 200,
                "message" => "BCA Students Fetched Successfully",
                "data" => $student
            ]);
        } catch (Exception $e) {
            return response()->json([
                "status" => "failure",
                "status_code" => 500,
                "message" => "Internal Server Error",
                "errors" => $e->getMessage()
            ]);
        }
    }

    /** Function to fetchStudentsByStream */
    public function fetchStudentsByStream(Request $request)
    {
        try {

            $student = [];

            if ($request->has("stream")) {
                $student = Student::where("stream", $request->stream)->get();
            } else {
                $student = Student::get();
            }

            return response()->json([
                "status" => "success",
                "status_code" => 200,
                "message" => "Students Fetched Successfully",
                "data" => $student
            ]);
        } catch (Exception $e) {
            return response()->json([
                "status" => "failure",
                "status_code" => 500,
                "message" => "Internal Server Error",
                "errors" => $e->getMessage()
            ]);
        }
    }

    /**  Function to fetchStudentsByCharacter */
    public function fetchStudentsByCharacter(Request $request)
    {
        try {

            $student = [];
            if ($request->has("character")) {
                $student = Student::where("name", "like", $request->character . "%")->get();
            }

            return response()->json([
                "status" => "success",
                "status_code" => 200,
                "message" => "Students Fetched Successfully",
                "data" => $student
            ]);
        } catch (Exception $e) {
            return response()->json([
                "status" => "failure",
                "status_code" => 500,
                "message" => "Internal Server Error",
                "errors" => $e->getMessage()
            ]);
        }
    }

    /** Function to fetchStudentDetails */
    public function fetchStudentDetails(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "id" => "required"
            ]);

            if ($validator->fails()) {
                return response()->json([
                    "status" => "failure",
                    "status_code" => 400,
                    "message" => "Validation Error",
                    "errors" => $validator->errors()
                ]);
            }

            $student = Student::where("id", $request->id)->first();

            if ($student) {
                return response()->json([
                    "status" => "success",
                    "status_code" => 200,
                    "message" => "Student Fetched Successfully",
                    "data" => $student
                ]);
            } else {
                return response()->json([
                    "status" => "failure",
                    "status_code" => 404,
                    "message" => "Student Not Found",
                    "data" => []
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                "status" => "failure",
                "status_code" => 500,
                "message" => "Internal Server Error",
                "errors" => $e->getMessage()
            ]);
        }
    }

    /** Function to fetchStudentsInAscendingOrder */
    public function fetchStudentsInAscendingOrder()
    {
        try {
            $student = Student::orderBy("name", "asc")->get();

            return response()->json([
                "status" => "success",
                "status_code" => 200,
                "message" => "Students Fetched Successfully",
                "data" => $student
            ]);
        } catch (Exception $e) {
            return response()->json([
                "status" => "failure",
                "status_code" => 500,
                "message" => "Internal Server Error",
                "errors" => $e->getMessage()
            ]);
        }
    }

    /** Function to fetchStudentsAge */
    public function fetchStudentsAge()
    {
        try {

            $student = Student::get();

            foreach ($student as $s) {
                $s->age = date_diff(date_create($s->dob), date_create(date("Y-m-d")))->y;
            }

            return response()->json([
                "status" => "success",
                "status_code" => 200,
                "message" => "Students Age Fetched Successfully",
                "data" => $student
            ]);
        } catch (Exception $e) {
            return response()->json([
                "status" => "failure",
                "status_code" => 500,
                "message" => "Internal Server Error",
                "errors" => $e->getMessage()
            ]);
        }
    }

    /** Function to updateStudentName */
    public function updateStudentName(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                "id" => "required",
                "name" => "required"
            ]);

            if ($validator->fails()) {
                return response()->json([
                    "status" => "failure",
                    "status_code" => 400,
                    "message" => "Validation Error",
                    "errors" => $validator->errors()
                ]);
            }

            $student = Student::where([["id", $request->id]])->first();

            if (!$student) {
                return response()->json([
                    "status" => "failure",
                    "status_code" => 404,
                    "message" => "Student Not Found",
                    "data" => []
                ]);
            }

            $student->name = $request->name;
            $student->save();

            return response()->json([
                "status" => "success",
                "status_code" => 200,
                "message" => "Student Name Updated Successfully",
                "data" => $student
            ]);
        } catch (Exception $e) {
            return response()->json([
                "status" => "failure",
                "status_code" => 500,
                "message" => "Internal Server Error",
                "errors" => $e->getMessage()
            ]);
        }
    }

    /** Function to updateStudentDetails */
    public function updateStudentDetails(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "id" => "required",
            ]);

            if ($validator->fails()) {
                return response()->json([
                    "status" => "failure",
                    "status_code" => 400,
                    "message" => "Validation Error",
                    "errors" => $validator->errors()
                ]);
            }

            $student = Student::where([["id", $request->id]])->first();

            if (!$student) {
                return response()->json([
                    "status" => "failure",
                    "status_code" => 404,
                    "message" => "Student Not Found",
                    "data" => []
                ]);
            }

            if ($request->has("name")) {
                $student->name = $request->name;
            }

            if ($request->has("roll_no")) {
                $student->roll_no = $request->roll_no;
            }

            if ($request->has("stream")) {
                $student->stream = $request->stream;
            }

            if ($request->has("year")) {
                $student->year = $request->year;
            }

            if ($request->has("dob")) {
                $student->dob = $request->dob;
            }

            if ($request->has("city")) {
                $student->city = $request->city;
            }

            $student->save();

            return response()->json([
                "status" => "success",
                "status_code" => 200,
                "message" => "Student Details Updated Successfully",
                "data" => $student
            ]);
        } catch (Exception $e) {
            return response()->json([
                "status" => "failure",
                "status_code" => 500,
                "message" => "Internal Server Error",
                "errors" => $e->getMessage()
            ]);
        }
    }

    /** Function to updateStudentCity */
    public function updateStudentCity(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                "city" => "required",
                "size" => "required"
            ]);

            if ($validator->fails()) {
                return response()->json([
                    "status" => "failure",
                    "status_code" => 400,
                    "message" => "Validation Error",
                    "errors" => $validator->errors()
                ]);
            }

            $data = [];

            for ($i = 1; $i <= $request->size; $i++) {
                $id = $request->input("id_" . $i);
                $student = Student::where([["id", $id]])->first();
                if ($student) {
                    $student->city = $request->city;
                    $student->save();
                    $data[] = $student;
                }
            }

            return response()->json([
                "status" => "success",
                "status_code" => 200,
                "message" => "Student City Updated Successfully",
                "data" => $data
            ]);
        } catch (Exception $e) {
            return response()->json([
                "status" => "failure",
                "status_code" => 500,
                "message" => "Internal Server Error",
                "errors" => $e->getMessage()
            ]);
        }
    }

    /** Function to updateStudentCityByIdArray */
    public function updateStudentCityByIdArray(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                "city" => "required",
                "ids" => "required",
            ]);

            if ($validator->fails()) {
                return response()->json([
                    "status" => "failure",
                    "status_code" => 400,
                    "message" => "Validation Error",
                    "errors" => $validator->errors()
                ]);
            }

            $ids = $request->ids;

            $data = [];
            foreach ($ids as $id) {
                $student = Student::where([["id", $id]])->first();
                if ($student) {
                    $student->city = $request->city;
                    $student->save();
                    $data[] = $student;
                }
            }


            return response()->json([
                "status" => "success",
                "status_code" => 200,
                "data" => $data
            ]);
        } catch (Exception $e) {
            return response()->json([
                "status" => "failure",
                "status_code" => 500,
                "message" => "Internal Server Error",
                "errors" => $e->getMessage()
            ]);
        }
    }

    /** Function to updateStudentCityDifferent */
    public function updateStudentCityDifferent(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                "param" => "required"
            ]);

            if($validator->fails()){
                return response()->json([
                    "status" => "failure",
                    "status_code" => 400,
                    "message" => "Validation Error",
                    "errors" => $validator->errors()
                ]);
            }

            $data = [];

            foreach($request->param as $x){
                $city = $x['city'];
                $id = $x['id'];

                $student = Student::where([["id",$id]])->first();
                if($student){
                    $student->city = $city;
                    $student->save();
                    $data[] = $student;
                }
            }

            return response()->json([
                "status" => "success",
                "status_code" => 200,
                "message" => "Student City Updated Successfully",
                "data" => $data
            ]);




        } catch (Exception $e) {
            return response()->json([
                "status" => "failure",
                "status_code" => 500,
                "message" => "Internal Server Error",
                "errors" => $e->getMessage()
            ]);
        }
    }
}
