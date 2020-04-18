<?php

namespace App\Entities;

use App\Entities\Traits\WithACL;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use WithACL;

    protected $table = 'movies';

    protected $fillable = [
        'name', 'cover', 'url'
    ];

    protected $appends = ['acl'];
}
