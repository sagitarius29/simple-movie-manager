<?php

namespace Tests\Feature;

use App\Entities\CategorySerie;
use App\Entities\Serie;
use Illuminate\Database\Eloquent\Collection;
use Tests\CrudTestCase;

class SerieControllerTest extends CrudTestCase
{
    protected $baseRoute = 'categories-series.series';
    protected $baseModelClass = Serie::class;
    protected $showResponse = true;
    protected $hasParentRoute = true;

    protected $category;

    public function test_list()
    {
        $this->createParent();
        $this->list_test();
    }

    protected function createParent()
    {
        $this->category = factory(CategorySerie::class)->create();
        $this->setParentId($this->category->id);
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

    public function test_assign_serie()
    {
        $this->createParent();
        $serie = factory(Serie::class)->create();

        $data = [
            'name'  => 'Testing',
            'cover' => 'http://cover.com/cover.png',
            'id'    => $serie->id,
        ];

        $this->loginUser();
        $this->postJson(route($this->baseRoute.'.store', $this->category->id), $data)
            ->assertSuccessful();

        $this->assertDatabaseHas('cat_series_has_series', [
            'category_serie_id' => $this->category->id,
            'serie_id'          => $serie->id,
        ]);

        $this->assertDatabaseHas('series', [
            'id'    => $serie->id,
            'name'  => 'Testing',
            'cover' => 'http://cover.com/cover.png',
        ]);
    }

    public function test_update()
    {
        $this->createParent();
        $this->update_test();
    }

    public function test_delete()
    {
        $this->createParent();
        $this->withoutExceptionHandling();
        $this->delete_test();
    }

    protected function structureJsonExpected(): array
    {
        return ['name', 'cover'];
    }

    protected function validationStoreErrorExpected(): array
    {
        return ['cover'];
    }

    protected function excludeAttrBeforeAssert(): array
    {
        return ['acl'];
    }

    protected function afterFactoryCreate(Collection $items)
    {
        $this->category->series()->sync($items);
    }
}
