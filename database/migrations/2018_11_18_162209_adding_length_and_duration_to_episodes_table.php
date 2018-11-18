<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddingLengthAndDurationToEpisodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('episodes', function (Blueprint $table) {
            $table->string('length');
            $table->string('duration');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('episodes', function (Blueprint $table) {
            $table->dropColumn('length');
            $table->dropColumn('duration');
        });
    }
}
