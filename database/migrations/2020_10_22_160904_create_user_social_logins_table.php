<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSocialLoginsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_social_logins', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('user_id');
            $table->string('name')->default('');
            $table->string('id_in_soc',20)->default('');
            $table->enum('type_auth',['site', 'vk', 'odnoklassniki', 'yandex', 'telegram', 'facebook', 'google', 'apple', 'github', 'microsoft'])->default('site');
            $table->string('avatar',250)->default('');
            $table->index('id_in_soc');
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
        Schema::table('user_social_logins', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('user_social_logins');
    }
}
