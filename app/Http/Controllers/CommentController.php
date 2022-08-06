<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Problem;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class CommentController extends Controller
{
    public function storeComment(Request $req, $id)
    {
        $user = User::find(auth()->user()->id);
        $u_id = $user->id;
        $formVal = $req->validate(['text' => 'required|max:1000']);
        $formVal['problem_id'] = $id;
        $formVal['user_id'] = $u_id;
        $formVal['problem_id'] = $id;

        Comment::create($formVal);

        Session::flash('msg', 'comment posted');



        return redirect()->back();
    }
}
