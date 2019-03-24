<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfileActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profile_activities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('profile_id');
            $table->foreign('profile_id')
                ->references('id')->on('profiles');
            $table->unsignedInteger('likes');
            $table->unsignedInteger('comments');
            $table->unsignedInteger('follows');
            $table->unsignedInteger('unfollows');
            $table->unsignedInteger('server_calls');
            $table->dateTime('logged_at');
            $table->unique(['profile_id', 'logged_at']);
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
        Schema::dropIfExists('profile_activity');
    }
}
