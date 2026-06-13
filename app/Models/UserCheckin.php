<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class UserCheckin extends Model {
    protected $fillable = ['user_id','latitude','longitude','area_label','is_active','expires_at'];
    protected $casts    = ['expires_at' => 'datetime', 'is_active' => 'boolean'];
    public function user() { return $this->belongsTo(User::class); }

    // Hitung jarak ke koordinat lain (km)
    public function distanceTo(float $lat, float $lng): float {
        $R    = 6371;
        $dLat = deg2rad((float)$this->latitude - $lat);
        $dLng = deg2rad((float)$this->longitude - $lng);
        $a    = sin($dLat/2)**2 + cos(deg2rad($lat)) * cos(deg2rad((float)$this->latitude)) * sin($dLng/2)**2;
        return $R * 2 * atan2(sqrt($a), sqrt(1-$a));
    }
}
