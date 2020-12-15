<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductPropertyListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_property_lists', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('propertyId');
            $table->unsignedBigInteger('productId');
            $table->text('value');
            $table->unsignedBigInteger('user_id');
            $table->enum('source',['DL', 'noDL'])->default('DL');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('propertyId')->references('id')->on('product_properties');
            $table->foreign('productId')->references('id')->on('product_lists');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_property_lists');
    }
}
