<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    //show register form

    public function create()
    {
        return view('users.register');
    }
    public function show()
    {
        return view('users.edit');
    }

    public function update(Request $req)
    {
        $formVal = $req->validate(
            [
                'name' => 'required|max:20|alpha',
                'email' => 'required|email',
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

        // if ($req->hasFile('p_file')) {
        //     $formVal['p_file'] = $req->file('p_file')->store('files', 'public');
        // }

        if (Hash::check($formVal['password'], Auth::user()->password, [])) {
            $formVal['password'] = bcrypt($formVal['password']);
        } else {
            $formVal['password'] = bcrypt($formVal['password']);
        }

        $user = User::find(auth()->user()->id);
        $user->update($formVal);

        Session::flash('msg', 'Profile Updated');

        return redirect('/');
    }



    public function store(Request $req)
    {
        $formVal = $req->validate(
            [
                'name' => 'required|max:20|alpha',
                'email' => 'required|email|unique:users,email|ends_with:.com,.me,.edu',
                'p_pic' => '',
                'password' => '',
                'password2' => ''
            ],
            [
                "name.required" => "The field is required",
                "email.required" => "The field is required",
                #"p_pic.required" => "The field is required",
                #"p_pic.mimes" => "The profile pic must be a file of type: png, jpg.",
                #"password.required" => "The field is required",
                # "password2.required" => "The field is required",
                #"password2.same" => "The password doesn't match ",
                "name.max" => "Name should not exceed 10 characters"
            ]
        );

        if ($req->hasFile('p_pic')) {
            $formVal['p_pic'] = $req->file('p_pic')->store('pictures', 'public');
        }

        $formVal['password'] = bcrypt($formVal['password']);
        User::create($formVal);

        // auth()->login($user);
        Session::flash('msg', 'Registered Successfully');
        return redirect('/login');
    }

    public function login()
    {
        return view('users.login');
    }

    public function logout(Request $req)
    {
        auth()->logout();

        $req->session()->invalidate();
        $req->session()->regenerateToken();

        Session::flash('msg', 'Logged Out Successfully');
        return redirect('/');
    }

    public function authenticate(Request $req)
    {
        $formVal = $req->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required'
        ]);

        $getUser =  $formVal["email"];

        $user = User::where("email", $getUser)->first();

        if ($user->type == "admin") {
            if (auth()->attempt($formVal)) {
                $req->session()->regenerate();

                Session::flash('msg', 'Logged in Successfully');
                return redirect('/adminOperations/user');
            } else {
                Session::flash('msg', 'Invalid Credentials');
                return back();
            }
        }


        if (auth()->attempt($formVal)) {
            $req->session()->regenerate();

            Session::flash('msg', 'Logged in Successfully');
            return redirect('/');
        } else {
            Session::flash('msg', 'Invalid Credentials');
            return back();
        }
    }
}
