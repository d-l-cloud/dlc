<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_lists', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('article');
            $table->string('parentArticle');
            $table->unsignedBigInteger('vendorCode');
            $table->unsignedBigInteger('productCategoryId');
            $table->string('keywords')->nullable(true);
            $table->text('description')->nullable(true);
            $table->string('name');
            $table->string('slug');
            $table->text('text')->nullable(true);
            $table->text('images')->nullable(true);
            $table->boolean('isHidden')->default(false);
            $table->boolean('new')->default(false);
            $table->boolean('sale')->default(false);
            $table->unsignedBigInteger('views')->default(0);
            $table->unsignedBigInteger('user_id');
            $table->enum('source',['DL', 'noDL'])->default('DL');
            $table->float('price',10,0);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('vendorCode')->references('id')->on('product_vendors');
            $table->foreign('productCategoryId')->references('id')->on('product_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_lists');
    }
}
