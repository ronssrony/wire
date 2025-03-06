<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class AdminController extends Controller
{
   public function index(){
       $posts = Post::latest()->get();
       return view('wire.admin-dashboard' , compact('posts'));
   }


}
