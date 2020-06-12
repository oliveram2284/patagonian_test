<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{   public $timestamps = false;
    protected $fillable = [
        'songId', 'songTitle'
    ];

    public function artist(){
        return $this->belongsTo(Artist::class);
    }
}
