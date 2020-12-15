<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->text('description')->nullable(true);
            $table->string('keywords')->nullable(true);
            $table->string('title');
            $table->string('preview');
            $table->text('text');
            $table->unsignedBigInteger('user_id');
            $table->boolean('isHidden')->default(false);
            $table->string('image')->nullable(true);
            $table->unsignedBigInteger('views')->default(0);
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
        Schema::dropIfExists('news');
    }
}
