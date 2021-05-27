<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();
            $table->integer('opponent')->unsigned();
            $table->integer('game_id')->unsigned();
            $table->integer('queue_id')->unsigned();
            $table->decimal('rating');
            $table->decimal('rating_deviation');
            $table->decimal('opp_rating');
            $table->decimal('opp_rating_deviation');
            $table->integer('queue_format');
            $table->integer('queue_Bo');
            $table->integer('accepted')->nullable();
            $table->boolean('reported_winner')->nullable();
            $table->string('winner_file')->nullable();
            $table->integer('winner')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('games');
    }
}
