<?php

namespace Tests\Feature;

use App\Entities\Category;
use Tests\CrudTestCase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryControllerTest extends CrudTestCase
{
    protected $baseRoute = 'categories';
    protected $baseModelClass = Category::class;
    protected $showResponse = true;

    protected function structureJsonExpected(): array
    {
        return ['name', 'order'];
    }

    protected function validationStoreErrorExpected(): array
    {
        return ['name', 'order'];
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
        $this->withoutExceptionHandling();
        $this->delete_test();
    }
}
