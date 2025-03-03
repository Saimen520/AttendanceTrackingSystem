<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;

Route::post('/attendance', [AttendanceController::class, 'scanRfid'])->name('api.attendance');
