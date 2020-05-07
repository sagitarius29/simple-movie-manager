<?php


namespace Tests\Feature;


use App\Entities\Category;
use App\Entities\Movie;
use Illuminate\Database\Eloquent\Collection;
use Tests\CrudTestCase;

class MovieControllerTest extends CrudTestCase
{
    protected $baseRoute = 'movies';
    protected $baseModelClass = Movie::class;
    protected $showResponse = true;

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
        return ['acl', 'player'];
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
        $categories = factory(Category::class, 2)->create();

        $data = factory(Movie::class)->make();
        $data['categories'] = $categories->toArray();

        $this->loginUser();
        $this->postJson(route($this->baseRoute.'.store'), $data->toArray())
            ->assertSuccessful();

        $movie = Movie::first();

        $this->assertDatabaseHas('categories_movies', [
            'category_id' => $categories[0]->id,
            'movie_id'          => $movie->id,
        ]);

        $this->assertDatabaseHas('categories_movies', [
            'category_id' => $categories[1]->id,
            'movie_id'          => $movie->id,
        ]);
    }
}
