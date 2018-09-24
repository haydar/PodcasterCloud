<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePodcastsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('podcasts', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('user_id')->unsigned()->index();
            $table->timestamps();
            $table->string('name',255);
            $table->string('subtitle',255);
            $table->string('description',600);
            $table->string('language',20);
            $table->string('category',50);
            $table->string('artworkImage');
            $table->string('itunesEmail',50)->nullable();
            $table->string('authorName',100)->nullable();
            $table->string('itunesSummary',600)->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('podcasts');
    }
}
