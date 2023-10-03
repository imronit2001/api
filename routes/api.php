<?php

use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/** Route to Create Student */
Route::post("/student/create",[StudentController::class,"createStudent"]);

/** Route to Fetch All Student's Data */
Route::get("/student/fetch",[StudentController::class,"fetchStudents"]);

/** Route to Fetch All Students who study in BCA */
Route::get("/student/fetch/bca",[StudentController::class,"fetchBCAStudents"]);

/** Route to Fetch All Student according to their stream */
Route::get("/student/fetch/stream",[StudentController::class,"fetchStudentsByStream"]);

/** Route to Fetch Students whose name starts with a character */
Route::get("/student/fetch/character",[StudentController::class,"fetchStudentsByCharacter"]);

/** Route to Fetch Student by Id */
Route::get("/student/details",[StudentController::class,"fetchStudentDetails"]);

/** Route to Fetch student in ascending order or their name */
Route::get("/student/fetch/ascending",[StudentController::class,"fetchStudentsInAscendingOrder"]);

/** Route to Fetch All Student Age */
Route::get("/student/fetch/age",[StudentController::class,"fetchStudentsAge"]);
