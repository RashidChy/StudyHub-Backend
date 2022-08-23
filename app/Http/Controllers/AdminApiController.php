<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Problem;
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
    public function createAdmin(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'email' => 'required|email|unique:users,email',
                    'password' => 'required'
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
                'type' => "admin",
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



    public function viewAdminProfile()
    {
        return response()->json(auth()->user());
    }


    public function viewAllAdmins()
    {
        $admins = User::where("type", "admin")->get();
        return response()->json($admins);
    }

    public function viewUsers()
    {
        $user = User::all();
        return response()->json([
            'status' => true,
            'users' => $user
        ], 200);
    }

    public function viewComments()
    {
        $comment = Comment::all();
        return response()->json([
            'status' => true,
            'users' => $comment
        ], 200);
    }

    public function viewPosts()
    {
        $posts = Problem::all();
        return response()->json([
            'status' => true,
            'users' => $posts
        ], 200);
    }


    ///update Functions///


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

    public function updatePost(Request $request)
    {
        $listing = Problem::whereId($request->id)->first();

        if ($listing !== null) {

            $listing->update([
                'title' => $request->title,
                'tags' => $request->tags,
                'description' => $request->description
            ]);

            return response()->json('Success');
        } else {
            return response()->json('Error');
        }
    }

    // Destroy Functions

    public function destroyUser($id)
    {
        try {
            $user = User::whereId($id)->first();

            if ($user !== null) {

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

    public function destroyPost($id)
    {
        try {
            $listing = Problem::whereId($id)->first();

            if ($listing !== null) {

                Problem::whereId($id)->first()->delete();
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function destroyComment($id)
    {
        try {
            $comment = Comment::whereId($id)->first();

            if ($comment !== null) {

                Comment::whereId($id)->first()->delete();
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
