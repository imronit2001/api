<?php

use App\Http\Controllers\StudentController;
use App\Http\Controllers\TokenController;
use App\Http\Middleware\ApiTokenVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware([ApiTokenVerification::class])->group(function () {

    /** Route to Create Student */
    Route::post("/student/create", [StudentController::class, "createStudent"]);

    /** Route to Fetch All Student's Data */
    Route::get("/student/fetch", [StudentController::class, "fetchStudents"]);

    /** Route to Fetch All Students who study in BCA */
    Route::get("/student/fetch/bca", [StudentController::class, "fetchBCAStudents"]);

    /** Route to Fetch All Student according to their stream */
    Route::get("/student/fetch/stream", [StudentController::class, "fetchStudentsByStream"]);

    /** Route to Fetch Students whose name starts with a character */
    Route::get("/student/fetch/character", [StudentController::class, "fetchStudentsByCharacter"]);

    /** Route to Fetch Student by Id */
    Route::get("/student/details", [StudentController::class, "fetchStudentDetails"]);

    /** Route to Fetch student in ascending order or their name */
    Route::get("/student/fetch/ascending", [StudentController::class, "fetchStudentsInAscendingOrder"]);

    /** Route to Fetch All Student Age */
    Route::get("/student/fetch/age", [StudentController::class, "fetchStudentsAge"]);

    /** Route to update name of a student by id */
    Route::get("/student/update/name", [StudentController::class, "updateStudentName"]);

    /** Route to update student details */
    Route::get("/student/update/details", [StudentController::class, "updateStudentDetails"]);

    /** Route to update city of multiple student */
    Route::post("/student/update/city", [StudentController::class, "updateStudentCity"]);

    /** Route to update city of multiple student by sending id in array */
    Route::post("/student/update/city/array", [StudentController::class, "updateStudentCityByIdArray"]);

    /** Route to update city of different student */
    Route::post("/student/update/city/different", [StudentController::class, "updateStudentCityDifferent"]);

    /** Route to delete student by id */
    Route::get("/student/delete", [StudentController::class, "deleteStudentById"]);

    /** Route to mark student as is deleted true  */
    Route::delete("/student/delete", [StudentController::class, "markIsDeletedTrue"]);

    /** Route to mark student as is deleted false */
    Route::put("/student/delete", [StudentController::class, "markIsDeletedFalse"]);

    /** Route to upload profile image */
    Route::post("/student/upload/profile-image", [StudentController::class, "uploadProfileImage"]);

    /** Route to upload multiple files */
    Route::post("/student/upload/certificates", [StudentController::class, "uploadStudentCertificates"]);
});

/** Route to generate token */
Route::get("/token-get", [TokenController::class, "getToken"]);
