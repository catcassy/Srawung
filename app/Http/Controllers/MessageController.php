<?php
namespace App\Http\Controllers;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        $me = auth()->id();
        $conversations = Message::with(['sender','receiver'])
            ->where('sender_id',$me)->orWhere('receiver_id',$me)
            ->latest()->get()
            ->groupBy(fn($m) => $m->sender_id === $me ? $m->receiver_id : $m->sender_id)
            ->map(fn($msgs) => $msgs->first());

        return view('messages.index', compact('conversations'));
    }

    public function searchUser(Request $request)
    {
        $q = trim($request->query('q',''));
        $users = collect();
        if ($q !== '') {
            $users = User::where('id','!=',auth()->id())
                         ->where(fn($query) => $query
                             ->where('name','like',"%{$q}%")
                             ->orWhere('username','like',"%{$q}%"))
                         ->limit(15)->get();
        }
        return view('messages.search', compact('q','users'));
    }

    public function show(User $user)
    {
        $me = auth()->id();
        $messages = Message::where(fn($q) => $q->where('sender_id',$me)->where('receiver_id',$user->id))
                           ->orWhere(fn($q) => $q->where('sender_id',$user->id)->where('receiver_id',$me))
                           ->orderBy('created_at')->get();
        Message::where('sender_id',$user->id)->where('receiver_id',$me)->update(['is_read'=>true]);
        return view('messages.show', compact('user','messages'));
    }

    public function send(Request $request, User $user)
    {
        abort_if(auth()->id() === $user->id, 403);
        $request->validate(['body' => 'required|string|max:500']);
        Message::create(['sender_id'=>auth()->id(),'receiver_id'=>$user->id,'body'=>$request->body]);
        return back();
    }
}
