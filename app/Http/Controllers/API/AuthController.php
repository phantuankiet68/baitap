<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
    * login handle user
    * @author KietPT
    */
    public function login(Request $request){
        try {
            $validateUser = Validator::make($request->all(), 
            [
                'email' => 'required|max:30|min:10',
                'password' => 'required|max:30|min:8'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'errors' => $validateUser->errors()
                ], 422);
            }

            if(!Auth::attempt($request->only(['email', 'password']))){
                return response()->json([
                    'status' => 401,
                    'errors' => 'Email & Password does not match with our record.',
                ], 401);
            }

            $user = User::where('email', $request->email)->first();

            return response()->json([
                'status' => true,
                'errors' => 'User Logged In Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    /**
    * register handle user
    * @author KietPT
    */
    public function register(Request $request)
    {
        try {
            //Validated
            $validator = Validator::make($request->all(), 
            [
                'name' => 'required|max:30',
                'email' => 'required|email|max:30|min:10|unique:users,email',
                'password' => 'required|max:30|min:8',
                'c_password' =>'required|same:password',
            ]);

            if($validator->fails()){
                $response = [
                    'status' => false,
                    'errors' => $validator->errors()
                ];
                return response()->json($response, 422);
            }

            $input = $request->all();

            $input['password'] = bcrypt($input['password']);
            $user = User::create($input);

            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
                
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    /**
    * logout handle user
    * @author KietPT
    */
    public function logout(Request $request){
        $request->user()->tokens()->delete();

        return response()->json([
        'message' => 'Successfully logged out'
    ]);
}
}
