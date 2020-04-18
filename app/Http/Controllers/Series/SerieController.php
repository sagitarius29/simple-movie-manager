<?php

namespace App\Http\Controllers\Series;

use App\Entities\CategorySerie;
use App\Entities\Serie;
use App\Forms\SerieForm;
use App\Http\Requests\SerieRequest;
use App\Lib\RestProcessor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class SerieController extends Controller
{
    public function index(?CategorySerie $category)
    {
        if($category->exists) {
            $processor = new RestProcessor($category->series());
        } else {
            $processor = new RestProcessor(Serie::class);
        }

        $processor->setSearchCols(['name']);

        $processor->enableGetAll();

        return $processor->render();
    }

    public function show(?CategorySerie $category, Serie $serie)
    {
        return $serie;
    }

    public function storeWithCategory(CategorySerie $category, array $input)
    {
        if(isset($input['id'])) {
            $serie = Serie::find($input['id']);

            //Checking if this serie has been attached ever
            if($category->series()->where('series.id', $serie->id)->count() > 0) {
                abort(422, 'Este elemento ya pertenece a esta categoría. '.$serie->id);
            }

            $serie->fill($input);
            $serie->save();

            $category->series()->attach($serie);
        } else {
            $serie = new Serie($input);
            $category->series()->save($serie);
        }

        return $serie;
    }

    protected function storeWithoutCategory(array $input)
    {
        $serie = new Serie($input);
        $serie->save();

        if(isset($input['categories'])) {
            $categories = collect($input['categories'])->pluck('id');
            $serie->categories()->sync($categories);
        }
        return $serie;
    }

    public function store(?CategorySerie $category, SerieRequest $request)
    {
        $input = $request->validated();

        if($category->exists) {
            $serie = $this->storeWithCategory($category, $input);
        } else {
            $serie = $this->storeWithoutCategory($input);
        }


        return response()->json($serie, 201);
    }

    public function update(CategorySerie $category, Serie $serie, SerieRequest $request)
    {
        $serie->fill($request->validated());
        $serie->save();

        return response()->json($serie);
    }

    public function destroy(CategorySerie $category, Serie $serie)
    {
        $serie->categories()->detach($category->id);

        if($serie->categories()->count() == 0) {
            $serie->delete();
        }

        return response()->json('ok', Response::HTTP_NO_CONTENT);
    }

    public function formSchema()
    {
        return SerieForm::storeForm()->render();
    }
}
