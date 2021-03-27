<?php

namespace App\Entities;

use App\Entities\Traits\WithACL;
use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    use WithACL;

    protected $table = 'seasons';

    protected $fillable = [
        'name', 'order', 'trailer'
    ];

    protected $appends = ['acl', 'player'];

    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }

    public function serie()
    {
        return $this->belongsTo(Serie::class);
    }

    public function getPlayerAttribute()
    {
        return route('player.season', $this->id);
    }
}
