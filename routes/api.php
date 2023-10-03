<?php

use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/** Route to Create Student */
Route::post("/student/create",[StudentController::class,"createStudent"]);
