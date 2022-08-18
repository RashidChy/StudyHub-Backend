<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Problem;
use App\Models\User;
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
        Problem::whereId($id)->first()->delete();

        return response()->json('Deleted');
    }
}
