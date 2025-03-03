<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class ResetPasswordController extends Controller
{
    // Show reset password form
    public function showResetPasswordForm($token)
    {
        return view('ResetPassword', ['token' => $token]);
    }

   public function submitResetPasswordForm(Request $request)
    {
        // Validate request data
        $request->validate([
            "email" => "required|email|exists:users,email",
            "password" => [
                "required",
                "string",
                "min:8",               // Minimum 8 characters
                "regex:/[A-Z]/",       // At least one uppercase letter
                "regex:/[\W]/",        // At least one special character
                "confirmed"            // Must match password_confirmation
            ],
            "password_confirmation" => "required"
        ], [
            "password.min" => "Password must be at least 8 characters.",
            "password.regex" => "Password must contain at least one uppercase letter and one special character.",
            "password.confirmed" => "Password confirmation does not match."
        ]);

        // Check if the reset token exists
        $updatePassword = DB::table('password_resets')
            ->where([
                "email" => $request->email,
                "token" => $request->token
            ])->first();

        if (!$updatePassword) {
            return redirect()->route('reset.password')->with("error", "Invalid or expired token.");
        }

        // Update user's password
        User::where("email", $request->email)
            ->update(["password" => Hash::make($request->password)]);

        // Delete password reset entry
        DB::table('password_resets')->where(["email" => $request->email])->delete();

        return redirect()->route('login')->with("success",  "Password Updated Successfully!");
    }



   

       
}
