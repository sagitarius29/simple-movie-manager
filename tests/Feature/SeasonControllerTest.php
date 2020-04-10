<?php

namespace Tests\Feature;

use App\Entities\CategorySerie;
use App\Entities\Season;
use App\Entities\Serie;
use Tests\CrudTestCase;

class SeasonControllerTest extends CrudTestCase
{
    protected $baseRoute = 'series.seasons';
    protected $baseModelClass = Season::class;
    protected $showResponse = true;
    protected $hasParentRoute = true;

    protected $serie;

    protected function structureJsonExpected(): array
    {
        return ['name', 'order', 'serie_id'];
    }

    protected function validationStoreErrorExpected(): array
    {
        return ['name'];
    }

    protected function excludeAttrBeforeAssert(): array
    {
        return ['acl'];
    }

    protected function createParent() {
        $this->serie = factory(Serie::class)->create();
        $this->setParentId($this->serie->id);
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
