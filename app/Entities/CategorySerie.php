<?php

namespace App\Entities;

use App\Entities\Traits\WithACL;
use Illuminate\Database\Eloquent\Model;

class CategorySerie extends Model
{
    use WithACL;

    protected $table = 'categories_series';

    protected $fillable = [
        'name', 'order'
    ];

    protected $appends = ['acl'];

    public function series()
    {
        return $this->belongsToMany(Serie::class, 'cat_series_has_series');
    }
}
