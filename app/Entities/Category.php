<?php

namespace App\Entities;

use App\Entities\Traits\WithACL;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use WithACL;

    protected $table = 'categories';

    protected $fillable = [
        'name', 'order'
    ];

    protected $appends = ['acl'];

    public function movies()
    {
        return $this->belongsToMany(Movie::class, 'categories_movies')
            ->withPivot('order')
            ->orderBy('pivot_order', 'asc');
    }
}
