<?php

namespace App\Http\Controllers\Series;

use App\Entities\Season;
use App\Entities\Serie;
use App\Forms\SeasonForm;
use App\Http\Requests\SeasonRequest;
use App\Http\Traits\HasPlayer;
use App\Lib\RestProcessor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class SeasonController extends Controller
{
    use HasPlayer;

    protected $availableRelations = ['serie'];

    public function index(Serie $serie)
    {
        $processor = new RestProcessor($serie->seasons());

        $processor->setSearchCols(['name']);

        $processor->enableGetAll();

        return $processor->render();
    }

    public function show(Serie $serie, Season $season)
    {
        if(request()->has('withRelation') && in_array(request()->get('withRelation'), $this->availableRelations)) {
            $season->load(request()->get('withRelation'));
        }
        return $season;
    }

    public function store(Serie $serie, SeasonRequest $request)
    {
        $season = new Season($request->validated());
        $serie->seasons()->save($season);

        return response()->json($season, 201);
    }

    public function update(Serie $serie, Season $season, SeasonRequest $request)
    {
        $season->fill($request->validated());
        $season->save();

        return response()->json($season);
    }

    public function destroy(Serie $serie, Season $season)
    {
        $season->delete();

        return response()->json('ok', Response::HTTP_NO_CONTENT);
    }

    public function player(Serie $serie, Season $season)
    {
        return $this->toPlayer($season->trailer, $season->serie->cover);
    }

    public function formSchema()
    {
        return SeasonForm::storeForm()->render();
    }
}
