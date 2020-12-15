<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_categories', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('parent_id')->default(null);
            $table->string('keywords')->nullable(true);
            $table->text('description')->nullable(true);
            $table->string('name');
            $table->string('slug');
            $table->text('text')->nullable(true);
            $table->string('images')->nullable(true);
            $table->boolean('isHidden')->default(false);
            $table->unsignedBigInteger('views')->default(0);
            $table->unsignedBigInteger('user_id');
            $table->enum('source',['DL', 'noDL'])->default('DL');
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
        Schema::dropIfExists('product_categories');
    }
}
