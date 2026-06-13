<?php
namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $tab   = $request->query('tab', 'untukmu');
        $query = Post::with(['user','likes','comments','original.user'])
                     ->where('is_local_thread', false)
                     ->latest();

        if ($tab === 'following') {
            $ids = auth()->user()->following()->pluck('users.id');
            $query->whereIn('user_id', $ids);
        }

        $posts = $query->paginate(20)->withQueryString();
        return view('dashboard.index', compact('posts','tab'));
    }

    public function lokal(Request $request)
    {
        $lat = $request->query('lat');
        $lng = $request->query('lng');

        $localPosts = Post::with(['user','likes','comments'])
                          ->where('is_local_thread', true)
                          ->latest()
                          ->get()
                          ->filter(fn($p) => $p->isVisibleAt($lat ? (float)$lat : null, $lng ? (float)$lng : null))
                          ->values();

        return view('dashboard.lokal', compact('localPosts','lat','lng'));
    }
}
