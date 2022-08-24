<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Problem;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;


class AdminController extends Controller
{
    public function users()
    {

        $user = User::where("type", "user")->get();

        return view("adminOperations.user", ['users' => $user]);
    }

    public function deleteUser($id)
    {

        $user = User::find($id);
        $user->delete();
        Session::flash('msg', 'User Deleted');


        return redirect('/adminOperations/user');
    }

    public function posts()
    {

        $problem = Problem::all();
        return view('adminOperations.posts', ['problems' => $problem]);
    }

    public function deletePost($id)
    {

        $problem = Problem::find($id);
        $problem->delete();
        Session::flash('msg', 'Post Deleted');


        return redirect('/adminOperations/posts');
    }

    public function adminRegistration()
    {
        return view('adminOperations.addAdmin');
    }

    public function addAdmin(Request $req)
    {
        $formVal = $req->validate(
            [
                'name' => 'required|max:20|alpha',
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
                "name.max" => "Name should not exceed 10 characters"
            ]
        );


        $formVal['password'] = bcrypt($formVal['password']);
        $formVal['type'] = "admin";
        User::create($formVal);

        Session::flash('msg', 'Registered Successfully');
        return redirect('/adminOperations/user');
    }

    //////////////

    //////////functions for admin Api ///////

    //////////////////





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
                    'name' => 'required|max:20|alpha',
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
            'posts' => $posts
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
