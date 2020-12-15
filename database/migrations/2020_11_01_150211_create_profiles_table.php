<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->string('surname');
            $table->string('middle_name');
            $table->enum('male_female_other', ['0','1','2','3'])->default('0');
            $table->string('day_birth');
            $table->string('month_birth');
            $table->string('year_birth');
            $table->string('phone');
            $table->string('city');
            $table->string('country');
            $table->string('time_zone');
            $table->text('about_me')->default('');
            $table->string('profile_url')->default('');
            $table->string('avatar')->default('');
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
        Schema::dropIfExists('profiles');
    }
}
