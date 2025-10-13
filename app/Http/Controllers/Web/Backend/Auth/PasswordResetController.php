<?php

namespace App\Http\Controllers\Web\Backend\Auth;

use App\Services\OtpService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PasswordResetController extends Controller
{
    protected $otpService;

    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
    }

    public function create(){
        return view("backend.layout.auth.ask-reset-mail");
    }

    public function submitMail(Request $request){
        $request->validate([
            "email"=> "required|email",
        ]);
        try{
            $otp = $this->otpService->generateOtp($request->email);
            $this->otpService->sendOtpEmail($request->email, $otp);
        }
        catch(\Exception $e){
            return redirect()->back()->with("error", $e->getMessage());
        }
        $email = $request->email;
        return view("backend.layout.auth.otp-page", compact("email"));
    }


    public function submitOtp(Request $request){
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:6',
        ]);

        if ($this->otpService->verifyOtp($request->email, $request->otp)) {
            // return response()->json(['message' => 'OTP verified']);
            return view('backend.layout.auth.reset-password');
        }

        return response()->json(['message' => 'Invalid OTP'], 422);
    }
}
