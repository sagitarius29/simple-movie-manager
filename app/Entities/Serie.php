<?php

namespace App\Entities;

use App\Entities\Traits\WithACL;
use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{
    use WithACL;

    protected $table = 'series';

    protected $fillable = [
        'name', 'cover', 'order'
    ];

    protected $appends = ['acl'];

    public function seasons()
    {
        return $this->hasMany(Season::class);
    }

    public function categories()
    {
        return $this->belongsToMany(CategorySerie::class, 'cat_series_has_series');
    }
}
