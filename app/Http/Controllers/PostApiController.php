<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Problem;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PostApiController extends Controller
{
    // //View Listing Guest
    public function viewListing()
    {
        $listing = Problem::latest()->get();

        return response()->json($listing);
    }

    // / Delete Posts

    public function destroy($id)
    {
        try {
            $listing = Problem::whereId($id)->first();

            if ($listing->user_id == auth()->user()->id) {

                Problem::whereId($id)->first()->delete();
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function create(Request $request)
    {
        try {
            //Validated
            $formVal = Validator::make(
                $request->all(),
                [
                    'title' => 'required|max:100',
                    'tags' => 'required',
                    'description' => 'required|max:1000'
                ]
            );

            if ($formVal->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation Error',
                    'errors' => $formVal->errors()
                ], 200);
            }
            $pic = 'none';
            if ($request->hasFile('pic')) {
                $pic = $request->file('pic')->store('pictures', 'public');
            }

            /* $user_id= auth()->user()->id; */

            $listing = Problem::create([
                'title' => $request->title,
                'email' => auth()->user()->email,
                'tags' => $request->tags,
                'description' => $request->description,
                'p_file' => $pic,
                'user_id' => auth()->user()->id
            ]);


            return response()->json([
                'listing' => $listing,
                'message' => 'Listing Created Successfully'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    // view user posts
    public function viewPost()
    {
        $user_id = auth()->user()->id;

        $listing = Problem::where('user_id', $user_id)->get();

        return response()->json($listing);
    }

    // update posts

    public function update(Request $request, $id)
    {
        $listing = Problem::whereId($id)->first();

        if ($listing->user_id == auth()->user()->id) {

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


    //viewSinglePost

    public function viewSinglePost($id)
    {
        $check = Problem::find($id);

        if ($check !== null) {
            $problem = Problem::find($id)->with('user')->first();
            return response()->json($problem);
        } else {
            return response()->json(['message' => 'No Problem Found']);
        }
    }
}
