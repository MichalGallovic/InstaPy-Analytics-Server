<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfileProgressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profile_progress', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('profile_id');
            $table->foreign('profile_id')
                ->references('id')->on('profiles');
            $table->unsignedBigInteger('followers');
            $table->unsignedBigInteger('following');
            $table->unsignedInteger('total_posts');
            $table->dateTime('logged_at');
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
        Schema::dropIfExists('profile_progress');
    }
}
