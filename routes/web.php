<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes([
    'register' => false
]);

Route::get('/home', 'HomeController@index')->name('home');

//Upload
Route::post('upload/image', 'UploadController@imageUpload')->name('upload.image');
Route::post('upload/universal-file', 'UploadController@universalUpload')->name('upload.universal-file');
Route::get('file/private/{fileName}', 'UploadController@getPrivateFile')->name('file.private');

//Authenticated
Route::middleware('auth')->group(function() {
    //Categories
    \App\Helper::routes_crud('categories', 'CategoryController', 'categories', '{category}');
    \App\Helper::routes_crud('categories/{category}/movies', 'MovieController', 'categories.movies', '{movie}');

    //Movies
    \App\Helper::routes_crud('movies', 'MovieController', 'movies', '{movie}');

    //Categories Series
    \App\Helper::routes_crud('categories-series', 'Series\CategorySerieController', 'categories-series', '{category}');
    \App\Helper::routes_crud('categories-series/{category}/series', 'Series\SerieController', 'categories-series.series', '{serie}');

    //Seasons
    \App\Helper::routes_crud('series/{serie}/seasons', 'Series\SeasonController', 'series.seasons', '{season}');

    //Chapters
    \App\Helper::routes_crud('seasons/{season}/chapters', 'Series\ChapterController', 'seasons.chapters', '{chapter}');
});
