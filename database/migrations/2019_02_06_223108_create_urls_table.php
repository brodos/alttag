<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUrlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('urls', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('site_id');
            $table->unsignedInteger('parent_url_id')->nullable();
            $table->text('url');
            $table->string('url_hash', 32)->index();
            $table->timestamp('crawled_at')->nullable();
            $table->unsignedSmallInteger('status_code')->nullable();
            $table->unsignedInteger('page_size')->nullable();
            $table->string('page_title')->nullable();
            $table->json('meta_data')->nullable();
            
            $table->timestamps();

            $table->foreign('site_id')->references('id')->on('sites')->onDelete('cascade');
            $table->foreign('parent_url_id')->references('id')->on('urls')->onDelete('set null');

            $table->unique(['site_id','url_hash']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('urls');
    }
}
