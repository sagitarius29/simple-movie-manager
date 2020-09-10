<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;


class ComentariosMovies extends Model
{
    protected $table = 'comentarios_movies';

    protected $fillable = [
        'comentario', 'nombre_persona','fecha','id_movie','id_tipo'
    ];

}
