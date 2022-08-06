<?php

namespace App\Http\Controllers;

use App\Models\Problem;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class ProblemController extends Controller
{
    //
    public function index()
    {

        return view('problems.index', [
            'heading' => 'Latest Problems',
            'problems' => Problem::latest()->filter(request(['tag', 'search']))->paginate(6)
        ]);
    }

    public function showFile($name)
    {
        return redirect('storage/files/' . $name);
    }

    public function show($id)
    {
        $problem = Problem::find($id);
        $comment = Comment::where("problem_id", $id)->get();

        if ($problem) {
            return view(
                'problems.show',
                [
                    'problem' => $problem,
                    'comments' => $comment
                ]
            );
        } else {
            abort('404');
        }
    }

    public function create()
    {

        return view('problems.create');
    }

    public function store(Request $req)
    {
        $formVal = $req->validate([
            'title' => 'required|max:100',
            'email' => 'required|email|ends_with:.com,.me,.edu',
            'tags' => 'required',
            'description' => 'required|max:600'
        ]);

        if ($req->hasFile('p_file')) {
            $formVal['p_file'] = $req->file('p_file')->store('files', 'public');
        }

        $formVal['user_id'] = auth()->user()->id;

        Problem::create($formVal);

        Session::flash('msg', 'Problem Created');

        return redirect('/');
    }

    //Show edit form
    public function edit($id)
    {
        $problem = Problem::find($id);
        return view('problems.edit', ['problem' => $problem]);
    }

    //Show update form
    public function update($id, Request $req)
    {
        $problem = Problem::find($id);
        if ($problem->user_id != auth()->user()->id) {
            abort(403, 'Unauthorized action');
        }
        $formVal = $req->validate([
            'title' => 'required|max:20',
            'email' => 'required|email|ends_with:.com,.me,.edu',
            'tags' => 'required',
            'description' => 'required|max:600'
        ]);

        if ($req->hasFile('p_file')) {
            $formVal['p_file'] = $req->file('p_file')->store('files', 'public');
        }
        $problem->update($formVal);

        Session::flash('msg', 'Problem Updated');


        return redirect('/');
    }

    //Show delete form
    public function delete($id)
    {

        $problem = Problem::find($id);
        $problem->delete();
        Session::flash('msg', 'Problem Deleted');


        return redirect('/');
    }

    //Smanage
    public function manage()
    {
        $user_id = auth()->user()->id;
        $problem = Problem::where('user_id', $user_id)->get();
        return view('problems.manage', ['problems' => $problem]);
    }
}
