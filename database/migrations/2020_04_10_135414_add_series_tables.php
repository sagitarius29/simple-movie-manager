<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSeriesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories_series', function(Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('name', 200)->nullable();
            $table->integer('order')->nullable();

            $table->timestamps();

        });

        Schema::create('series', function(Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('category_serie_id')->unsigned();
            $table->string('name', 200)->nullable();
            $table->string('cover', 200)->nullable();

            $table->foreign('category_serie_id')
                ->references('id')->on('categories_series')
                ->onDelete('cascade');

            $table->timestamps();

        });

        Schema::create('seasons', function(Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('serie_id')->unsigned();
            $table->string('name', 200)->nullable();
            $table->integer('order')->nullable();

            $table->foreign('serie_id')
                ->references('id')->on('series')
                ->onDelete('cascade');

            $table->timestamps();

        });

        Schema::create('chapters', function(Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('season_id')->unsigned();
            $table->string('name', 200)->nullable();
            $table->string('url', 200)->nullable();
            $table->integer('order')->nullable();

            $table->foreign('season_id')
                ->references('id')->on('seasons')
                ->onDelete('cascade');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chapters');
        Schema::dropIfExists('seasons');
        Schema::dropIfExists('series');
        Schema::dropIfExists('categories_series');
    }
}
