<?php

namespace App\Http\Controllers;

use App\Entities\Category;
use App\Entities\Movie;
use App\Forms\CategoryForm;
use App\Forms\MovieForm;
use App\Http\Requests\MovieRequest;
use App\Lib\RestProcessor;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MovieController extends Controller
{
    public function index(?Category $category)
    {
        if(!$category->exists) {
            $processor = new RestProcessor(Movie::class);
        } else {
            $processor = new RestProcessor($category->movies());
        }

        $processor->setSearchCols(['name']);

        $processor->enableGetAll();

        return $processor->render();
    }

    public function show(?Category $category, Movie $movie)
    {
        return $movie;
    }

    public function store(?Category $category, MovieRequest $request)
    {
        $input = $request->validated();

        if(!$category->exists) {
            $movie = new Movie($input);
            $movie->save();
        } else {
            if(isset($input['id'])) {
                $movie = Movie::find($input['id']);
                $movie->fill($input);
                $movie->save();

                //Checking if this serie has been attached ever
                if($category->movies()->exists($movie->id)) {
                    abort(422, 'Este elemento ya pertenece a esta categoría.');
                }
                $category->movies()->attach($movie->id);
            } else {
                $movie = new Movie($input);
                $category->movies()->save($movie);
            }
        }

        return response()->json($movie, 201);
    }

    public function update(?Category $category, Movie $movie, MovieRequest $request)
    {
        $movie->fill($request->validated());
        $movie->save();

        return response()->json($movie);
    }

    public function destroy(?Category $category, Movie $movie)
    {
        if($category->exists) {
            $movie->categories()->detach($category->id);

            if($movie->categories()->count() == 0) {
                $movie->delete();
            }
        } else {
            $movie->delete();
        }

        return response()->json('ok', Response::HTTP_NO_CONTENT);
    }

    public function formSchema()
    {
        return MovieForm::storeForm()->render();
    }
}
