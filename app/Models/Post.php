<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'user_id','content','image','mode_post',
        'is_local_thread','area_label','latitude','longitude','radius_km','repost_of',
    ];

    protected $casts = ['is_local_thread' => 'boolean'];

    public function user()     { return $this->belongsTo(User::class); }
    public function comments() { return $this->hasMany(Comment::class)->latest(); }
    public function likes()    { return $this->hasMany(Like::class); }
    public function original() { return $this->belongsTo(Post::class, 'repost_of'); }
    public function reposts()  { return $this->hasMany(Post::class, 'repost_of'); }

    public function isLikedBy(User $user): bool {
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    public function authorName(): string {
        return $this->mode_post === 'anonim' ? 'Anonim' : $this->user->name;
    }

    // Haversine: apakah post terlihat dari koordinat tertentu
    public function isVisibleAt(?float $lat, ?float $lng): bool {
        if (!$this->is_local_thread) return true;
        if ($lat === null || $lng === null) return false;
        if ($this->latitude === null || $this->longitude === null) return true;

        $R    = 6371;
        $dLat = deg2rad((float)$this->latitude - $lat);
        $dLng = deg2rad((float)$this->longitude - $lng);
        $a    = sin($dLat/2)**2 + cos(deg2rad($lat)) * cos(deg2rad((float)$this->latitude)) * sin($dLng/2)**2;
        $dist = $R * 2 * atan2(sqrt($a), sqrt(1-$a));

        return $dist <= (float)$this->radius_km;
    }
}
