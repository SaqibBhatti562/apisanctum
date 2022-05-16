<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    public function resendverification(Request $request){

        $request->user()->sendEmailVerificationNotification();

        return ['Message' => ' Verification has been send '];
    
   }
}
