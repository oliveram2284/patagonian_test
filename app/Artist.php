<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{   
    protected $fillable = [
        'spotify_id', 'name',
    ];

    public function songs(){
        return $this->hasMany(Song::class);
    }
}
