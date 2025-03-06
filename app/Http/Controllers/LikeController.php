<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function store(Request $request , $id){
       $existingLike = Like::where('post_id',$id)->where('user_id',Auth::id())->first();
       $isLike = Like::where('post_id',$id)->where('user_id',Auth::id())->exists();
       if(  $isLike ) {
           Like::where('post_id',$id)->where('user_id',Auth::id())->update(['liked'=> !$existingLike->liked]);
       }
       else {
           Like::create([
               'post_id' => $id,
               'user_id' => Auth::id(),
               'liked' => true ,
           ]);
       }
        return redirect()->back();
    }

}
