<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Create User
     * @param Request $request
     * @return User 
     */
    public function createUser(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make(
                $request->all(),
                [
                    'name' => 'required|max:20',
                    'email' => 'required|email|unique:users,email',
                    'password' => 'required|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/i',
                    'password2' => 'required|same:password'
                ],
                [
                    "name.required" => "The field is required",
                    "email.required" => "The field is required",
                    "password.required" => "The field is required",
                    "password2.required" => "The field is required",
                    "password2.same" => "The password doesn't match ",
                    "name.max" => "Name should not exceed 20 characters"
                ]
            );
            if ($request->hasFile('pic')) {
                $pic = $request->file('pic')->store('pictures', 'public');
            } else {
                $pic = null;
            }

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 200);
            }

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'type' => "user",
                'p_pic' => $pic
            ]);

            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Login The User
     * @param Request $request
     * @return User
     */
    public function loginUser(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'email' => 'required|email',
                    'password' => 'required'
                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 200);
            }

            if (!Auth::attempt($request->only(['email', 'password']))) {
                return response()->json([
                    'status' => false,
                    'message' => 'Email & Password does not match with our record.',
                ], 200);
            }

            $user = User::where('email', $request->email)->first();

            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken,
                'user' => $user
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function viewProfile()
    {
        return response()->json(auth()->user());
    }


    ///profile update///


    public function updateProfile(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'email' => 'required|email'
                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation Error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $user = User::whereId($request->id)->first();

            $user->update([
                'name' => $request->name,
                'email' => $request->email
            ]);


            return response()->json([
                'message' => 'Updated Successfully'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function destroyUser($id)
    {
        try {
            $user = User::whereId($id)->first();

            if ($user->user_id == auth()->user()->id) {

                User::whereId($id)->first()->delete();
                return response()->json('Deleted');
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
