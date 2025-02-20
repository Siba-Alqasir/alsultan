<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Sections extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->string('key');
            $table->json('title')->nullable();
            $table->json('sub_title')->nullable();
            $table->json('description')->nullable();
            $table->json('btn_title')->nullable();
            $table->json('btn_link')->nullable();
            $table->text('highlight')->nullable();
            $table->json('is_required')->nullable();
            $table->json('removed_inputs')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sections');
    }
}
