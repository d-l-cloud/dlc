<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaticPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('static_pages', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->text('description')->nullable(true);
            $table->string('keywords')->nullable(true);
            $table->string('title');
            $table->text('text');
            $table->unsignedBigInteger('user_id');
            $table->boolean('isHidden')->default(false);
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
        Schema::dropIfExists('static_pages');
    }
}
