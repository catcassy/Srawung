<?php
namespace App\Http\Controllers;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate(['body' => 'required|string|max:300']);
        Comment::create(['post_id'=>$post->id,'user_id'=>auth()->id(),'body'=>$request->body]);
        return back()->with('success','Komentar ditambahkan.');
    }
    public function destroy(Comment $comment)
    {
        abort_unless(auth()->id() === $comment->user_id, 403);
        $comment->delete();
        return back();
    }
}
