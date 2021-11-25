<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

//Join table for UserProfiles many-many relationship
class CreateFollowTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('follow', function (Blueprint $table) {
            $table->primary(['userProfile_id','follows_id']);
            $table->bigInteger('userProfile_id')->unsigned();
            $table->bigInteger('follows_id')->unsigned();

            $table->foreign('userProfile_id')->references('id')->
                on('user_profiles')->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('follows_id')->references('id')->
                on('user_profiles')->onDelete('cascade')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('follow');
    }
}
