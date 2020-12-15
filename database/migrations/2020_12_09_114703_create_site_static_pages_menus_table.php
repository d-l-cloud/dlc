<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiteStaticPagesMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_static_pages_menus', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('menuId');
            $table->unsignedBigInteger('pagesId');
            $table->unsignedBigInteger('user_id');
            $table->boolean('isHidden')->default(false);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('menuId')->references('id')->on('site_menus');
            $table->foreign('pagesId')->references('id')->on('static_pages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('site_static_pages_menus');
    }
}
