<?php

namespace Tests\Feature;

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
        return [];
    }

    public function test_list()
    {
        $this->list_test();
    }

    public function test_show()
    {
        $this->show_test();
    }
}
