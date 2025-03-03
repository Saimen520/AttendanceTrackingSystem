<?php


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AttendanceController;


Route::get('/', function () {
    return view('welcome');
}); 

Route::get('/home/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('LoginPage', function () {
    return view('LoginPage');
})->name('LoginPage');

Route::get('ForgetPassword', function () {
    return view('ForgetPassword');
})->name('ForgetPassword');


Route::post('/ForgetPassword', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post');

Route::get('/ResetPassword/{token}', [ResetPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('/ResetPassword', [ResetPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');


//Homepage
Route::get('HomePage', [HomeController::class, 'index'])->name('HomePage')->middleware('auth');

//Profile Page 
Route::get('/profile', function () {
    return view('Profile');
})->name('Profile')->middleware('auth');

//Logout Page
Route::post('/logout', function () {
    Auth::logout();
    return redirect('auth.login'); // Redirect to login page after logout
})->name('logout');


//Reuqest Leave Page 
Route::middleware(['auth'])->group(function () {
  Route::get('/leave-request', [LeaveRequestController::class, 'index'])->name('LeaveRequest');
Route::post('/leave-requests', [LeaveRequestController::class, 'store'])->name('leave.store');

    Route::get('/leave-approve', [LeaveRequestController::class, 'showPending'])->name('ApproveRequest');
     Route::put('/leave-update/{id}', [LeaveRequestController::class, 'updateStatus'])->name('leave.updateStatus');
});

// Only Admin & HR can post announcements
Route::middleware(['auth',])->group(function () {
    Route::get('/announcement', [AnnouncementController::class, 'create'])->name('Announcement');
    Route::post('/announcement', [AnnouncementController::class, 'store'])->name('announcement.store');
});

// All users can view announcements
Route::get('/view-announcement', [AnnouncementController::class, 'index'])->name('ViewAnnouncement');
Route::post('/announcements/mark-as-read', [AnnouncementController::class, 'markAllAsRead'])->name('announcements.markAsRead');


Route::get('/check-notifications', function () {
    $unreadCount = 0;
    if (Auth::check()) {
        $unreadCount = Auth::user()->announcements()->wherePivot('read', false)->count();
    }
    return response()->json(['unreadCount' => $unreadCount]);
})->name('check_notifications');

Route::delete('/announcement/{id}', [AnnouncementController::class, 'destroy'])
    ->name('announcement.destroy')
    ->middleware('auth'); 

Route::get('overall_attendance', function () {
    return view('overall_attendance');
})->name('overall_attendance');


// Route to record attendance (Check-in/Check-out)
Route::post('/attendance', [AttendanceController::class, 'scanRfid'])->name('api.attendance');

// Route to display attendance records (Blade View)
Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');

// Route to fetch attendance records as JSON (For AJAX)
Route::get('/attendance-data', [AttendanceController::class, 'getAttendanceData'])->name('attendance.data');


Route::get('/rfid-check/{rfid}', function ($rfid) {
    $response = Http::post(url('/api/attendance'), [
        'rfid_uid' => $rfid
    ]);

    return view('attendance', ['response' => $response->json()]);
});

Auth::routes();

