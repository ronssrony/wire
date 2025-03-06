<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    public function postsByCategory($id)
    {
        $category = Category::with([
            'posts.user',
            'posts.categories',
            'posts.authors',
            'posts.views',
            'posts.comments.user'
        ])->find($id);
        $posts = $category->posts;
        $currentCategory = Category::find($id)->id ;
        $posts->each(function ($post) {
            $post->liked = $post->isLikedByUser();
            $post->likes_count = $post->likes->where('liked', '1')->count();
            $post->content_text = Storage::disk('public')->exists($post->content)
                ? Storage::disk('public')->get($post->content)
                : 'No content available';
            $post->description = preg_replace('/<img[^>]+\>/i', '', $post->content_text);
            $post->description = strip_tags($post->description);
        });
        $categories = Category::select('id','name')->get();
        return view('dashboard', compact('posts','categories','currentCategory'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
    }
}
