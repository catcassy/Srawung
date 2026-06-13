<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class MeetupRequest extends Model {
    protected $fillable = ['requester_id','target_id','message','place_suggestion','status','latitude','longitude'];
    public function requester() { return $this->belongsTo(User::class, 'requester_id'); }
    public function target()    { return $this->belongsTo(User::class, 'target_id'); }
}
