<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCrawledEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crawled_emails', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('url_id')->unsigned();
            $table->string('email');
            $table->timestamps();
            $table->foreign('url_id')->references('id')->on('crawl_links');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('crawled_emails');
    }
}
