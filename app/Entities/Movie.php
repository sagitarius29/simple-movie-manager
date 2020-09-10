<?php

namespace App\Entities;

use App\Entities\Traits\WithACL;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use WithACL;

    protected $table = 'movies';

    protected $fillable = [
        'name', 'cover', 'url','sipnosis'
    ];

    protected $appends = ['acl', 'player'];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'categories_movies');
    }

    public function getPlayerAttribute()
    {
        return route('player.movie', $this->id);
    }
}
