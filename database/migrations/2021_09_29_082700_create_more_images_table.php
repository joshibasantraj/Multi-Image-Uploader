<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoreImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('more_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ref_img');
            $table->foreign('ref_img')->references('id')->on('images')->onDelete('CASCADE');
            $table->string('more_image')->nullable();
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
        Schema::dropIfExists('more_images');
    }
}
