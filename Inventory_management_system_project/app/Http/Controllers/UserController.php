<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Mail\OTPMail;
use App\Helper\JWTToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{



    public function UserRegistration(Request $request) {
        
        try {

            User::create([
                'firstName' => $request->input('firstName'),
                'lastName' => $request->input('lastName'),
                'email' => $request->input('email'),
                'mobile' => $request->input('mobile'),
                'password' => $request->input('password'),
              ]);
      
              return response()->json([
                  'status' => 'success',
                  'message' => 'User Registration Success !'
              ]);

        } 
        catch (Exception $e) {
            return response()->json([
                'status' => 'Failed',
                'message' => $e->getMessage(),
            ]);
        }          
    }

    public function UserLogin(Request $request) {

        $count= User::where('email', $request->input('email'))
                   ->where('password', $request->input('password'))
                   ->select('id')
                   ->first();
                   

          if($count !== null) {
             $token = JWTToken::CreateToken($request->input('email') , $count->id);
             return response()->json([
                   'status' => 'success',
                   'message' => 'User Successfully Loged In',
                   'token' => $token
             ]);
          } else {
            return response()->json([
                'status' => 'error',
                'message' => 'unathorized login failed'
            ]);
          }

    }

    public function SendOTPCode(Request $request) {
        $email = $request->input('email');
        $otp = rand(1000, 9999);

        $count = User::where('email', '=' , $email)->count();

        if($count == 1) {            
            // Send OTP to Email Address
          Mail::to($email)->send(new OTPMail($otp));

            // Update OTP to Database table
          User::where('email', '=' , $email)->update(['otp' => $otp]);  

          return response()->json([
            'status' => 'success',
            'message' => 'Check your Email'
        ]);
        }

        else {

            return response()->json([
                'status' => 'failed',
                'message' => 'unauthorized'
            ]);
        }
    }

    public function VerifyOTP(Request $request) {

        $email = $request->input('email');
        $otp = $request->input('otp');

        $count = User::where('email', '=' , $email)
                   ->where('otp', '=', $otp) 
                   ->count();


        if($count == 1) {
            //Update OTP to Database
            User::where('email', '=' , $email)->update(['otp' => '0']);
           

            //Issue a token for Password reset
            $token = JWTToken::CreateTokenForSetPassword($request->input('email'));
            return response()->json([
                  'status' => 'success',
                  'message' => 'OTP verification Successfully',
                  'token' => $token
            ])->cookie('token', $token, 60*24*30);


           } else {

            return response()->json([
                'status' => 'failed',
                'message' => 'unauthorized',
            ]);
           }       
    }

    public function ResetPassword(Request $request) {
     
    try{ 

        $email = $request->header('email');
        $password = $request->input('password');
        User::where('email', '=' , $email)->update(['password' => $password]);

        return response()->json([
            'status' => 'success',
            'message' => 'Successfully Reset Password',
        
      ]);
    }
    catch(Exception $e)  {
        return response()->json([
            'status' => 'Failed',
            'message' => 'Ooopps! Something went wrong',
            
      ]);
    }

    }

    public function UserLogout() {
        return redirect('/userLogin')->cookie('token' , "" , -1);
    }

    public function UserProfile(Request $request) {
        $email = $request->header('email');
        $user = User::where('email', "=", $email)->first();
        return response()->json([
           'status' => 'success',
           'message' => 'Reguest successfully logged',
           'data' => $user
        ]);
    }

    public function UpdateProfile(Request $request) {
        try {
            $email = $request->header('email');
            $firstName = $request->input('firstName');
            $lastName = $request->input('lastName');
            $mobile = $request->input('mobile');
            $password = $request->input('password');
 
            User::where('email', '=' , $email)->update([
               'firstName' => $firstName,
               'lastName' => $lastName,
               'mobile' => $mobile,
               'password' => $password
            ]); 
            return response()->json([
                'status' => 'success',
                'message' => 'Request successfully updated'
            ]);
        } 
        catch (Exception $e) {
            return response()->json([
                'status' => 'unauthorized',
                'message' => $e->getMessage()
            ]);
        }
    }


}
