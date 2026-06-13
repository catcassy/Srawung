<?php
namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $q = trim($request->query('q', ''));

        $users = collect();
        $posts = collect();

        if ($q !== '') {
            $users = User::where('name', 'like', "%{$q}%")
                         ->orWhere('username', 'like', "%{$q}%")
                         ->where('id', '!=', auth()->id())
                         ->limit(10)
                         ->get();

           $posts = Post::with(['user','likes','comments'])
    ->where(function ($query) use ($q) {

        $query->where('content', 'like', "%{$q}%")

              ->orWhereHas('user', function ($user) use ($q) {
                    $user->where('name', 'like', "%{$q}%")
                         ->orWhere('username', 'like', "%{$q}%");
              })

              ->orWhere('area_label', 'like', "%{$q}%");

    })
    ->latest()
    ->limit(20)
    ->get();
        }

        return view('search.index', compact('q','users','posts'));
    }
}
