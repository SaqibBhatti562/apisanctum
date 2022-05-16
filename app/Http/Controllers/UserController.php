<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Expr\FuncCall;
use Illuminate\Auth\Events\Registered;
 

class UserController extends Controller
{
    public function register(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        $token = $user->CreateToken('mytoken')->plainTextToken;
        

        return response([
            'user'=>$user,
            'token'=>$token,
        ], 201);
    }

    public function logout(){
        auth()->user()->tokens()->delete();
        return response([
            'massage'=>'Succefully Logged Out !!'
        ]);
    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user= User::where('email', $request->email)->first();

        if(!$user || !Hash::check($request->password, $user->password )){
            return response([
                'message'=> 'The Provided Credentials are Incoreect.'
            ],401);
        }

        $token = $user->CreateToken('mytoken')->plainTextToken;

        return response([
            'user'=>$user,
            'token'=>$token,
        ], 200);
    }
}
