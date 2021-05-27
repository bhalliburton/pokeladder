<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();
            $table->string('ptcgo_name')->unique();
            $table->decimal('rating');
            $table->decimal('rating_deviation');
            $table->decimal('rating_volatility');
            $table->decimal('temp_rating');
            $table->timestamp('last_real_rating')->nullable();
            $table->integer('queued')->unsigned();
            $table->timestamp('last_queued')->nullable();
            $table->integer('queue_format');
            $table->integer('queue_Bo');
            $table->boolean('gamed');
            $table->boolean('banned');
            $table->string('banned_comment')->nullable();
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
        Schema::dropIfExists('players');
    }
}
