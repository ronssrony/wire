<?php

namespace App\Http\Middleware;

use App\Models\Post;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAndPostUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $postUserId = Post::find($request->route('id'))->user_id === $request->user()->id;
        if(!$postUserId && $request->user()->role !== 'admin'){
            abort(403);
        }
        return $next($request);
    }
}
