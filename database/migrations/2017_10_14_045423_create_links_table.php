<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('links', function (Blueprint $table) {
            $table->increments('id');
            $table->string('url', 2083);
            $table->enum('status', [0, 1, 2]);
            $table->enum('job_status', [0, 1, 2]);
            $table->timestamps();
        });

        Schema::create('followup-links', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->unsigned();
            $table->string('url', 2083);
            $table->enum('status', [0, 1, 2]);
            $table->timestamps();
            $table->foreign('parent_id')->references('id')->on('links');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('followup-links');
        Schema::dropIfExists('links');
    }
}
