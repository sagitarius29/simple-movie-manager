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
        $processor->setAvailableRelations(['categories']);

        $processor->enableGetAll();

        return $processor->render();
    }

    public function show(?Category $category, Movie $movie)
    {
        return $movie;
    }

    protected function storeWithCategory(Category $category, array $input)
    {
        if(isset($input['id'])) {
            $movie = Movie::find($input['id']);

            //Checking if this movie has been attached ever
            if($category->movies()->where('movies.id', $movie->id)->count() > 0) {
                abort(422, 'Este elemento ya pertenece a esta categoría.');
            }

            $movie->fill($input);
            $movie->save();

            $category->movies()->attach($movie);
        } else {
            $movie = new Movie($input);
            $category->movies()->save($movie);
        }
        return $movie;
    }

    protected function storeWithoutCategory(array $input)
    {
        $movie = new Movie($input);
        $movie->save();

        if(isset($input['categories'])) {
            $categories = collect($input['categories'])->pluck('id');
            $movie->categories()->sync($categories);
        }
        return $movie;
    }

    public function store(?Category $category, MovieRequest $request)
    {
        $input = $request->validated();

        if(!$category->exists) {
            $movie = $this->storeWithoutCategory($input);
        } else {
            $movie = $this->storeWithCategory($category, $input);
        }

        return response()->json($movie, 201);
    }

    public function update(?Category $category, Movie $movie, MovieRequest $request)
    {
        $input = $request->validated();
        $movie->fill($input);
        $movie->save();

        if(isset($input['categories'])) {
            $categories = collect($input['categories'])->pluck('id');
            $movie->categories()->sync($categories);
        }

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
