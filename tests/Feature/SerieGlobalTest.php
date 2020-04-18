<?php

namespace Tests\Feature;

use App\Entities\CategorySerie;
use App\Entities\Serie;
use Tests\CrudTestCase;

class SerieGlobalTest extends CrudTestCase
{
    protected $baseRoute = 'series';
    protected $baseModelClass = Serie::class;

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

    public function test_list()
    {
        $this->list_test();
    }

    public function test_show()
    {
        $this->show_test();
    }

    public function test_create()
    {
        $this->create_test();
    }

    public function test_update()
    {
        $this->update_test();
    }

    public function test_delete()
    {
        $this->delete_test();
    }

    public function test_assign_category()
    {
        $categories = factory(CategorySerie::class, 2)->create();

        $data = factory(Serie::class)->make();
        $data['categories'] = $categories->toArray();

        $this->loginUser();
        $this->postJson(route($this->baseRoute.'.store'), $data->toArray())
            ->assertSuccessful();

        $serie = Serie::first();

        $this->assertDatabaseHas('cat_series_has_series', [
            'category_serie_id' => $categories[0]->id,
            'serie_id'          => $serie->id,
        ]);

        $this->assertDatabaseHas('cat_series_has_series', [
            'category_serie_id' => $categories[1]->id,
            'serie_id'          => $serie->id,
        ]);
    }
}
