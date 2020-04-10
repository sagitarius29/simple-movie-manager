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
    public function index(CategorySerie $category)
    {
        $processor = new RestProcessor($category->series());

        $processor->setSearchCols(['name']);

        $processor->enableGetAll();

        return $processor->render();
    }

    public function show(CategorySerie $category, Serie $serie)
    {
        return $serie;
    }

    public function store(CategorySerie $category, SerieRequest $request)
    {
        $serie = new Serie($request->validated());
        $category->series()->save($serie);

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
        $serie->delete();

        return response()->json('ok', Response::HTTP_NO_CONTENT);
    }

    public function formSchema()
    {
        return SerieForm::storeForm()->render();
    }
}
