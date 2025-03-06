<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth ;
use App\Models\Category ;
use App\Models\User ;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with(['user','categories','authors','views','comments'=>function ($db){
            $db->with('user')->latest();
        }])->withCount(['likes'=>function($db){
            $db->where('liked','1') ;
        }])-> latest()->get();

            $currentCategory='0';
            $posts->each(function ($post) {
            $post->liked = $post->isLikedByUser();

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
    public function create ()
    {
        $categories = Category::all();
        $authors = User::where('role' , 'author')->whereNotIn('id',[Auth::id()])->get();

        return view('wire.create-post', compact('categories' ,'authors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',


        ]);

        $imagePath = '/images/demo.jpg';
        $content = $request->input('content');
        $filePath = 'posts/content/' . uniqid() . '.txt';
        Storage::disk('public')->put($filePath, $content);


        if($request->hasFile('image')){
            $imagePath = $request->file('image')->store('images', 'public');
        }

        else if(preg_match('/data:image\/([a-zA-Z]+);base64,([^"\']+)/i', $content, $match)) {
            $imageType = $match[1]; // Extracts the image type (png, jpg, etc.)
            $imageData = base64_decode($match[2]); // Decodes the Base64 data
            $imageName = uniqid() . '.' . $imageType; // Generates a unique filename
            $imageFilePath = 'posts/images/' . $imageName; // Path inside storage
            Storage::disk('public')->put($imageFilePath, $imageData);
            $imagePath = $imageFilePath;
        }

        $post =  Post::create([
            'title' => $request->input('title'),
            'content' => $filePath,
            'image' => $imagePath,
            'user_id' => Auth::id(),
        ]);
        $categories = !empty($request->categories) ? explode(',', $request->categories) : [];
        $authors = !empty($request->authors) ? explode(',', $request->authors) : [];
        $post->categories()->sync($categories) ;
        $post->authors()->sync($authors);
        return redirect()->route('dashboard')->with('success', 'Post created successfully!');
    }

    /**
     * Display the specified resource.
     */

    public function show(Post $post , $id)
    {

            $post = $this->getPost($id);

            return view('wire.show-post', compact('post'));
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post , $id)
    {
        $post = $this->getPost($id);
        $post->categorieIds = $post->categories->pluck('id')->toArray();
        $post->authorIds  = $post->authors->pluck('id')->toArray();
        $categories = Category::all();
        $authors = User::where('role' , 'author')->whereNotIn('id',[Auth::id()])->get();
        return view('wire.edit-post', compact('post','categories','authors'));
    }

    /**
     * Update the specified resource in storage.
     */

        public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        // Update text content
        $content = $request->input('content');
        if ($post->content) {
            Storage::disk('public')->delete($post->content); // Delete old content file
        }
        $filePath = 'posts/content/' . uniqid() . '.txt';
        Storage::disk('public')->put($filePath, $content);

        $imagePath = $post->image;
        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($post->image);
            $imagePath = $request->file('image')->store('images', 'public');
        } elseif (preg_match('/data:image\/([a-zA-Z]+);base64,([^"\']+)/i', $content, $match)) {
            $imageType = $match[1];
            $imageData = base64_decode($match[2]);
            $imageName = uniqid() . '.' . $imageType;
            $imageFilePath = 'posts/images/' . $imageName;
            Storage::disk('public')->put($imageFilePath, $imageData);
            $imagePath = $imageFilePath;
        }

        // Update the post record
        $post->update([
            'title' => $request->input('title'),
            'content' => $filePath,
            'image' => $imagePath,
        ]);

        $categories = !empty($request->categories) ? explode(',', $request->categories) : [];
        $authors = !empty($request->authors) ? explode(',', $request->authors) : [];
        $post->categories()->sync($categories);
        $post->authors()->sync($authors);

        return redirect()->route('dashboard')->with('success', 'Post updated successfully!');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $posti , $id)
    {
        Post::destroy($id);
        return redirect()->back() ;
    }

    public function getPost($id){
        $post = Post::with(['user','categories','views','authors','comments'=>function ($db){$db->with('user')->latest();}])->withCount(['likes'=>function($db){
            $db->where('liked','1');}])->where('id' , $id)->first();
        $post->liked = $post->isLikedByUser();
        $post->content_text = Storage::disk('public')->exists($post->content)
            ? Storage::disk('public')->get($post->content)
            : 'No content available';
        return $post;
}

}
