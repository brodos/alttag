<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('site_id');
            $table->unsignedInteger('url_id');
            $table->text('url');
            $table->string('url_hash', 32)->index();
            $table->text('alt');
            $table->timestamp('processed_at')->nullable();
            $table->unsignedSmallInteger('status_code')->nullable();
            $table->json('meta_data')->nullable();
            $table->json('api_data')->nullable();
            $table->timestamps();
            
            $table->foreign('site_id')->references('id')->on('sites')->onDelete('cascade');
            $table->foreign('url_id')->references('id')->on('urls')->onDelete('cascade');

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
        Schema::dropIfExists('images');
    }
}
