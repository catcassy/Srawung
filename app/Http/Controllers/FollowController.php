<?php
namespace App\Http\Controllers;
use App\Models\Follow;
use App\Models\User;

class FollowController extends Controller
{
    public function toggle(User $user)
    {
        $me = auth()->user();
        abort_if($me->id === $user->id, 403, 'Tidak bisa follow diri sendiri.');
        $follow = Follow::where('follower_id',$me->id)->where('following_id',$user->id)->first();
        $follow ? $follow->delete() : Follow::create(['follower_id'=>$me->id,'following_id'=>$user->id]);
        return back();
    }
}
