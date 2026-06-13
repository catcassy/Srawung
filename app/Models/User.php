<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
    'name',
    'username',
    'email',
    'password',
    'google_id',
    'avatar',
    'avatar_url',
    'bio',
    'kota',
    'header_color',
    'mode',
    'latitude',
    'longitude',
    'last_active_at',
];

    protected $hidden = ['password','remember_token'];

    protected $casts = [
        'password'       => 'hashed',
        'last_active_at' => 'datetime',
    ];

    // ── Relasi ──────────────────────────────────────────
    public function posts()            { return $this->hasMany(Post::class); }
    public function comments()         { return $this->hasMany(Comment::class); }
    public function likes()            { return $this->hasMany(Like::class); }
    public function locations()        { return $this->hasMany(Location::class); }
    public function sentMessages()     { return $this->hasMany(Message::class, 'sender_id'); }
    public function receivedMessages() { return $this->hasMany(Message::class, 'receiver_id'); }

    public function followers() {
        return $this->belongsToMany(User::class, 'follows', 'following_id', 'follower_id');
    }
    public function following() {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'following_id');
    }

    public function checkins() { return $this->hasMany(UserCheckin::class); }
    public function sentMeetups()     { return $this->hasMany(MeetupRequest::class, 'requester_id'); }
    public function receivedMeetups() { return $this->hasMany(MeetupRequest::class, 'target_id'); }

    // ── Helpers ──────────────────────────────────────────
    public function isFollowing(User $user): bool {
        return $this->following()->where('following_id', $user->id)->exists();
    }

    public function isAnonim(): bool { return $this->mode === 'anonim'; }

    public function publicPostsCount(): int {
        return $this->posts()->where('mode_post', 'publik')->count();
    }

    public function avatarSrc(): string {
        if ($this->avatar) return asset('storage/'.$this->avatar);
        if ($this->avatar_url) return $this->avatar_url;
        $initials = urlencode(mb_strtoupper(mb_substr($this->name, 0, 2)));
        return "https://ui-avatars.com/api/?name={$initials}&background=6366f1&color=fff&size=80&bold=true";
    }

    public function unreadMessages(): int {
        return $this->receivedMessages()->where('is_read', false)->count();
    }

    public function pendingMeetups(): int {
        return $this->receivedMeetups()->where('status', 'pending')->count();
    }

    public function activeCheckin(): ?UserCheckin {
        return $this->checkins()
                    ->where('is_active', true)
                    ->where('expires_at', '>', now())
                    ->latest()
                    ->first();
    }


     public function getRouteKeyName()
    {
        return 'username';
    }
}
