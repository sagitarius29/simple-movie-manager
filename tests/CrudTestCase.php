<?php

namespace Tests;

use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;

abstract class CrudTestCase extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $baseModelClass;
    protected $baseRoute;
    protected $showResponse = false;
    protected $attributesData;
    protected $modelPrimaryKey = 'id';
    protected $hasParentRoute = false;
    protected $parentId;
    protected $routeParams = [];
    protected $userLogged;

    protected function loginUser() {
        if($this->userLogged != null) {
            $this->actingAs($this->userLogged);
            return $this;
        }
        $this->userLogged = factory(User::class)->create();

        $this->actingAs($this->userLogged);

        return $this;
    }

    abstract protected function structureJsonExpected(): array;

    abstract protected function validationStoreErrorExpected(): array;

    protected function afterFactoryCreate(Collection $items) {
    }

    protected function setParentId($parentId)
    {
        $this->parentId = $parentId;
    }

    protected function attributes(): array
    {
        return factory($this->baseModelClass)->make()->toArray();
    }

    protected function validationUpdateErrorExpected(): array
    {
        return $this->validationStoreErrorExpected();
    }

    protected function excludeAttrBeforeAssert(): array
    {
        return [];
    }

    protected function attributesData() {
        if($this->attributesData != null) {
            return $this->attributesData;
        }

        $this->attributesData = $this->attributes();

        return $this->attributesData;
    }

    public function protected_routes_test($available)
    {
        $model = factory($this->baseModelClass)->create();
        $this->protectedCrudRoutes($this->loginUser(), $available, $model);
    }

    public function list_test($attributes = [])
    {
        $items = factory($this->baseModelClass, 3)->create($attributes);

        $this->afterFactoryCreate($items);

        $this->whenItGetList($this->loginUser(), 3, [
            'data' => [
                '*' => $this->structureJsonExpected()
            ]
        ]);
    }

    public function create_test(array $attributes = [])
    {
        $attributes = count($attributes) ? $attributes : $this->attributesData();

        return $this->whenItCreate(
            $this->loginUser(),
            $attributes,
            $this->validationStoreErrorExpected(),
            $this->excludeAttrBeforeAssert()
        );
    }

    public function update_test()
    {
        return $this->whenItUpdate(
            $this->loginUser(),
            $this->attributesData(),
            $this->validationUpdateErrorExpected(),
            $this->excludeAttrBeforeAssert()
        );
    }

    public function show_test()
    {
        return $this->whenItShow($this->loginUser());
    }

    public function delete_test()
    {
        return $this->whenItDelete($this->loginUser(), $this->excludeAttrBeforeAssert());
    }

    protected function protectedCrudRoutes(
        $authenticated,
        array $available,
        Model $model = null
    ) {
        $model = $model ?? factory($this->baseModelClass)->create();
        $all = in_array('*', $available);

        if ($all || in_array('read', $available)) {
            $authenticated->getJson($this->generateRoute($this->baseRoute))->assertStatus(Response::HTTP_FORBIDDEN);
            $authenticated->getJson($this->generateRoute($this->baseRoute.'.show', $model->{$this->modelPrimaryKey}))->assertStatus(Response::HTTP_FORBIDDEN);
        }

        if ($all || in_array('create', $available)) {
            $authenticated->postJson($this->generateRoute($this->baseRoute.'.store'))->assertStatus(Response::HTTP_FORBIDDEN);
        }

        if ($all || in_array('update', $available)) {
            $authenticated->patchJson($this->generateRoute($this->baseRoute.'.update', $model->{$this->modelPrimaryKey}))->assertStatus(Response::HTTP_FORBIDDEN);
        }

        if ($all || in_array('delete', $available)) {
            $authenticated->deleteJson($this->generateRoute($this->baseRoute.'.delete', $model->{$this->modelPrimaryKey}))->assertStatus(Response::HTTP_FORBIDDEN);
        }
    }

    protected function whenItGetList($authenticated, int $expectedTotal, array $expectedStructure)
    {
        $response = $authenticated->getJson($this->generateRoute($this->baseRoute));

        if ($this->showResponse) {
            print_r('In assert 200: '.$response->getContent()."\n");
        }

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'total' => $expectedTotal,
            ])
            ->assertJsonStructure($expectedStructure);
    }

    protected function whenItCreate(
        TestCase $authenticated,
        $attributes = [],
        $validationErrorsExpected = [],
        $excludeAttrsBeforeAssert = [],
        $modelClass = null,
        $route = null
    )
    {
        $route = $route ?? $this->baseRoute.'.store';
        $modelClass = $modelClass ?? $this->baseModelClass;

        if(count($validationErrorsExpected) > 0) {
            $res = $authenticated->postJson($this->generateRoute($route));
            if ($this->showResponse) {
                print_r('In assert 422: '.$res->getContent()."\n");
            }
            $res->assertJsonValidationErrors($validationErrorsExpected);
        }

        $response = $authenticated->postJson($this->generateRoute($route), $attributes);
        if ($this->showResponse) {
            print_r('In assert 201: '.$response->getContent()."\n");
        }
        $response->assertStatus(Response::HTTP_CREATED);

        $attributes = $this->excludeAttributes($attributes, $excludeAttrsBeforeAssert);

        $this->assertDatabaseHas((new $modelClass)->getTable(), $attributes);

        return $response;
    }

    public function whenItUpdate(
        TestCase $authenticated,
        $attributes = [],
        $expectedValidationErrors = [],
        $excludeAttrsBeforeAssert = [],
        Model $model = null,
        $route = null
    ) {
        $route = $route ?? $this->baseRoute.'.update';
        $model = $model ?? factory($this->baseModelClass)->create();

        if(count($expectedValidationErrors) > 0) {
            $res = $authenticated->patchJson($this->generateRoute($route, $model->{$this->modelPrimaryKey}));
            if ($this->showResponse) {
                print_r($res->getContent());
            }
            $res->assertJsonValidationErrors($expectedValidationErrors);
        }

        $response = $authenticated->patchJson($this->generateRoute($route, $model->{$this->modelPrimaryKey}), $attributes);
        if ($this->showResponse) {
            print_r('In assert 200: '.$response->getContent()."\n");
        }
        $response->assertStatus(Response::HTTP_OK);

        $attributes = $this->excludeAttributes($attributes, $excludeAttrsBeforeAssert);

        $this->assertDatabaseHas($model->getTable(), $attributes);

        return $response;
    }

    public function whenItShow(TestCase $authenticated, Model $model = null, $route = null)
    {
        $route = $route ?? $this->baseRoute.'.show';
        $model = $model ?? factory($this->baseModelClass)->create();

        $this->afterFactoryCreate(new \Illuminate\Database\Eloquent\Collection([$model]));

        $response = $authenticated->getJson($this->generateRoute($route, $model->{$this->modelPrimaryKey}))
            ->assertStatus(Response::HTTP_OK)
            ->assertJson($model->toArray());

        return $response;
    }

    protected function whenItDelete(TestCase $authenticated, $excludeAttrsBeforeAssert = [], Model $model = null, $route = null)
    {
        $route = $route ?? $this->baseRoute.'.delete';
        $model = $model ?? factory($this->baseModelClass)->create();

        $this->afterFactoryCreate(new Collection([$model]));

        $response = $authenticated->deleteJson($this->generateRoute($route, $model->{$this->modelPrimaryKey}))
            ->assertStatus(Response::HTTP_NO_CONTENT);

        $attributes = $this->excludeAttributes($this->attributesData(), $excludeAttrsBeforeAssert);

        $this->assertDatabaseMissing($model->getTable(), $attributes);

        return $response;
    }

    private function excludeAttributes(array $attributes, array $excludes) {

        foreach ($excludes as $exclude) {
            unset($attributes[$exclude]);
        }
        return $attributes;
    }

    protected function generateRoute($name, $content = null)
    {
        $data = $this->routeParams;

        if($this->parentId != null) {
            $data[] = $this->parentId;
        }

        if($content != null) {
            $data[] = $content;
        }

        if(count($data) == 0) {
            return route($name);
        }

        return route($name, $data);
    }
}
