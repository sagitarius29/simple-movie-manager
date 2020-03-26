<?php

namespace App\Http\Controllers;

use App\Entities\Category;
use App\Forms\CategoryForm;
use App\Http\Requests\CategoryRequest;
use App\Lib\RestProcessor;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    public function index()
    {
        $processor = new RestProcessor(Category::class);

        $processor->setDefaultSort('order', 'desc');

        $processor->setSearchCols(['name']);

        return $processor->render();
    }

    public function show(Category $category)
    {
        return $category;
    }

    public function store(CategoryRequest $request)
    {
        $category = new Category($request->validated());
        $category->save();

        return response()->json($category, 201);
    }

    public function update(Category $category, CategoryRequest $request)
    {
        $category->fill($request->validated());
        $category->save();

        return response()->json($category);
    }

    public function destroy(Category $category)
    {
        if($category->movies()->count() > 0) {
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
