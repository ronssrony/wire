<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth ;

class Post extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function user():BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function categories():BelongsToMany{
        return $this->belongsToMany(Category::class);
    }

    public function authors():BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
    public function likes():HasMany
    {
        return $this->hasMany(Like::class);
    }

    public function comments():HasMany
    {
        return $this->hasMany(Comment::class);
    }
    public function isLikedByUser():bool{
        return $this->likes()->where('user_id',Auth::id())->where('liked','1')->exists();
    }

    public function views():HasMany{
        return $this->hasMany(View::class);
    }

    protected static function booted()
    {
        static::retrieved(function (Post $post) {
            if (!app()->runningInConsole() && request()->isMethod('GET') && request()->routeIs('show.post')) {
              $alreadyViewed= View::where('user_id',Auth::id())->where('post_id',$post->id)->exists();
               if(!$alreadyViewed && Auth::check()){
                   View::create([
                       'user_id' => Auth::id(),
                       'post_id' =>$post->id
                   ]);
               }
            }
        });
    }

}
