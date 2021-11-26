<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserProfileUserProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profile_user_profile', function (Blueprint $table) {
            $table->primary(['user_profile_id','follows_id']);
            $table->bigInteger('user_profile_id')->unsigned();
            $table->bigInteger('follows_id')->unsigned();

            $table->foreign('user_profile_id')->references('id')->
                on('user_profiles')->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('follows_id')->references('id')->
                on('user_profiles')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_profile_user_profile');
    }
}
