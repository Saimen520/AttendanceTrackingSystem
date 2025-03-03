<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
     public function showForgetPasswordForm()
    {
        return view('ForgetPassword');
    }

   public function submitForgetPasswordForm(Request $request)
    {
        try {
            // Validate email format and existence in the database
            $request->validate([
                'email' => 'required|email|exists:users,email'
            ]);

            // Generate token
            $token = Str::random(64);

            // Store the token in the password_resets table
            DB::table('password_resets')->insert([
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now()
            ]);

            // Send reset email
            Mail::send('emails.passwordReset', ['token' => $token], function ($message) use ($request) {
                $message->to($request->email);
                $message->subject('Reset Password Notification');
            });

            return redirect()->route('ForgetPassword')->with('success', 'Check Your Email To Reset Password');

        } catch (\Illuminate\Validation\ValidationException $e) {
            // If validation fails (email not found), redirect back with an error message
            return redirect()->route('ForgetPassword')->with('error', 'No account found with this email.');
        }
    }

   
}
