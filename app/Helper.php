<?php

namespace App;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use ReflectionClass;

class Helper
{
    public static function routes_crud(string $uri, string $controller, string $name, string $item = '{id}', string $regex = '[0-9]+', array $only = [])
    {
        if (count($only) > 0) {
            if (in_array('show', $only)) {
                \Route::get($uri, $controller . '@index')->name($name);
                \Route::get($uri . '/' . $item, $controller . '@show')->name($name . '.show')->where(substr($item, 1, -1), $regex);
            }
            if (in_array('store', $only)) {
                \Route::post($uri, $controller . '@store')->name($name . '.store');
            }
            if (in_array('update', $only)) {
                \Route::patch($uri . '/' . $item, $controller . '@update')->name($name . '.update')->where(substr($item, 1, -1), $regex);
            }
            if (in_array('delete', $only)) {
                \Route::delete($uri . '/' . $item, $controller . '@destroy')->name($name . '.delete')->where(substr($item, 1, -1), $regex);
            }
        } else {
            \Route::get($uri, $controller . '@index')->name($name);
            \Route::post($uri, $controller . '@store')->name($name . '.store');
            \Route::get($uri . '/form-schema', $controller . '@formSchema')->name($name . '.formSchema');
            \Route::get($uri . '/' . $item, $controller . '@show')->name($name . '.show')->where(substr($item, 1, -1), $regex);
            \Route::patch($uri . '/' . $item, $controller . '@update')->name($name . '.update')->where(substr($item, 1, -1), $regex);
            \Route::delete($uri . '/' . $item, $controller . '@destroy')->name($name . '.delete')->where(substr($item, 1, -1), $regex);
        }
    }

    public static function array_push($array, $pushingArray)
    {
        foreach ($pushingArray as $key => $value) {
            if (!is_numeric($key)) {
                $array[$key] = $value;
            } else {
                $array[] = $value;
            }
        }
        return $array;
    }

    /**
     *
     * @param string $model
     * @return mixed
     */
    public static function random_or_create(string $model)
    {
        $element = $model::inRandomOrder()->first();
        if ($element == null) {
            return factory($model)->create();
        }
        return $element;
    }

    public static function getPermissionsFromModel($model, &$permissions = [])
    {
        $reflection = new ReflectionClass($model);
        $constants = $reflection->getConstants();

        foreach ($constants as $constant => $value) {
            if(strpos($constant, 'P_') !== false) {
                $permissions[] = $value;
            }
        }
        return $permissions;
    }

    public static function getPermissionFormModels(array $models)
    {
        $permissions = [];
        foreach ($models as $model) {
            self::getPermissionsFromModel($model, $permissions);
        }
        return $permissions;
    }

    public static function relationCreateOrUpdate(Model $model, $relation, array $data)
    {
        if(! $model->{$relation}()->exists()) {
            $model->{$relation}()->create($data);
        } else {
            $relation = $model->{$relation};
            $relation->fill($data);
            $relation->save();
        }
    }
}
