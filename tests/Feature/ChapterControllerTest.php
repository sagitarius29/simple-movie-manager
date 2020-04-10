<?php

namespace Tests\Feature;

use App\Entities\Chapter;
use App\Entities\Season;
use Tests\CrudTestCase;

class ChapterControllerTest extends CrudTestCase
{
    protected $baseRoute = 'seasons.chapters';
    protected $baseModelClass = Chapter::class;
    protected $showResponse = true;
    protected $hasParentRoute = true;

    protected $season;

    protected function structureJsonExpected(): array
    {
        return ['name', 'url', 'order', 'season_id'];
    }

    protected function validationStoreErrorExpected(): array
    {
        return ['name', 'url'];
    }

    protected function excludeAttrBeforeAssert(): array
    {
        return ['acl'];
    }

    protected function createParent() {
        $this->season = factory(Season::class)->create();
        $this->setParentId($this->season->id);
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
