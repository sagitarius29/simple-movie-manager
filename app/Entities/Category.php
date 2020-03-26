<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'name', 'order'
    ];

    protected $appends = ['acl'];

    public function getAclAttribute()
    {
        return [
            'update' => true,
            'delete' => true
        ];
    }

    public function movies()
    {
        return $this->belongsToMany(Movie::class, 'categories_movies')
            ->withPivot('order')
            ->orderBy('pivot_order', 'asc');
    }
}
