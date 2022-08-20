<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentApiController extends Controller
{
    //Get Comment

    public function fetch($id)
    {
        $comment = Comment::where("problem_id", $id)->with('user')->get();
        return response()->json($comment);
    }



    //Create Comment
    public function addComment($id, Request $request)
    {
        try {
            //Validated
            $formVal = Validator::make(
                $request->all(),
                [
                    'text' => 'required'
                ]
            );

            if ($formVal->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation Error',
                    'errors' => $formVal->errors()
                ], 401);
            }


            $comment = Comment::create([
                'text' => $request->text,
                'problem_id' => $id,
                'user_id' => auth()->user()->id
            ]);


            return response()->json([
                'comment' => $comment,
                'message' => 'Comment Created Successfully'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
