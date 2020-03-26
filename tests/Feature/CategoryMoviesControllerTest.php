<?php

namespace Tests\Feature;

use App\Entities\Category;
use App\Entities\Movie;
use Illuminate\Database\Eloquent\Collection;
use Tests\CrudTestCase;

class CategoryMoviesControllerTest extends CrudTestCase
{
    protected $baseRoute = 'categories.movies';
    protected $baseModelClass = Movie::class;
    protected $showResponse = true;
    protected $hasParentRoute = true;

    protected $category;

    protected function structureJsonExpected(): array
    {
        return ['name', 'cover', 'url'];
    }

    protected function validationStoreErrorExpected(): array
    {
        return ['name', 'cover'];
    }

    protected function excludeAttrBeforeAssert(): array
    {
        return ['acl'];
    }

    protected function afterFactoryCreate(Collection $items)
    {
        $this->category->movies()->sync($items);
    }

    protected function createParent() {
        $this->category = factory(Category::class)->create();
        $this->setParentId($this->category->id);
    }

    public function test_list()
    {
        $this->createParent();
        $this->list_test();
    }

    public function test_show()
    {
        $this->withoutExceptionHandling();
        $this->createParent();
        $this->show_test();
    }

    public function test_create()
    {
        $this->createParent();
        $this->create_test();
    }

    public function test_update()
    {
        $this->createParent();
        $this->update_test();
    }

    public function test_delete()
    {
        $this->createParent();
        $this->delete_test();
    }
}
