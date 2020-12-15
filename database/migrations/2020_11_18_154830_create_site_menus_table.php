<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiteMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_menus', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('parent_id')->nullable(true);
            $table->string('name');
            $table->string('slug');
            $table->enum('place',['top','bottom']);
            $table->string('icon')->nullable(true);
            $table->unsignedBigInteger('role_id')->nullable(true);
            $table->unsignedBigInteger('status')->default('1');
            $table->unsignedBigInteger('sorting');
            $table->timestamps();
            $table->foreign('role_id')->references('id')->on('roles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('site_menus');
    }
}
