<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Attendance;

class AttendanceController extends Controller
{
    // Display attendance records in a Blade view
    public function index()
    {
        $attendances = Attendance::orderBy('date', 'desc')->get();
        return view('attendance', compact('attendances'));
    }

    public function scanRfid(Request $request)
{
    try {
        $request->validate([
            'rfid_uid' => 'required|string',
        ]);

        $user = User::where('rfid_uid', $request->rfid_uid)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $today = \Carbon\Carbon::today()->toDateString();
        $existingAttendance = Attendance::where('user_id', $user->id)
                                        ->where('date', $today)
                                        ->first();

        if ($existingAttendance) {
            if (!$existingAttendance->time_out) {
                $existingAttendance->update([
                    'time_out' => now()->toTimeString(),
                ]);
                return response()->json([
                    'message' => 'Check-out recorded successfully',
                    'user' => $user->name,
                ], 200);
            } else {
                return response()->json([
                    'message' => 'User already checked out today',
                    'user' => $user->name,
                ], 200);
            }
        }

        // Record Check-in
        Attendance::create([
            'user_id' => $user->id,
            'user_name' => $user->name,
            'date' => $today,
            'time_in' => now()->toTimeString(),
        ]);

        return response()->json([
            'message' => 'Check-in recorded successfully',
            'user' => $user->name,
        ], 200);
        
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Something went wrong',
            'details' => $e->getMessage()
        ], 500);
    }
}

    // Fetch attendance data for AJAX
    public function getAttendanceData()
    {
        $attendances = Attendance::orderBy('date', 'desc')->get();
        return response()->json($attendances);
    }
}
