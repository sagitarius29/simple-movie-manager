<?php

namespace App\Entities;

use App\Entities\Traits\WithACL;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use WithACL;

    protected $table = 'chapters';

    protected $fillable = [
        'name', 'url', 'order'
    ];

    protected $appends = ['acl'];
}
