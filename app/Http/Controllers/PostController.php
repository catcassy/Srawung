<?php
namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function create() { return view('posts.create'); }

    public function store(Request $request)
    {
        $request->validate([
            'content'         => 'required|string|max:500',
            'image'           => 'nullable|image|max:4096',
            'mode_post'       => 'required|in:publik,anonim',
            'is_local_thread' => 'nullable|boolean',
            'area_label'      => 'nullable|string|max:100',
            'latitude'        => 'nullable|numeric',
            'longitude'       => 'nullable|numeric',
            'radius_km'       => 'nullable|numeric|min:1|max:50',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts','public');
        }

        Post::create([
            'user_id'         => auth()->id(),
            'content'         => $request->content,
            'image'           => $imagePath,
            'mode_post'       => $request->mode_post,
            'is_local_thread' => $request->boolean('is_local_thread'),
            'area_label'      => $request->area_label,
            'latitude'        => $request->latitude,
            'longitude'       => $request->longitude,
            'radius_km'       => $request->radius_km ?? 5,
        ]);

        return redirect()->route('dashboard')->with('success','Post berhasil dibuat!');
    }

    public function show(Post $post)
    {
        $post->load(['user','comments.user','likes','original.user']);
        return view('posts.show', compact('post'));
    }

    public function destroy(Post $post)
    {
        abort_unless(auth()->id() === $post->user_id, 403);
        if ($post->image) Storage::disk('public')->delete($post->image);
        $post->delete();
        return redirect()->route('dashboard')->with('success','Post dihapus.');
    }

    public function repost(Post $post)
    {
        $exists = Post::where('user_id', auth()->id())
                      ->where('repost_of', $post->id)->exists();
        if ($exists) return back()->with('info','Sudah direpost.');

        Post::create([
            'user_id'   => auth()->id(),
            'content'   => $post->content,
            'image'     => $post->image,
            'mode_post' => auth()->user()->mode,
            'repost_of' => $post->id,
        ]);

        return back()->with('success','Repost berhasil!');
    }
}
