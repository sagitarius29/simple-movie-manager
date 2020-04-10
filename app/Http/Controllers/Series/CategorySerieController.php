<?php

namespace App\Http\Controllers\Series;

use App\Entities\Category;
use App\Entities\CategorySerie;
use App\Forms\CategoryForm;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\CategorySerieRequest;
use App\Lib\RestProcessor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class CategorySerieController extends Controller
{
    public function index()
    {
        $processor = new RestProcessor(CategorySerie::class);

        $processor->setDefaultSort('order', 'desc');

        $processor->setAvailableSortables(['order', 'name']);

        $processor->setSearchCols(['name']);

        $processor->enableGetAll();

        return $processor->render();
    }

    public function show(CategorySerie $category)
    {
        return $category;
    }

    public function store(CategorySerieRequest $request)
    {
        $category = new CategorySerie($request->validated());
        $category->save();

        return response()->json($category, 201);
    }

    public function update(CategorySerie $category, CategorySerieRequest $request)
    {
        $category->fill($request->validated());
        $category->save();

        return response()->json($category);
    }

    public function destroy(CategorySerie $category)
    {
        if($category->series()->count() > 0) {
            abort(422, 'No puede eliminar esta categoría porque tiene películas asignadas.');
        }

        $category->delete();

        return response()->json('ok', Response::HTTP_NO_CONTENT);
    }

    public function formSchema()
    {
        return CategoryForm::storeForm()->render();
    }
}
