<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
       public function store(Request $request){

           $request->validate([
               'comment' => 'required|string|min:1', // Ensures comment is not empty and is a string
           ]);

           Comment::create([
               'body' => $request->comment,
               'post_id' => $request->post_id,
               'user_id' => Auth::id(),
           ]);

           return redirect()->back();
       }

}
