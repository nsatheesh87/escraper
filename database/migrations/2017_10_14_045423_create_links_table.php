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
        Schema::create('crawl_task', function (Blueprint $table) {
            $table->increments('id');
            $table->string('url', 2083);
            $table->enum('status', [0, 1, 2]);
            $table->timestamps();
        });

        Schema::create('crawl_links', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('task_id')->unsigned();
            $table->string('url', 2083);
            $table->enum('status', [0, 1, 2]);
            $table->timestamps();
            $table->foreign('task_id')->references('id')->on('crawl_task');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('crawl_links');
        Schema::dropIfExists('crawl_task');
    }
}
