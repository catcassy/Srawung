<?php
namespace App\Http\Controllers;
use App\Models\Like;
use App\Models\Post;

class LikeController extends Controller
{
    public function toggle(Post $post)
    {
        $like = Like::where('post_id',$post->id)->where('user_id',auth()->id())->first();
        $like ? $like->delete() : Like::create(['post_id'=>$post->id,'user_id'=>auth()->id()]);
        return back();
    }
}
