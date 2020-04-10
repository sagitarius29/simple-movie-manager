<?php

namespace App\Http\Controllers\Series;

use App\Entities\Season;
use App\Entities\Chapter;
use App\Forms\ChapterForm;
use App\Http\Requests\ChapterRequest;
use App\Lib\RestProcessor;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class ChapterController extends Controller
{
    public function index(Season $season)
    {
        $processor = new RestProcessor($season->chapters());

        $processor->setSearchCols(['name']);

        $processor->enableGetAll();

        return $processor->render();
    }

    public function show(Season $season, Chapter $chapter)
    {
        return $chapter;
    }

    public function store(Season $season, ChapterRequest $request)
    {
        $chapter = new Chapter($request->validated());
        $season->chapters()->save($chapter);

        return response()->json($chapter, 201);
    }

    public function update(Season $season, Chapter $chapter, ChapterRequest $request)
    {
        $chapter->fill($request->validated());
        $chapter->save();

        return response()->json($chapter);
    }

    public function destroy(Season $season, Chapter $chapter)
    {
        $chapter->delete();

        return response()->json('ok', Response::HTTP_NO_CONTENT);
    }

    public function formSchema()
    {
        return ChapterForm::storeForm()->render();
    }
}
