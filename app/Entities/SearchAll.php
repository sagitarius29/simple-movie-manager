<?php

namespace App\Entities;

use App\Entities\Traits\WithACL;
use Illuminate\Database\Eloquent\Model;

class SearchAll extends Model
{
    use WithACL;

    protected $table = 'todoBuscar';

    protected $fillable = [
        'name', 'order'
    ];


}
