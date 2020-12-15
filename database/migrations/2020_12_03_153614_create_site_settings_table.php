<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiteSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('city')->nullable(true);
            $table->string('address')->nullable(true);
            $table->string('geocode')->nullable(true);
            $table->string('emailNotifications')->nullable(true);
            $table->string('phone')->nullable(true);
            $table->string('workingHours')->nullable(true);
            $table->text('javaCode')->nullable(true);
            $table->unsignedBigInteger('user_id');
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
        Schema::dropIfExists('site_settings');
    }
}
