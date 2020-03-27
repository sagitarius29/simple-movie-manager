<?php

namespace Tests\Feature;

use App\Entities\Movie;
use Tests\CrudTestCase;

class MovieControllerTest extends CrudTestCase
{
    protected $baseRoute = 'movies';
    protected $baseModelClass = Movie::class;
    protected $showResponse = true;

    protected function structureJsonExpected(): array
    {
        return ['name', 'cover', 'url'];
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
}
