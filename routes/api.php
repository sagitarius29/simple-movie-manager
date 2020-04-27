<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('categories', 'CategoryController@index');
Route::get('categories/{category}/movies', 'MovieController@index');
Route::get('movies/{movie}', 'MovieController@show');

Route::get('categories-series', 'Series\CategorySerieController@index');
Route::get('categories-series/{category}/series', 'Series\SerieController@index');
Route::get('categories-series/{category}/series/{serie}', 'Series\SerieController@show');
Route::get('series/{serie}/seasons', 'Series\SeasonController@index');
Route::get('series/{serie}/seasons/{season}', 'Series\SeasonController@show');
Route::get('seasons/{season}/chapters', 'Series\ChapterController@index');
Route::get('chapters/{chapter}', 'Series\ChapterController@show');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
