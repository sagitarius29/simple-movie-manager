<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $table = 'movies';

    protected $fillable = [
        'name', 'cover', 'url'
    ];

    protected $appends = ['acl'];

    public function getAclAttribute()
    {
        return [
            'update' => true,
            'delete' => true
        ];
    }
}
