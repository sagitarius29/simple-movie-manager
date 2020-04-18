<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesHasSeriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cat_series_has_series', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_serie_id')->unsigned();
            $table->integer('serie_id')->unsigned();
            $table->timestamps();

            $table->foreign('category_serie_id')
                ->references('id')->on('categories_series')
                ->onDelete('cascade');

            $table->foreign('serie_id')
                ->references('id')->on('series')
                ->onDelete('cascade');
        });

        //Delete relation by default
        Schema::table('series', function(Blueprint $table) {
            $table->dropForeign(['category_serie_id']);
            $table->dropColumn('category_serie_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('series', function(Blueprint $table) {
            $table->integer('category_serie_id')->unsigned()->nullable();

            $table->foreign('category_serie_id')
                ->references('id')->on('categories_series')
                ->onDelete('cascade');
        });

        Schema::dropIfExists('cat_series_has_series');
    }
}
