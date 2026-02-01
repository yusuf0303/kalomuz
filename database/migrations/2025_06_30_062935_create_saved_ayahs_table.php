<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSavedAyahsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saved_ayahs', function (Blueprint $table) {
            $table->id();
            $table->integer('surah');
            $table->integer('ayah');
            $table->string('image')->nullable();
            $table->text('text')->nullable();
            $table->boolean('sajda')->default(false);
            $table->string('audio')->nullable();
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
        Schema::dropIfExists('saved_ayahs');
    }
}
