<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function(Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('name', 45)->nullable();
            $table->integer('order')->nullable();

            $table->timestamps();

        });

        Schema::create('movies', function(Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('name', 200)->nullable();
            $table->string('cover', 250);
            $table->string('url', 250)->nullable();

            $table->timestamps();

        });

        Schema::create('categories_movies', function(Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('category_id')->unsigned();
            $table->integer('movie_id')->unsigned();
            $table->integer('order')->nullable()->default(0);

            $table->foreign('category_id')
                ->references('id')->on('categories')
                ->onDelete('cascade');

            $table->foreign('movie_id')
                ->references('id')->on('movies')
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
        Schema::dropIfExists('categories_movies');
        Schema::dropIfExists('movies');
        Schema::dropIfExists('categories');
    }
}
