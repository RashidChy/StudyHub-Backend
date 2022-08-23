<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Problem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;


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
}
