<?php

namespace Tests\Feature;

use App\Entities\Category;
use App\Entities\CategorySerie;
use App\Entities\Movie;
use App\Entities\Serie;
use Illuminate\Database\Eloquent\Collection;
use Tests\CrudTestCase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SerieControllerTest extends CrudTestCase
{
    protected $baseRoute = 'categories-series.series';
    protected $baseModelClass = Serie::class;
    protected $showResponse = true;
    protected $hasParentRoute = true;

    protected $category;

    protected function structureJsonExpected(): array
    {
        return ['name', 'cover', 'category_serie_id'];
    }

    protected function validationStoreErrorExpected(): array
    {
        return ['cover'];
    }

    protected function excludeAttrBeforeAssert(): array
    {
        return ['acl'];
    }

    protected function createParent() {
        $this->category = factory(CategorySerie::class)->create();
        $this->setParentId($this->category->id);
    }

    public function test_list()
    {
        $this->createParent();
        $this->list_test();
    }

    public function test_show()
    {
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
