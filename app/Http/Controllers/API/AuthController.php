<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required | email',
            'password' => 'required',
        ]);

        if($validator->fails())
        {
            // $email = User::where('email', $request->all());
            return response()->json([
                "validation_errors" => $validator->errors()
            ]);
        }else{
            $user = User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>Hash::make($request->password),
            ]);

            $token = $user->createToken($user->email.'_Token')->plainTextToken;

            return response()->json([
                'status'=>200,
                'username'=>$user->name,
                'token'=>$token,
                'message'=>"User creaated succesfully"
            ]);

       
        }

    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required | email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "validation_errors" => $validator->errors()
            ]);
        }else{
            $user = User::where('email', $request->email)->first();

            if(!$user || !Hash::check($request->password, $user->password)){
                return response()->json([
                    'status' => 401,
                    'message' => 'Invalid credentials'
                ]);
            }else{
                if($user->role_as == 1)
                {
                    $role = 'admin';
                    $tokens = $user->createToken($user->email.'AdminToken', ['server:admin'])->plainTextToken;
                }
                else
                {
                    $role = '';
                    $tokens = $user->createToken($user->email.'_Token', [''])->plainTextToken;
                }

                return response()->json([
                    'status'=>200,
                    'username'=>$user->name,
                    'token'=>$tokens,
                    'message'=>"Loged succesfully",
                    'role' => $role
                ]);
            }
        }
    }


    public function getUsers(Request $request)
    {
        $users = User::all();
        return response()->json([
            'users' => $users
        ]);
    }
}
