<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $table = 'images';

    // Relation One to Many / De uno a muchos
    public function comments()
    {
        return $this->hasMany('App\Models\Comment')->orderBy('id', 'desc');
    }

    // Relation One to Many / De uno a muchos
    public function likes()
    {
        return $this->hasMany('App\Models\Like');
    }

    // Relation Many to One / De muchos a uno
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
