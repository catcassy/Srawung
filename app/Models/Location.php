<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Location extends Model {
    protected $fillable = ['user_id','nama','alamat','deskripsi','foto','latitude','longitude','kategori'];
    public function user() { return $this->belongsTo(User::class); }

    public function fotoUrl(): string {
        return $this->foto
            ? asset('storage/'.$this->foto)
            : 'https://placehold.co/600x300/eef2ff/6366f1?text='.urlencode($this->nama);
    }

    public function kategoriIcon(): string {
        return match($this->kategori) {
            'kuliner'    => '🍜',
            'wisata'     => '🌄',
            'kesehatan'  => '🏥',
            'pendidikan' => '📚',
            default      => '📍',
        };
    }
}
