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
        return ['cover'];
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

    public function test_assign_movie()
    {
        $this->createParent();
        $movie = factory(Movie::class)->create();

        $data = [
            'name'  => 'Testing',
            'cover' => 'http://cover.com/cover.png',
            'url' => 'http://url.com/movie.mp4',
            'id'    => $movie->id,
        ];

        $this->loginUser();
        $this->withoutExceptionHandling();
        $this->postJson(route($this->baseRoute.'.store', $this->category->id), $data)
            ->assertSuccessful();

        $this->assertDatabaseHas('categories_movies', [
            'category_id' => $this->category->id,
            'movie_id'          => $movie->id,
        ]);

        $this->assertDatabaseHas('movies', [
            'id'    => $movie->id,
            'name'  => 'Testing',
            'cover' => 'http://cover.com/cover.png',
            'url' => 'http://url.com/movie.mp4',
        ]);
    }
}
