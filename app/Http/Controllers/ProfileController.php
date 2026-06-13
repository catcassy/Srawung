<?php
namespace App\Http\Controllers;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show(User $user)
    {
        $posts = Post::where('user_id', $user->id)
                     ->where('mode_post','publik')
                     ->where('is_local_thread', false)
                     ->with(['likes','comments'])
                     ->latest()->paginate(15);

        $isFollowing = auth()->user()->isFollowing($user);
        $isSelf      = auth()->id() === $user->id;

        return view('profile.show', compact('user','posts','isFollowing','isSelf'));
    }

    public function followers(User $user)
    {
        $list = $user->followers()->paginate(20);
        return view('profile.user-list', [
            'user'  => $user,
            'list'  => $list,
            'title' => 'Pengikut',
        ]);
    }

    public function following(User $user)
    {
        $list = $user->following()->paginate(20);
        return view('profile.user-list', [
            'user'  => $user,
            'list'  => $list,
            'title' => 'Mengikuti',
        ]);
    }

    public function edit()
    {
        return view('profile.edit', ['user' => auth()->user()]);
    }

 public function update(Request $request)
{
    $user = auth()->user();

    $request->validate([
        'name' => 'required|string|max:100',
        'username' => 'required|string|max:30|alpha_dash|unique:users,username,' . $user->id,
        'bio' => 'nullable|string|max:200',
        'kota' => 'nullable|string|max:100',
        'header_color' => 'nullable|string|max:20',
        'avatar' => 'nullable|image|max:2048',
    ]);

    $data = [
        'name' => $request->name,
        'username' => $request->username,
        'bio' => $request->bio,
        'kota' => $request->kota,
        'header_color' => $request->header_color,
    ];

    if ($request->hasFile('avatar')) {

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $data['avatar'] = $request->file('avatar')
                                  ->store('avatars', 'public');
    }

    $user->update($data);

    return back()->with('success', 'Profil berhasil diperbarui!');
}

    public function updateMode(Request $request)
    {
        $request->validate(['mode' => 'required|in:publik,anonim']);
        auth()->user()->update(['mode' => $request->mode]);
        return back()->with('success','Mode diperbarui.');
    }
}
