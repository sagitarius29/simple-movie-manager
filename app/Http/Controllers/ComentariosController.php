<?php

namespace App\Http\Controllers;

use App\Entities\ComentariosMovies;
use App\Lib\RestProcessor;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DB;

class ComentariosController extends Controller
{
 
    /*public function index()
    {
        $processor = new RestProcessor(ComentariosMovies::class);
        $processor->enableGetAll();
        return $processor->render();
    }*/
   
   
    public function store(Request $request)
    {
        $comentario=ComentariosMovies::create($request->all());
        return response()->json(array('status' => true), 200, ['Content-type'=> 'application/json; charset=utf-8'],
            JSON_UNESCAPED_UNICODE);
    }
    
    public function getComentario($id_movie,$id_tipo){
  
     $result = DB::select("SELECT comentario,nombre_persona,fecha FROM comentarios_movies WHERE id_movie='$id_movie' and id_tipo='$id_tipo' order by fecha DESC");
        
            return response()->json(($result), 200, ['Content-type'=> 'application/json; charset=utf-8'],
            JSON_UNESCAPED_UNICODE);
        
    }
}
