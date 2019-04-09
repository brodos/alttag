<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sites', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->unsignedInteger('user_id');
            $table->string('url');
            $table->string('url_hash');
            $table->text('canonical_url')->nullable();
            $table->string('domain');
            $table->string('slug');
            $table->string('display_name');
            $table->tinyInteger('crawl');
            $table->tinyInteger('process');

            $table->timestamps();

            $table->unique(['user_id', 'slug']);

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
        Schema::dropIfExists('sites');
    }
}
